<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{__('Help Center')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Help Center')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button id="kt_article_button" class="btn btn-white text-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add an Article')}}</button>
                <button id="kt_category_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Category')}}</button>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_category" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_category_button" data-kt-drawer-close="#kt_category_close" data-kt-drawer-width="{'md': '900px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Create a Topic')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_category_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark">
                            <i class="bi bi-question-circle fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addCategory" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <!--begin::Thumbnail settings-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card body-->
                                    <div class="card-body text-center pt-0">
                                        <!--begin::Image input-->
                                        <!--begin::Image input placeholder-->
                                        
                                        <!--end::Image input placeholder-->

                                        <div wire:ignore class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-150px h-150px"></div>
                                            <!--end::Preview existing avatar-->

                                            <!--begin::Label-->
                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="{{__('Change avatar')}}" data-bs-original-title="{{__('Change avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-pencil-fill fs-7"></i>

                                                <!--begin::Inputs-->
                                                <input type="file" wire:model="image" id="image" accept=".png, .jpg, .jpeg, .svg" required>
                                                <input type="hidden" name="avatar_remove">
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Cancel-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="{{__('Cancel avatar')}}" data-bs-original-title="{{__('Cancel avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Cancel-->

                                            <!--begin::Remove-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="{{__('Remove avatar')}}" data-bs-original-title="{{__('Remove avatar')}}" data-kt-initialized="1">
                                                <i class="bi bi-x fs-2"></i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->

                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">{{__('Set the thumbnail image. Only *.png, *.jpg and *.jpeg image files are accepted')}}</div>
                                        <div wire:loading wire:target="image" class="fs-7">{{__('Uploading')}}...</div>
                                        @error('image')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="fv-row mb-6">
                                    <input class="form-control form-control-solid" type="text" wire:model.defer="cat_name" required placeholder="{{__('Name of category')}}" />
                                    @error('cat_name')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <textarea class="form-control form-control-solid" rows="4" type="text" wire:model.defer="cat_description" required placeholder="{{__('Description')}}"></textarea>
                                    @error('cat_description')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="text-center mt-10">
                                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="addCategory">{{__('Create Topic')}}</span>
                                        <span wire:loading wire:target="addCategory">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_article" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_article_button" data-kt-drawer-close="#kt_article_close" data-kt-drawer-width="{'md': '700px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Write an Article')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_article_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="btn-wrapper text-center mb-3">
                    <div class="symbol symbol-100px symbol-circle me-5 mb-10">
                        <div class="symbol-label fs-1 text-dark">
                            <i class="fal fa-newspaper fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addArticle" method="post">
                        <div class="fv-row mb-6">
                            <select class="form-select form-select-solid" wire:model.defer="category">
                                <option value="">{{__('Select Category')}}</option>
                                @foreach($topics as $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <input class="form-control form-control-solid" type="text" wire:model.defer="question" required placeholder="{{__('Question')}}" />
                            @error('question')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <textarea class="form-control form-control-solid preserveLines" rows="10" type="text" wire:model.defer="answer" required placeholder="{{__('Answer')}}"></textarea>
                            @error('answer')
                            <span class="form-text text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="addArticle">{{__('Submit Article')}}</span>
                                <span wire:loading wire:target="addArticle">{{__('Processing Request...')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-lg-12 col-md-12">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="col-md-12">
                            <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search Topic')}}" />
                            </div>
                        </div>
                    </div>
                    @if($topics->count() > 0)
                    <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-7">
                                <th>{{__('S/N')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Articles')}}</th>
                                <th>{{__('Created')}}</th>
                                <th>{{__('Updated')}}</th>
                                <th class="scope"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topics as $val)
                            <tr>
                                <td>{{$loop->iteration}}.</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40px">
                                            <span class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val->image}});"></span>
                                        </div>
                                        <div class="ms-5">
                                            {{$val->name}}
                                        </div>
                                    </div>
                                </td>
                                <td>{{$val->faq_count}}</td>
                                <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                                <td>{{$val->updated_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                                <td class="text-center">
                                    <a href="{{route('topic.articles', ['topic' => $val->id])}}" class="btn btn-sm btn-secondary rounded-pill"><i class="bi bi-newspaper"></i> {{__('Articles')}}</a>
                                    <button id="kt_category_{{$val->id}}_button" class="btn btn-sm btn-whitelabel rounded-pill"><i class="bi bi-pen"></i> {{__('Edit')}}</button>
                                    <a data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-trash"></i> {{__('Delete')}}</a>
                                </td>
                            </tr>
                            <div><livewire:admin.helpcenter.edit-category :val=$val :wire:key="'kt_category_'. $val->id"></livewire:admin.helpcenter.edit-category></div>
                            @endforeach
                        </tbody>
                    </table>
                    @if($topics->total() > 0 && $topics->count() < $topics->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
                        @else
                        <div class="text-center mt-20">
                            <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                                <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                    <i class="bi bi-question-circle text-dark" style="font-size:66px;"></i>
                                </div>
                            </div>
                            <h3 class="text-dark">{{__('No Topic Found')}}</h3>
                            <p class="text-dark">{{__('We couldn\'t find any topic on helpcenter, click add category')}}</p>
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>