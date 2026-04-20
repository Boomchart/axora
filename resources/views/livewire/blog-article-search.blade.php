<form class="axora-blog-search">
    <input type="search" wire:model.defer="term" placeholder="{{ __('Search articles...') }}" class="form-control" required>
    <button wire:click.prevent="searchBlogArticles" type="submit" aria-label="{{ __('Search') }}"><i class="bi bi-search"></i></button>
</form>
