<div class="tab-pane fade <?php if(route('admin.settings', ['type' => 'payout'])==url()->current()): ?>show active <?php endif; ?>" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.withdraw.index', ['admin' => $admin])->html();
} elseif ($_instance->childHasBeenRendered('wAovbR7')) {
    $componentId = $_instance->getRenderedChildComponentId('wAovbR7');
    $componentTag = $_instance->getRenderedChildComponentTagName('wAovbR7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('wAovbR7');
} else {
    $response = \Livewire\Livewire::mount('admin.withdraw.index', ['admin' => $admin]);
    $html = $response->html();
    $_instance->logRenderedChild('wAovbR7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
</div><?php /**PATH /Applications/MAMP/htdocs/axora/resources/views/partials/admin/withdraw.blade.php ENDPATH**/ ?>