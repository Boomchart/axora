<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-12 mb-4">
                <h3 class="footer-title">{{config('app.name')}} {{__('Gift Card API')}}</h3>
                <p>{{__('The ultimate gift card API for delivering rewards and incentives instantly, globally, and securely.')}}</p>
            </div>
            <div class="col-lg-2 col-6 col-md-6 mb-4">
                <h4 class="footer-title">{{__('Product')}}</h4>
                <ul>
                    <li><a href="{{route('pricing')}}">{{__('Pricing')}}</a></li>
                    <li><a href="{{route('developer.index')}}">{{__('Documentation')}}</a></li>
                    <li><a href="{{route('developer.countries')}}">{{__('API Reference')}}</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6 col-md-6 mb-4">
                <h4 class="footer-title">{{__('Company')}}</h4>
                <ul>
                    <li><a href="{{route('about')}}">{{__('About Us')}}</a></li>
                    <li><a href="{{route('contact')}}">{{__('Contact')}}</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6 col-md-6 mb-4">
                <h4 class="footer-title">{{__('Resources')}}</h4>
                <ul>
                    <li><a href="{{route('solutions')}}">{{__('Solutions')}}</a></li>
                    <li><a href="{{route('help.center')}}">{{__('Help Center')}}</a></li>
                    <li><a href="{{route('blog.index')}}">{{__('Blog')}}</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-6 col-md-6 mb-4">
                <h4 class="footer-title">{{__('Legal')}}</h4>
                <ul>
                    <li><a href="{{route('privacy')}}">{{__('Privacy Policy')}}</a></li>
                    <li><a href="{{route('terms')}}">{{__('Terms of Service')}}</a></li>
                    <li><a href="{{route('security')}}">{{__('Security')}}</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{date('Y')}} {{config('app.name')}}. {{__('All rights reserved.')}}</p>
        </div>
    </div>
</footer>