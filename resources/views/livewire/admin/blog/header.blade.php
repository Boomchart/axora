<div>
    <div class="toolbar pb-0" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{__('Blog')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1 mb-6">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.blog', ['type' => 'articles'])}}" class="text-muted text-hover-success">{{__('Blog')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{ucwords($type)}}</li>
                </ul>
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-7 border-gray-300" id="tabs-icons-text" role="tablist">
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.blog', ['type' => 'articles'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.blog', ['type' => 'articles'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Published')}} ({{number_format_short_nc($articles)}})</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.blog', ['type' => 'draft'])==url()->current()) active @endif" id="tabs-icons-text-1-tab" href="{{route('admin.blog', ['type' => 'draft'])}}" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">{{__('Draft')}} ({{number_format_short_nc($draft)}})</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.blog', ['type' => 'category'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.blog', ['type' => 'category'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Category')}} ({{number_format_short_nc($category)}})</a>
                    </li>                    
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link text-dark @if(route('admin.blog', ['type' => 'deleted'])==url()->current()) active @endif" id="tabs-icons-text-2-tab" href="{{route('admin.blog', ['type' => 'deleted'])}}" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">{{__('Deleted')}} ({{number_format_short_nc($deleted)}})</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button id="kt_article_button" class="btn btn-success me-4"><i class="fal fa-newspaper"></i> {{__('Add article')}}</button>
            </div>
            <div wire:ignore.self id="kt_article" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_article_button" data-kt-drawer-close="#kt_article_close" data-kt-drawer-width="{'md': '1200px'}">
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
                        <div class="pb-5 mt-10 position-relative zindex-1">
                            <form class="form w-100 mb-10" wire:submit.prevent="addArticle" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!--begin::Thumbnail settings-->
                                        <div class="card card-flush py-4">
                                            <!--begin::Card body-->
                                            <div class="card-body text-center pt-0">
                                                <!--begin::Image input-->
                                                <!--begin::Image input placeholder-->
                                                <style>
                                                    .image-input-placeholder {
                                                        background-image: url({{asset('dashboard/media/svg/files/blank-image.svg')}})
                                                    }
                                                </style>
                                                <!--end::Image input placeholder-->

                                                <div wire:ignore class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                                    <!--end::Preview existing avatar-->

                                                    <!--begin::Label-->
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="{{__('Change avatar')}}" data-bs-original-title="{{__('Change avatar')}}" data-kt-initialized="1">
                                                        <i class="bi bi-pencil-fill fs-7"></i>

                                                        <!--begin::Inputs-->
                                                        <input type="file" wire:model="image" id="image" accept=".png, .jpg, .jpeg">
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
                                        <div class="fv-row mb-6">
                                            <label class="form-label text-dark fs-7">{{__('Category')}}</label>
                                            <select class="form-select form-select-solid" wire:model.defer="selectCategory" required>
                                                <option value="">{{__('Select Category')}}</option>
                                                @foreach($categoryAll as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('selectCategory')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="fv-row mb-6">
                                            <label class="form-label text-dark fs-7">{{__('Status')}}</label>
                                            <select class="form-select form-select-solid" wire:model.defer="status" required>
                                                <option value="0">{{__('Draft')}}</option>
                                                <option value="1">{{__('Published')}}</option>
                                            </select>
                                            @error('status')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="fv-row mb-6">
                                            <input class="form-control form-control-solid" type="text" wire:model="title" required placeholder="{{__('Title of article')}}" />
                                            @error('title')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="fv-row mb-6" wire:ignore>
                                            <textarea class="form-control form-control-solid tinymce" rows="10" type="text" wire:model.defer="details" placeholder="{{__('Type your text')}}"></textarea>
                                            @error('details')
                                            <span class="form-text text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <div class="text-center mt-10">
                                            <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="addArticle">{{__('Submit Article')}}</span>
                                                <span wire:loading wire:target="addArticle">{{__('Processing Request...')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script src="{{asset('asset/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('asset/tinymce/init-tinymce.js')}}"></script>
<script>
    document.addEventListener('livewire:load', function() {
        initializeTinymce('textarea.tinymce');
    });

    window.livewire.on('saved', data => {
        initializeTinymce('textarea.tinymce');
    });

    window.livewire.on('textarea.tinymce', data => {
        @this.set('details', data);
    });
</script>
@endpush