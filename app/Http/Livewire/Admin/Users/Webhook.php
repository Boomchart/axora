<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Webhook as Transactions;
use Livewire\WithPagination;
use App\Jobs\SendWebhook;
use Spatie\WebhookServer\WebhookCall;

class Webhook extends Component
{
    use WithPagination;

    public $perPage = 100;
    public $client;
    public $search = "";
    public $mode;
    public $date;
    public $sortBy = "created_at";
    public $orderBy = "desc";

    protected $listeners = ['saved' => '$refresh'];

    public function resendWebhook(Transactions $webhook)
    {
        if ($webhook->business_id) {
            if ($webhook->business->webhook_url != null) {
                WebhookCall::create()
                    ->meta([
                        'business_id' => $webhook->business->reference
                    ])
                    ->maximumTries(3)
                    ->url($webhook->business->webhook_url)
                    ->payload(json_decode($webhook->payload, true))
                    ->useSecret($webhook->business->webhook_secret)->dispatch();
                $webhook->update([
                    'resend_time' => now()->addHour(1)
                ]);
                return $this->emit('success', __('Webhook Resent'));
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
        return view('livewire.admin.users.webhook', [
            'transactions' => $page->paginate($this->perPage),
            'first' => ($page->count() > 0) ? date("m/d/Y", strtotime($page->reorder()->oldest()->first()->created_at)) : date("m/d/Y", strtotime(Carbon::now())),
            'last' => ($page->count() > 0) ? date("m/d/Y", strtotime($page->reorder()->latest()->first()->created_at)) : date("m/d/Y", strtotime(Carbon::now())),
        ]);
    }

    protected function pages()
    {
        return Transactions::with(['business'])
            ->whereBusinessId($this->client->business_id)
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
