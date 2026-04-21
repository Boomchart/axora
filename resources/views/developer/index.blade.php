@extends('developer.menu')

@section('content')
  <h1>Introduction</h1>
  <p class="lead-text">
    Welcome to the {{$set->site_name}} Cards API documentation. Our powerful gift card API enables you to integrate digital gift cards from over 3,000 global brands into your application with just a few lines of code.
  </p>

  <h2 id="overview">Overview</h2>
  <p>
    {{$set->site_name}} Cards provides a simple, RESTful API that allows developers to programmatically purchase, send, and manage digital gift cards. Whether you're building a rewards platform, an employee incentive program, or a consumer marketplace, our API makes it easy to deliver value to your users.
  </p>

  <h2 id="key-features">Key Features</h2>
  <ul>
    <li><strong>Global Coverage:</strong> Access gift cards from 3,000+ brands across 52+ countries</li>
    <li><strong>Real-time Delivery:</strong> Gift cards are delivered webhook</li>
    <li><strong>Flexible Denominations:</strong> Choose from pre-defined or custom amounts</li>
    <li><strong>Webhook Support:</strong> Receive real-time notifications for transaction updates</li>
    <li><strong>Developer-Friendly:</strong> RESTful JSON API with comprehensive documentation</li>
  </ul>

  <div class="info-box note">
    <div class="info-box-title">
      <i class="bi bi-info-circle"></i>
      Getting Started
    </div>
    <p>
      To get started with the {{$set->site_name}} Cards API, you'll need to <a href="">sign up for an account</a> and obtain your API keys. Once you have your credentials, you can start making API calls immediately.
    </p>
  </div>

  <h2 id="base-url">Base URL</h2>
  <p>All API requests should be made to:</p>

  <div class="code-block-wrapper">
    <div class="code-block-header">
      <span class="code-block-title">Base URL</span>
      <button class="code-copy-button">Copy</button>
    </div>
    <pre><code class="language-bash">{{config('app.url').'/api/v1'}}</code></pre>
  </div>

  <h2 id="authentication">Authentication</h2>
  <p>
    The {{$set->site_name}} Cards API uses API keys to authenticate requests. You can view and manage your API keys in the <a href="{{route('user.dashboard')}}" target="_blank">Dashboard</a>. Your API keys carry many privileges, so be sure to keep them secure!
  </p>

  <p>
    Authentication to the API is performed via HTTP Bearer authentication. Provide your API key in the Authorization header:
  </p>

  <div class="code-block-wrapper">
    <div class="code-block-header">
      <span class="code-block-title">Example Request</span>
      <button class="code-copy-button">Copy</button>
    </div>
    <pre><code class="language-bash">curl {{config('app.url').'/api/v1/balance'}} \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json"</code></pre>
  </div>

  <h2 id="rate-limits">Rate Limits</h2>
  <p>
    The {{$set->site_name}} Cards API has rate limits to ensure fair usage and system stability. The default rate limit is:
  </p>

  <ul>
    <li><strong>Production:</strong> 100 requests per minute</li>
    <li><strong>Sandbox:</strong> 50 requests per minute</li>
  </ul>

  <div class="info-box warning">
    <div class="info-box-title">
      <i class="bi bi-exclamation-triangle"></i>
      Rate Limit Headers
    </div>
    <p>
      All API responses include headers that indicate your current rate limit status:
    </p>
    <ul>
      <li><code>X-RateLimit-Limit</code>: Maximum requests per minute</li>
      <li><code>X-RateLimit-Remaining</code>: Remaining requests in current window</li>
      <li><code>X-RateLimit-Reset</code>: Time when the rate limit resets (Unix timestamp)</li>
    </ul>
  </div>

  <h2 id="support">Support</h2>
  <p>
    Need help? We're here for you:
  </p>

  <ul>
    <li><strong>Email:</strong> {{$set->email}}</li>
    <li><strong>Documentation:</strong> <a href="">{{route('developer.index')}}</a></li>
  </ul>

  <div class="info-box success">
    <div class="info-box-title">
      <i class="bi bi-check-circle"></i>
      Ready to Get Started?
    </div>
    <p>
      Head over to the <a href="{{url('/docs/authentication')}}">Authentication</a> page to learn how to authenticate your API requests, or jump straight to the <a href="{{url('/api-reference/countries')}}">API Reference</a> to start building.
    </p>
  </div>
@endsection