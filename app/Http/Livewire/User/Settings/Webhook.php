<?php

namespace App\Http\Livewire\User\Settings;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Webhook as Transactions;
use App\Models\CardIssued;
use Livewire\WithPagination;
use App\Jobs\SendWebhook;
use App\Jobs\Webhook\Issue;
use App\Jobs\Webhook\Redemption;

class Webhook extends Component
{
    use WithPagination;

    public $perPage = 100;
    public $user;
    public $search;
    public $mode;
    public $date;
    public $sortBy = "created_at";
    public $orderBy = "desc";

    protected $listeners = ['saved' => '$refresh'];

    public function resendWebhook(Transactions $webhook)
    {
        $issue = \App\Models\CardIssued::whereId($webhook->reference)->first();
        if (now() < $webhook->resend_time) {
            return $this->emit('alert', __('You can resend webhook after') . ' ' . $webhook->resend_time->setTimezone($this->user->user_timezone)->toDayDateTimeString());
        }
        if ($issue->business_id) {
            if ($issue->business->webhook_url != null) {
                if (json_decode($webhook->payload, true)['event'] == 'issued') {
                    dispatch(new Issue($issue));
                    $webhook->update([
                        'resend_time' => now()->addHour(1)
                    ]);
                    return $this->emit('success', __('Webhook Resent'));
                }
                if (json_decode($webhook->payload, true)['event'] == 'redemption') {
                    dispatch(new Redemption($issue, json_decode($webhook->payload, true)['data']['processed_amount'], json_decode($webhook->payload, true)['data']['balance']));
                    $webhook->update([
                        'resend_time' => now()->addHour(1)
                    ]);
                    return $this->emit('success', __('Webhook Resent'));
                }
            }
        }
        return $this->emit('alert', __('Resending Webhook Failed'));
    }

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function render()
    {
        $page = $this->pages();
        return view('livewire.user.settings.webhook', [
            'total' => $page->count(),
            'transactions' => $page->simplePaginate($this->perPage),
            'first' => Carbon::now()->sub('1 month')->format('m/d/Y'),
            'last' => Carbon::now()->format('m/d/Y'),
        ]);
    }

    protected function pages()
    {
        return Transactions::with(['business'])
            ->whereBusinessId($this->user->business_id)
            ->when($this->search, function ($query) {
                $this->emit('drawer');
                $query->where(function ($query) {
                    $query->Where('reference', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->search == null, function ($query) {
                $this->emit('searchdrawer');
            })
            ->when(($this->date != null), function ($query) {
                $from = Carbon::create(explode('-', $this->date)[0]);
                $to = Carbon::create(explode('-', $this->date)[1])->addDay(1);
                if ($from != $to) {
                    return $query->whereBetween('created_at', [$from, $to]);
                } else {
                    return $query->where('created_at', '>=', $from);
                }
            }, function ($query) {
                return $query->where('created_at', '>', Carbon::now()->subMonths(6)->endOfDay());
            })
            ->when(($this->mode != null), function ($query) {
                return $query->whereMode($this->mode);
            })
            ->orderby($this->sortBy, $this->orderBy);
    }
}
