<section class="axora-help-hero text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <span class="axora-help-badge"><i class="bi bi-life-preserver"></i>{{ __('Help Center') }}</span>
                <h1 class="axora-help-title">{{ __('How can we help?') }}</h1>
                <p class="axora-help-subtitle">{{ __('Find quick answers, helpful guides, and support articles about using ') . $set->site_name . __(' for gift card API integrations, business workflows, and platform support.') }}</p>

                <form class="axora-help-search" autocomplete="off">

                    <div class="input-group input-group-lg">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input wire:model.defer="term" id="term" class="form-control px-2" type="text" placeholder="{{ __('Search help articles, topics, or questions') }}..." required>

                        <span class="input-group-text pe-2"><button class="btn btn-primary" type="submit" wire:click.prevent="searchArticles">{{ __('Search') }}</button></span>
                    </div>

                    @error('term')
                    <span class="d-block mt-2 text-danger small">{{ $message }}</span>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</section>