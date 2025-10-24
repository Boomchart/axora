<?php

namespace App\Http\Livewire\Admin\Staff;

use Livewire\Component;

class Edit extends Component
{
    public $val;

    protected $rules = [
        'val.first_name' => ['required', 'string', 'max:255'],
        'val.last_name' => ['required', 'string', 'max:255'],
        'val.username' => ['required', 'string', 'max:255'],
        'val.timezone' => ['required'],
        'val.profile' => ['nullable', 'boolean'],
        'val.deposit' => ['nullable', 'boolean'],
        'val.payout' => ['nullable', 'boolean'],
        'val.promo' => ['nullable', 'boolean'],
        'val.support' => ['nullable', 'boolean'],
        'val.language' => ['nullable', 'boolean'],
        'val.news' => ['nullable', 'boolean'],
        'val.message' => ['nullable', 'boolean'],
        'val.rfi' => ['nullable', 'boolean'],
        'val.knowledge_base' => ['nullable', 'boolean'],
        'val.email_configuration' => ['nullable', 'boolean'],
        'val.general_settings' => ['nullable', 'boolean'],
        'val.profile' => ['nullable', 'boolean'],
        'val.giftcard' => ['nullable', 'boolean'],
        'val.firewall' => ['nullable', 'boolean'],
        'val.email' => ['required', 'email:rfc,dns', 'max:255'],
        'val.decline_compliance' => ['nullable', 'boolean'],
        'val.approve_compliance' => ['nullable', 'boolean'],
        'val.unblock_user' => ['nullable', 'boolean'],
        'val.block_user' => ['nullable', 'boolean'],
        'val.unban_user' => ['nullable', 'boolean'],
        'val.ban_user' => ['nullable', 'boolean'],
        'val.rev_share' => ['nullable', 'boolean'],
        'val.edit_password' => ['nullable', 'boolean'],
        'val.edit_balance' => ['nullable', 'boolean'],
        'val.api_error' => ['nullable', 'boolean'],
    ];

    public function mount()
    {
        $this->val->profile = (bool) $this->val->profile;
        $this->val->promo = (bool) $this->val->promo;
        $this->val->deposit = (bool) $this->val->deposit;
        $this->val->payout = (bool) $this->val->payout;
        $this->val->support = (bool) $this->val->support;
        $this->val->news = (bool) $this->val->news;
        $this->val->message = (bool) $this->val->message;
        $this->val->rfi = (bool) $this->val->rfi;
        $this->val->knowledge_base = (bool) $this->val->knowledge_base;
        $this->val->email_configuration = (bool) $this->val->email_configuration;
        $this->val->general_settings = (bool) $this->val->general_settings;
        $this->val->language = (bool) $this->val->language;
        $this->val->giftcard = (bool) $this->val->giftcard;
        $this->val->firewall = (bool) $this->val->firewall;
        $this->val->decline_compliance = $this->val->decline_compliance;
        $this->val->approve_compliance = $this->val->approve_compliance;
        $this->val->unblock_user = $this->val->unblock_user;
        $this->val->block_user = $this->val->block_user;
        $this->val->unban_user = $this->val->unban_user;
        $this->val->ban_user = $this->val->ban_user;
        $this->val->rev_share = $this->val->rev_share;
        $this->val->edit_password = $this->val->edit_password;
        $this->val->edit_balance = $this->val->edit_balance;
        $this->val->api_error = $this->val->api_error;
    }

    public function delete()
    {
        $this->val->delete();
        $this->emit('saved');
        $this->emit('closeModal', 'delete' . $this->val->id);
    }

    public function update()
    {
        $this->validate();
        $this->val->update([
            'username' => $this->val->username,
            'first_name' => $this->val->first_name,
            'last_name' => $this->val->last_name,
            'timezone' => $this->val->timezone,
            'profile' => $this->val->profile,
            'deposit' => $this->val->deposit,
            'payout' => $this->val->payout,
            'promo' => $this->val->promo,
            'support' => $this->val->support,
            'news' => $this->val->news,
            'message' => $this->val->message,
            'rfi' => $this->val->rfi,
            'knowledge_base' => $this->val->knowledge_base,
            'email_configuration' => $this->val->email_configuration,
            'general_settings' => $this->val->general_settings,
            'language' => $this->val->language,
            'giftcard' => $this->val->giftcard,
            'firewall' => $this->val->firewall,
            'email' => $this->val->email,
            'decline_compliance' => $this->val->decline_compliance,
            'approve_compliance' => $this->val->approve_compliance,
            'unblock_user' => $this->val->unblock_user,
            'block_user' => $this->val->block_user,
            'unban_user' => $this->val->unban_user,
            'ban_user' => $this->val->ban_user,
            'rev_share' => $this->val->rev_share,
            'edit_password' => $this->val->edit_password,
            'edit_balance' => $this->val->edit_balance,
            'api_error' => $this->val->api_error,
        ]);
        $this->emitUp('saved');
        $this->emit('success', __('Staff updated'));
    }

    public function render()
    {
        return view('livewire.admin.staff.edit');
    }
}
