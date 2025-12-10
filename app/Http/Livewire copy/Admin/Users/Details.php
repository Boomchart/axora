<?php

namespace App\Http\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\Admin;
use App\Models\Settings;
use App\Models\Transactions;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Details extends Component
{
    public $client;
    public $amount;
    public $password;
    public $trxtype = 'credit';
    public $admin;
    public $result;

    protected $listeners = ['saved' => '$refresh'];

    public function updatedAmount()
    {
        $balance = $this->client->getFirstBalance();
        $this->result = ($this->trxtype == 'credit') ? (float) $balance->amount + (float) $this->amount : (float) $balance->amount - (float) $this->amount;
        $this->emit('saved');
    }

    public function editBalance()
    {
        $this->validate(
            [
                'amount' => 'required|numeric',
                'password' => ['required'],
            ]
        );
        $set = Settings::find(1);
        $this->amount = removeCommas($this->amount);
        if (Hash::check($this->password, $this->admin->password)) {
            $balance = $this->client->getFirstBalance();
            $object = [
                'user_id' => $this->client->id,
                'business_id' => $this->client->business_id,
                'amount' => $this->amount,
                'ref_id' => Str::uuid(),
                'trx_type' => $this->trxtype,
                'type' => 'acccount_' . $this->trxtype . '_by_' . $set->site_name,
                'status' => 'success',
            ];
            $trx = Transactions::create($object);
            if ($this->trxtype == 'debit') {
                $balance->update(['amount' => $balance->amount - $this->amount]);
            } else {
                $balance->update(['amount' => $balance->amount + $this->amount]);
            }
            createAudit('acccount_' . $this->trxtype . '_by_' . $set->site_name . ' ' . $trx->ref_id, $this->client, null, $this->admin->id);
            $this->emit('success', __('Balance updated'));

            $this->reset(['password']);
            $this->emit('drawer');
            $this->emit('saved');
        } elseif (!Hash::check($this->password, $this->admin->password)) {
            $this->addError('password', __('Invalid password'));
        }
    }

    public function render()
    {
        return view('livewire.admin.users.details');
    }
}
