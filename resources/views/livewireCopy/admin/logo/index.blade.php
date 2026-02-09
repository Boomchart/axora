<div>
    <div class="alert alert-warning mb-5">
        <div class="d-flex flex-column">
            <p class="mb-0 text-dark fs-7"><i class="bi bi-info-circle text-dark"></i> {{__('Clear browser cache after uploading logo & favicon')}}</p>
        </div>
    </div>
    <div class="row mb-6">
        <div class="col-md-12 mb-10">
            <div class="card">
                <div class="card-body">
                    <h4 class="fw-bold fs-6 mb-6">{{__('CSS Settings')}}</h4>
                    <form action="{{route('logo.upload', ['type' => 'css'])}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Home page CSS')}}</label>
                            <textarea class="form-control form-control-solid form-control-md" rows="1" name="home_light_css" placeholder="{{__('Home page CSS')}}">{{getUi()->home_light_css}}</textarea>
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Authentication pages CSS')}}</label>
                            <textarea class="form-control form-control-solid form-control-md" rows="1" name="light_css" placeholder="{{__('Authentication pages CSS')}}">{{getUi()->light_css}}</textarea>
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Dashboard CSS')}}</label>
                            <textarea class="form-control form-control-solid form-control-md" rows="1" name="dashboard_light_css" placeholder="{{__('Dashboard CSS')}}">{{getUi()->dashboard_light_css}}</textarea>
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Email CSS')}}</label>
                            <textarea class="form-control form-control-solid form-control-md" rows="1" name="email_light_css" placeholder="{{__('Email CSS')}}">{{getUi()->email_light_css}}</textarea>
                        </div>
                        <hr class="bg-light">
                        <h4 class="fw-bold fs-6 mb-6">{{__('Logo Type')}}</h4>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Dashboard logo')}}</label>
                            <select class="form-select form-select-solid" name="dashboard_logo" required>
                                <option value="logo" @if(getUi()->dashboard_logo == 'logo') selected @endif>{{__('Light')}}</option>
                                <option value="dark_logo" @if(getUi()->dashboard_logo == 'dark_logo') selected @endif>{{__('Dark')}}</option>
                            </select>
                        </div>
                        <div class="fv-row mb-6">
                            <label class="form-label text-dark fs-7">{{__('Homepage logo')}}</label>
                            <select class="form-select form-select-solid" name="homepage_logo" required>
                                <option value="logo" @if(getUi()->homepage_logo == 'logo') selected @endif>{{__('Light')}}</option>
                                <option value="dark_logo" @if(getUi()->homepage_logo == 'dark_logo') selected @endif>{{__('Dark')}}</option>
                            </select>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">{{ __('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-10">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="fw-bold fs-5 mb-6">{{__('Light Logo')}}</h4>
                    <form action="{{route('logo.upload', ['type' => 'light'])}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="fv-row mb-6">
                            <input type="file" class="form-control form-control-solid form-control-md" name="image" lang="en">
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success btn-block">{{ __('Upload')}}</button>
                        </div>
                    </form>
                    <div class="card bg-secondary mt-10">
                        <div class="card-body text-center">
                            <div class="card-img-actions d-inline-block mb-3">
                                <img class="img-fluid" src="{{asset('asset/images/logo.png')}}" style="max-width:100%;height:auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-10">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="fw-bold fs-5 mb-6">{{__('Dark Logo')}}</h4>
                    <form action="{{route('logo.upload', ['type' => 'dark'])}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="fv-row mb-6">
                            <input type="file" class="form-control form-control-solid form-control-md" name="image" lang="en">
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success btn-block">{{ __('Upload')}}</button>
                        </div>
                    </form>
                    <div class="card bg-dark mt-10">
                        <div class="card-body text-center">
                            <div class="card-img-actions d-inline-block mb-3">
                                <img class="img-fluid" src="{{asset('asset/images/dark_logo.png')}}" style="max-width:100%;height:auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-10">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="fw-bold fs-5 mb-6">{{ __('Favicon')}}</h4>
                    <form action="{{route('logo.upload', ['type' => 'favicon'])}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="fv-row mb-6">
                            <input type="file" class="form-control form-control-solid form-control-md" name="image" lang="en">
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success btn-block">{{ __('Upload')}}</button>
                        </div>
                    </form>
                    <div class="card mt-10">
                        <div class="card-body text-center">
                            <div class="card-img-actions d-inline-block mb-3">
                                <img class="img-fluid" src="{{asset('asset/images/favicon.png')}}" style="max-width:100%;height:auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>