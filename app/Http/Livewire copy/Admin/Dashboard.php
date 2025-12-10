<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Component
{
    public $admin;
    public $date;
    public $first;
    public $last;
    public $perPage = 15;

    protected $listeners = ['launchChart'];

    public function launchChart()
    {
        // Cache key based on date range
        $cacheKey = "dashboard_chart_" . md5($this->date ?? 'default');

        $stats = Cache::get($cacheKey);

        if (!$stats) {
            dispatch(new \App\Jobs\Admin\CalculateDashboardChartJob($cacheKey, $this->getDateRange()));
        } else {
            // Always emit the chart data (whether from cache or fresh)
            return $this->emit('loadChart', $stats);
        }
    }

    public function updatedDate()
    {
        // Clear cache when date changes
        Cache::forget("dashboard_chart_" . md5($this->date ?? 'default'));
        Cache::forget("dashboard_stats_" . md5($this->date ?? 'default'));

        $this->launchChart();
    }

    public function mount()
    {
        $this->first = Carbon::now()->subMonths(1)->endOfDay()->format("m/d/Y");
        $this->last = Carbon::now()->format("m/d/Y");
        $this->date = $this->first . ' - ' . $this->last;
    }

    private function getDateRange()
    {
        if ($this->date) {
            $dates = explode(' - ', $this->date);
            $from = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
            $to = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
        } else {
            $from = Carbon::now()->subMonths(1)->startOfDay();
            $to = Carbon::now()->endOfDay();
        }

        return [$from, $to];
    }

    public function render()
    {
        $cacheKey = "dashboard_stats_" . md5($this->date ?? 'default');

        $stats = Cache::get($cacheKey);

        if (!$stats) {
            // Dispatch background job to calculate stats
            dispatch(new \App\Jobs\Admin\CalculateDashboardStatsJob($cacheKey, $this->getDateRange()));

            // Return default values while job processes
            $stats = [
                'successLogs' => 'Loading...',
                'clientLogs' => 'Loading...',
                'serverLogs' => 'Loading...',
                'loading' => true
            ];
        }

        return view('livewire.admin.dashboard', array_merge($stats, [
            'first' => $this->first,
            'last' => $this->last,
        ]));
    }
}
