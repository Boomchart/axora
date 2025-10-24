<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-10">
                <div class="card-body">
                    <h4 class="fw-bold fs-5 mb-6">{{__('Homepage Features')}}</h4>
                    <form action="{{route('admin.settings.update', ['type' => 'features'])}}" method="post">
                        @csrf
                        <div class="form-check form-check-custom form-check-solid mb-6">
                            <input class="form-check-input" type="checkbox" id="homepage" name="homepage" value="1" @if($set->homepage==1)checked @endif />
                            <label class="form-check-label" for="homepage">{{__('Homepage - This is will use software default homepage, disable this to make login screen default')}}</label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-6">
                            <input class="form-check-input" type="checkbox" id="team" name="team" value="1" @if($set->team==1)checked @endif />
                            <label class="form-check-label" for="team">{{__('Team')}}</label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-6">
                            <input class="form-check-input" type="checkbox" id="brands" name="brands" value="1" @if($set->brands==1)checked @endif />
                            <label class="form-check-label" for="brands">{{__('Brands')}}</label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-6">
                            <input class="form-check-input" type="checkbox" id="services" name="services" value="1" @if($set->services==1)checked @endif />
                            <label class="form-check-label" for="services">{{__('Services')}}</label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid mb-6">
                            <input class="form-check-input" type="checkbox" id="reviews" name="reviews" value="1" @if($set->reviews==1)checked @endif />
                            <label class="form-check-label" for="reviews">{{__('Reviews')}}</label>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success me-3 my-2">{{__('Update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="fw-bold fs-5 mb-6">{{__('Homepage content')}}</h4>
                    <form action="{{route('homepage.update')}}" method="post">
                        @csrf
                        <div class="fv-row mb-6">
                            <div class="col-lg-12">
                                <input type="text" name="h1_t" class="form-control form-control-md form-control-solid" value="{{$ui->h1_t}}">
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <div class="col-lg-12">
                                <textarea type="text" name="h1_b" rows="4" class="form-control form-control-md form-control-solid">{{$ui->h1_b}}</textarea>
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <div class="col-lg-12">
                                <input type="text" name="h2_t" class="form-control form-control-md form-control-solid" value="{{$ui->h2_t}}">
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <div class="col-lg-12">
                                <textarea type="text" name="h2_b" rows="4" class="form-control form-control-md form-control-solid">{{$ui->h2_b}}</textarea>
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <div class="col-lg-12">
                                <input type="text" name="h3_t" class="form-control form-control-md form-control-solid" value="{{$ui->h3_t}}">
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <div class="col-lg-12">
                                <textarea type="text" name="h3_b" rows="4" class="form-control form-control-md form-control-solid">{{$ui->h3_b}}</textarea>
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <div class="col-lg-12">
                                <input type="text" name="h4_t" class="form-control form-control-md form-control-solid" value="{{$ui->h4_t}}">
                            </div>
                        </div>
                        <div class="fv-row mb-6">
                            <div class="col-lg-12">
                                <textarea type="text" name="h4_b" rows="4" class="form-control form-control-md form-control-solid">{{$ui->h4_b}}</textarea>
                            </div>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">{{__('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-6">
                <div class="card-body text-center">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img style="max-width:100%; height:auto;" src="{{asset('asset/images/'.$ui->image1)}}" alt="">
                    </div>
                    <form action="{{route('section.image', ['section' => 1])}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="fv-row mb-6">
                            <input type="file" name="image" class="form-control form-control-md form-control-solid" required>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">{{__('Update Image')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-6">
                <div class="card-body text-center">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img style="max-width:100%; height:auto;" src="{{asset('asset/images/'.$ui->image2)}}" alt="">
                    </div>
                    <form action="{{route('section.image', ['section' => 2])}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="fv-row mb-6">
                            <input type="file" name="image" class="form-control form-control-md form-control-solid" required>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">{{__('Update Image')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-6">
                <div class="card-body text-center">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img style="max-width:100%; height:auto;" src="{{asset('asset/images/'.$ui->image3)}}" alt="">
                    </div>
                    <form action="{{route('section.image', ['section' => 3])}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="fv-row mb-6">
                            <input type="file" name="image" class="form-control form-control-md form-control-solid" required>
                        </div>
                        <div class="text-start">
                            <button type="submit" class="btn btn-success">{{__('Update Image')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>