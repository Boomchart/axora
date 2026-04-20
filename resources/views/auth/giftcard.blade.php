@extends('auth.menu')

@section('content')
    <div class="auth-giftcard-page">
        <div class="auth-giftcard-card">
            <div class="auth-giftcard-header">
                <div class="auth-giftcard-logo-wrap">
                    <div class="auth-giftcard-logo" style="background-image: url('{{ url('/') . '/storage/app/' . $card->rate->rateCountry->buyGiftcard->logo }}');"></div>
                </div>

                @if($card->mode == 'test')
                    <div class="auth-test-badge">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ __('Test generated card. This cannot be used in a real transaction.') }}
                    </div>
                @endif

                <img src="{{ url('/') . '/storage/app/' . $card->rate->rateCountry->buyGiftcard->image }}" alt="{{ $card->rate->rateCountry->buyGiftcard->title }}" loading="lazy" class="auth-giftcard-image">

                <p class="auth-giftcard-amount">
                    {{ $card->rate->rateCountry->country->currency_symbol . currencyFormat(number_format($card->rate->amount, 2)) }}
                </p>

                <h1 class="auth-giftcard-title">
                    {{ $card->rate->rateCountry->buyGiftcard->title }}
                </h1>
            </div>

            <div class="auth-giftcard-code-box">
                <label class="auth-giftcard-code-label">{{ __('Gift Card Code') }}</label>

                <div class="auth-giftcard-code-group">
                    <input value="{{ $card->code }}" autocomplete="off" readonly class="form-control auth-giftcard-code-input">

                    <button type="button" class="auth-giftcard-copy-btn castro-copy" data-clipboard-text="{{ $card->code }}" title="{{ __('Copy') }}">
                        <i class="bi bi-clipboard-check"></i>
                    </button>
                </div>
            </div>

            <div class="auth-giftcard-content">
                <div class="auth-giftcard-section">
                    <h3>{{ __('Redemption Instructions') }}</h3>
                    <p class="preserveLines">{{ $card?->rate?->rateCountry?->buyGiftcard?->redemption_instructions }}</p>
                </div>

                <div class="auth-giftcard-section">
                    <h3>{{ __('Description') }}</h3>
                    <p class="preserveLines">{{ $card?->rate?->rateCountry?->buyGiftcard?->description }}</p>
                </div>

                <div class="auth-giftcard-section">
                    <h3>{{ __('Terms & Conditions') }}</h3>
                    <p class="preserveLines">{{ $card?->rate?->rateCountry?->buyGiftcard?->terms }}</p>
                </div>
            </div>
        </div>

        <div class="auth-giftcard-footer">
            <a href="{{ route('home') }}" target="_blank">
                {{ __('Powered by') }} {{ $set->site_name }}
            </a>
        </div>
    </div>
@stop