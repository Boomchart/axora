<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\Business;

class Index extends Component
{
    private $clients;
    public $settings;
    public $admin;
    public $type;
    public $title;
    public $kyc;
    public $status;
    public $email_verified;
    public $phone_verified;
    public $search;
    public $perPage = 10;
    public $orderBy = "created_at";
    public $sortBy = "desc";
    public $country;
    public $countries;
    private $allusers;
    private $agents;
    private $businesses;
    private $deletedusers;

    protected $listeners = ['saved' => '$refresh'];

    public function loadMore()
    {
        $this->perPage = $this->perPage + $this->perPage;
        $this->emit('drawer');
    }

    public function block(User $user)
    {
        $user->update(['status' => 1]);
        $this->emit('success', __('User blocked'));
        $this->emitUp('saved');
    }

    public function unblock(User $user)
    {
        $user->update(['status' => 0]);
        $this->emit('success', __('User enabled'));
        $this->emitUp('saved');
    }

    public function render()
    {
        $this->allusers = User::all()->count();
        $this->agents = Business::whereAgent(1)->count();
        $this->businesses = Business::whereAgent(0)->count();
        $this->deletedusers = User::onlyTrashed()->count();
        $this->clients = User::when($this->search, function ($query) {
            $this->emit('drawer');
            $searchTerm = str_replace('-', '', str_replace('+', '', str_replace('@', '', $this->search)));
            return $query->whereRaw("MATCH(first_name, last_name, email, phone, business_id) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
        })->when($this->search == null, function ($query) {
            $this->emit('searchdrawer');
        })
            ->when($this->status, function ($query) {
                return $query->whereStatus($this->status);
            })
            ->when($this->email_verified, function ($query) {
                return $query->whereEmailVerify($this->email_verified);
            })
            ->when($this->phone_verified, function ($query) {
                return $query->wherePhoneVerify($this->phone_verified);
            })
            ->when($this->kyc, function ($query) {
                return $query->whereRelation('business', 'kyc_status', '=', $this->kyc);
            })
            ->when($this->type == 'kyc', function ($query) {
                return $query->whereRelation('business', 'kyc_status', '=', 'PROCESSING');
            })
            ->when($this->type == 'agents', function ($query) {
                return $query->whereRelation('business', 'agent', '=', 1);
            })            
            ->when($this->type == 'businesses', function ($query) {
                return $query->whereRelation('business', 'agent', '=', 0);
            })
            ->when($this->countries != null, function ($query) {
                return $query->whereCountryId($this->countries);
            })
            ->when($this->type == 'watchlist', function ($query) {
                return $query->whereRelation('business', 'watchlist', '=', 1);
            })
            ->when($this->type == 'deleted', function ($query) {
                return $query->onlyTrashed();
            })
            ->orderby($this->orderBy, $this->sortBy)
            ->simplePaginate($this->perPage);
        return view('livewire.admin.users.index', [
            'clients' => $this->clients,
            'allusers' => $this->allusers,
            'agents' => $this->agents,
            'businesses' => $this->businesses,
            'deletedusers' => $this->deletedusers
        ]);
    }
}
