<div class="tab-pane fade @if(route('admin.settings', ['type' => 'payout'])==url()->current())show active @endif" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
    @livewire('admin.withdraw.index', ['admin' => $admin])
</div>