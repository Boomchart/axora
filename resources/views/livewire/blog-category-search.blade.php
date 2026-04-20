<form class="axora-blog-hero-search">
    <div class="input-group input-group-lg">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input wire:model.defer="term" id="term" class="form-control" type="search" placeholder="{{ __('Search blog articles') }}..." required>
        <span class="input-group-text pe-2"><button wire:click.prevent="searchBlogArticles" class="btn btn-primary" type="submit">{{ __('Search') }}</button></span>
    </div>

    @error('term')
    <span class="d-block mt-2 text-danger small">{{ $message }}</span>
    @enderror
</form>