@extends('front.pages')
<meta name="description" content="{{ $set->site_name }} Help Center - Unified API Support" />

@section('css')
    <link href="{{asset('css/help.css')}}" rel="stylesheet">
@stop

@section('content')
    @livewire('help-search')

    <section class="axora-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="axora-section-header">
                        <p class="axora-section-kicker">{{ __('Popular Articles') }}</p>
                        <h2 class="axora-section-title">{{ __('Quick answers to common questions') }}</h2>
                        <p class="axora-section-description">{{ __('Explore the articles businesses and developers commonly read when getting started with our unified API for airtime, data bundles, crypto wallets, and gift cards.') }}</p>
                    </div>

                    <div class="axora-popular-wrap">
                        @foreach(getPopularHelpCenter(10) as $val)
                            <span class="axora-article-pill" data-href="{{ route('help.article', ['article' => $val->slug]) }}">
                                <i class="bi bi-file-text"></i>{{ $val->question }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="axora-section axora-topic-section">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10">
                    <div class="axora-section-header">
                        <p class="axora-section-kicker">{{ __('Browse by Topic') }}</p>
                        <h2 class="axora-section-title">{{ __('Find help by category') }}</h2>
                        <p class="axora-section-description">{{ __('Choose a topic below to browse guides, support articles, and useful information related to your account, API access, global payouts, and multi-asset transactions.') }}</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                @foreach(getHelpCenterTopics() as $val)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="axora-topic-card" data-href="{{ route('help.topic', ['topic' => $val->slug]) }}">
                            <div class="axora-topic-icon">
                                @php
                                    $imagePath = $val->image ? storage_path('app/' . $val->image) : null;
                                @endphp

                                @if($imagePath && file_exists($imagePath))
                                    <img src="{{ url('/') . '/storage/app/' . $val->image }}" alt="{{ $val->title }}" loading="lazy">
                                @else
                                    <div class="axora-blog-image axora-blog-image-placeholder"><i class="bi bi-journal-text"></i></div>
                                @endif
                            </div>
                            <h3>{{ $val->name }}</h3>
                            <p>{{ $val->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@stop

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-href]').forEach(function (element) {
                element.addEventListener('click', function () {
                    window.location.href = element.getAttribute('data-href');
                });
            });
        });
    </script>
@endsection