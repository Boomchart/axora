<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CalculateDashboardChartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cacheKey;
    protected $dateRange;
    protected $business;

    public function __construct($cacheKey, $dateRange, $business)
    {
        $this->cacheKey = $cacheKey;
        $this->dateRange = $dateRange;
        $this->business = $business;
    }

    public function handle()
    {
        $business = \App\Models\Business::whereReference($this->business)->first();

        [$from, $to] = $this->dateRange;

        // Single optimized query for chart data
        $rawData = DB::table('api_logs')
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('CASE 
                        WHEN status_code = 200 THEN "Success"
                        WHEN status_code IN (400, 401, 402, 403, 404) THEN "Client error"
                        WHEN status_code = 500 THEN "Server error"
                        ELSE "Other"
                    END as category'),
                DB::raw('COUNT(*) as count')
            ])
            ->where('business_id', $this->business)
            ->where('mode', $business->account_mode)
            ->whereBetween('created_at', [$from, $to])
            ->whereIn('status_code', [200, 400, 401, 402, 403, 404, 500])
            ->groupBy('date', 'category')
            ->orderBy('date')
            ->get();

        // Generate date range
        $dates = collect();
        $period = $from->toPeriod($to);
        foreach ($period as $date) {
            $dates->push($date->toDateString());
        }


        // Initialize series with zeros
        $series = [
            'Success' => array_fill_keys($dates->all(), 0),
            'Client error' => array_fill_keys($dates->all(), 0),
            'Server error' => array_fill_keys($dates->all(), 0),
        ];

        // Fill series with actual data
        foreach ($rawData as $row) {
            if (isset($series[$row->category][$row->date])) {
                $series[$row->category][$row->date] = (int) $row->count;
            }
        }

        $stats = [
            'categories' => $dates,
            'series' => collect($series)->map(function ($data, $name) use ($dates) {
                return [
                    'name' => $name,
                    'data' => $dates->map(fn($d) => $data[$d] ?? 0)->values()
                ];
            })->values(),
            'colors' => [
                'Success' => '#28a745',
                'Client error' => '#f0ad4e',
                'Server error' => '#dc3545',
            ],
        ];

        // Cache for 24 hours
        Cache::put($this->cacheKey, $stats, 86400);
    }
}
