<div class="tab-pane fade @if(route('admin.settings', ['type' => 'system'])==url()->current())show active @endif" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
    <div class="card mb-10">
        <div class="card-body">
            <form action="{{route('admin.settings.update', ['type' => 'system'])}}" method="post">
                @csrf
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Website name')}}</label>
                    <input class="form-control form-control-solid" type="text" name="site_name" value="{{$set->site_name}}" required />
                    @error('site_name')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Website email')}}</label>
                    <input class="form-control form-control-solid" type="email" name="email" value="{{$set->email}}" required />
                    <span class="form-text text-muted">{{__('Displayed on homepage')}}</span>
                    @error('email')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Support email')}}</label>
                    <input class="form-control form-control-solid" type="email" name="support_email" value="{{$set->support_email}}" required />
                    <span class="form-text text-muted">{{__('For support ticket')}}</span>
                    @error('support_email')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Mobile')}}</label>
                    <input class="form-control form-control-solid" type="text" name="mobile" value="{{$set->mobile}}" required />
                    @error('mobile')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Website title')}}</label>
                    <input class="form-control form-control-solid" type="text" name="title" value="{{$set->title}}" required />
                    @error('title')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Short description')}}</label>
                    <textarea class="form-control form-control-solid" type="text" name="site_desc" required rows="3">{{$set->site_desc}}</textarea>
                    @error('site_desc')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Livechat snippet code')}}</label>
                    <textarea class="form-control form-control-solid" type="text" name="livechat" rows="3">{{$set->livechat}}</textarea>
                    @error('livechat')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Analytics snippet code')}}</label>
                    <textarea class="form-control form-control-solid" type="text" name="analytic_snippet" rows="3">{{$set->analytic_snippet}}</textarea>
                    @error('analytic_snippet')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Career URL')}}</label>
                    <input class="form-control form-control-solid" type="url" name="career_url" value="{{$set->career_url}}" />
                    <span class="form-text text-muted">{{__('Available job positions link')}}</span>
                    @error('career_url')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <hr class="bg-light">
                <p>{{__('Platform Currency')}}</p>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Format')}}</label>
                    <select class="form-select form-select-solid" name="currency_format" required>
                        <option value="normal" @if($set->currency_format=="normal") selected @endif</option>{{__('Normal - 1,000.00')}}</option>
                        <option value="reversed" @if($set->currency_format=="reversed") selected @endif</option>{{__('Reversed - 1.000,00')}}</option>
                    </select>
                    @error('currency_format')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Default Country & Currency')}}</label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="{{__('Select Currency')}}" name="currency">
                        <option></option>
                        @foreach(getAllCountry() as $val)
                        <option value="{{$val->id}}" @if($admin->currency()->real->iso2 == $val->iso2)selected @endif>{{$val->name.' - '.$val->currency}}</option>
                        @endforeach
                    </select>
                </div>
                <hr class="bg-light">
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Super Admin Dashboard Timezone')}}</label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="{{__('Select Timezone')}}" name="admin_timezone">
                        <option></option>
                        @foreach(config('timezones') as $key => $val)
                        <option value="{{$key}}" @if($admin->timezone == $key)selected @endif>{{$key}} - {{$val}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2">{{__('Update')}}</a>
                </div>
            </form>
        </div>
    </div> 
    <div class="card mb-10">
        <div class="card-body">
            <h4 class="fw-bold fs-5 mb-6">{{__('Language')}}</h4>
            <form action="{{route('admin.settings.update', ['type' => 'language'])}}" method="post">
                @csrf
                <div class="form-check form-check-custom form-check-solid mb-6">
                    <input class="form-check-input" type="checkbox" id="language" name="language" value="1" @if($set->language==1)checked @endif />
                    <label class="form-check-label" for="language">{{__('Language translation - Enables changing language on user dashboard & homepage')}}</label>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Admin Dashboard Default')}}</label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="{{__('Select Language')}}" name="admin_language">
                        <option></option>
                        @foreach(getLang() as $val)
                        <option value="{{$val->code}}" @if($set->admin_language == $val->code)selected @endif>{{ucwords($val->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('User Dashboard Default')}}</label>
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="{{__('Select Language')}}" name="user_language">
                        <option></option>
                        @foreach(getLang() as $val)
                        <option value="{{$val->code}}" @if($set->user_language == $val->code)selected @endif>{{ucwords($val->name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2">{{__('Update')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-10">
        <div class="card-body">
            <h4 class="fw-bold fs-5 mb-6">{{__('Preloader')}}</h4>
            <form action="{{route('admin.settings.update', ['type' => 'preloader'])}}" method="post">
                @csrf
                <div class="form-check form-check-custom form-check-solid mb-6">
                    <input class="form-check-input" type="checkbox" id="preloader" name="preloader" value="1" @if($set->preloader==1)checked @endif />
                    <label class="form-check-label" for="preloader">{{__('Enable Preloader on Dashboard')}}</label>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Preloader Color')}}</label>
                    <input type="color" name="preloader_color" required class="form-control form-control-md form-control-solid" placeholder="{{__('#0000000')}}" value="{{$set->preloader_color}}" required>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2">{{__('Update')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-10">
        <div class="card-body">
            <h4 class="fw-bold fs-5 mb-6">{{__('Business Addresses')}}</h4>
            <form action="{{route('homepage.update')}}" method="post">
                @csrf
                <p>{{__('Addresses')}}</p>
                <div class="fv-row mb-6">
                    <input type="text" name="address1_t" class="form-control form-control-md form-control-solid" placeholder="Address 1 title" value="{{$ui->address1_t}}">
                </div>
                <div class="fv-row mb-6">
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Address 1 Country" name="address1_c">
                        <option></option>
                        @foreach(getAllCountry() as $val)
                        <option value="{{$val->iso2}}" @if($ui->address1_c == $val->iso2)selected @endif>{{$val->name.' '.$val->emoji}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fv-row mb-6">
                    <input type="text" name="address2_t" class="form-control form-control-md form-control-solid" placeholder="Address 2 title" value="{{$ui->address2_t}}">
                </div>
                <div class="fv-row mb-6">
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Address 2  Country" name="address2_c">
                        <option></option>
                        @foreach(getAllCountry() as $val)
                        <option value="{{$val->iso2}}" @if($ui->address2_c == $val->iso2)selected @endif>{{$val->name.' '.$val->emoji}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fv-row mb-6">
                    <input type="text" name="address3_t" class="form-control form-control-md form-control-solid" placeholder="Address 3 title" value="{{$ui->address3_t}}">
                </div>
                <div class="fv-row mb-6">
                    <select class="form-select form-select-solid" data-control="select2" data-placeholder="Select Address 3 Country" name="address3_c">
                        <option></option>
                        @foreach(getAllCountry() as $val)
                        <option value="{{$val->iso2}}" @if($ui->address3_c == $val->iso2)selected @endif>{{$val->name.' '.$val->emoji}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2">{{__('Update')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>