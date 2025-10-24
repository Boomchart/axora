@extends('admin.menu')

@section('content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <h1 class="text-dark fw-bold my-1 fs-3 mb-6">{{__('Email/SMS Template')}}</h1>
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('template.settings', ['type' => 'settings'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('template.settings', ['type' => 'settings'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Template')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('template.settings', ['type' => 'code'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('template.settings', ['type' => 'code'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Tags')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark @if(route('template.settings', ['type' => 'email-template'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('template.settings', ['type' => 'email-template'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Email Messages')}}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade @if(route('template.settings', ['type' => 'settings'])==url()->current())show active @endif" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <div class="card mb-10">
                        <div class="card-body">
                            <form action="{{route('admin.settings.update', ['type' => 'email_template'])}}" method="post">
                                @csrf
                                <h5>{{__('Template Configuration')}}</h5>
                                <div class="fv-row mb-6 mb-6">
                                    <div class="col-lg-12">
                                        <textarea type="text" name="email_template" rows="4" class="form-control tinymce">{{$set->email_template}}</textarea>
                                    </div>
                                </div>
                                <div class="text-start">
                                    <button type="submit" class="btn btn-success">{{__('Save')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if(route('template.settings', ['type' => 'code'])==url()->current())show active @endif" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <div class=" mb-10">
                        <div class="card-body">
                            <p class="fs-7 mb-7">{{__('Tags are replaced by software with real data when email or sms is sent to users')}}</p>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" id="kt_datatable_example_5">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('Tag')}}</th>
                                            <th>{{__('DESCRIPTION')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> 1. </td>
                                            <td> &#123;&#123;site_name&#125;&#125; </td>
                                            <td> {{__('Website Name')}}</td>
                                        </tr>
                                        <tr>
                                            <td> 2. </td>
                                            <td> &#123;&#123;unsubscribe&#125;&#125; </td>
                                            <td> {{__('Unsubscribe link for promotional emails')}}</td>
                                        </tr>
                                        <tr>
                                            <td> 3. </td>
                                            <td> &#123;&#123;token&#125;&#125; </td>
                                            <td> {{__('Authentication Token')}}</td>
                                        </tr>
                                        <tr>
                                            <td> 4. </td>
                                            <td> &#123;&#123;reason&#125;&#125; </td>
                                            <td> {{__('Transaction or KYC Decline Response')}}</td>
                                        </tr>
                                        <tr>
                                            <td> 5. </td>
                                            <td> &#123;&#123;first_name&#125;&#125; </td>
                                            <td> {{__('User First name')}}</td>
                                        </tr>
                                        <tr>
                                            <td> 6. </td>
                                            <td> &#123;&#123;last_name&#125;&#125; </td>
                                            <td> {{__('User Last name')}}</td>
                                        </tr>
                                        <tr>
                                            <td> 7. </td>
                                            <td> &#123;&#123;amount&#125;&#125; </td>
                                            <td> {{__('Transaction Amount')}}</td>
                                        </tr>
                                        <tr>
                                            <td> 8. </td>
                                            <td> &#123;&#123;charge&#125;&#125; </td>
                                            <td> {{__('Transaction Charge')}}</td>
                                        </tr>
                                        <tr>
                                            <td> 9. </td>
                                            <td> &#123;&#123;reference&#125;&#125; </td>
                                            <td> {{__('Transaction Reference')}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if(route('template.settings', ['type' => 'email-template'])==url()->current())show active @endif" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                    <div class="card-body">
                        @livewire('admin.template.index', ['type' => 0, 'settings' => $set, 'admin' => $admin])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
@if(route('template.settings', ['type' => 'settings'])==url()->current())
<script src="{{asset('asset/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('asset/tinymce/init-tinymce.js')}}"></script>
<script>
    initializeTinymce('textarea.tinymce');
</script>
@endif
@endsection