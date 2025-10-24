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

class CalculateDashboardStatsJob implements ShouldQueue
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

        $statsQuery = DB::table('api_logs')
            ->select([
                DB::raw('COUNT(CASE WHEN status_code = 200 THEN 1 END) as success_count'),
                DB::raw('COUNT(CASE WHEN status_code IN (400, 401, 402, 403, 404) THEN 1 END) as client_error_count'),
                DB::raw('COUNT(CASE WHEN status_code = 500 THEN 1 END) as server_error_count')
            ])
            ->where('business_id', $this->business)
            ->where('mode', $business->account_mode)
            ->whereBetween('created_at', [$from, $to])
            ->first();

        $stats = [
            'successLogs' => $statsQuery->success_count ?? 0,
            'clientLogs' => $statsQuery->client_error_count ?? 0,
            'serverLogs' => $statsQuery->server_error_count ?? 0,
            'loading' => false
        ];

        // Cache for 24 hours
        Cache::put($this->cacheKey, $stats, 86400);
    }
}
