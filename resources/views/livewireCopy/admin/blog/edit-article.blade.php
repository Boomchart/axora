<div>
    <div wire:ignore.self id="kt_edit_{{$val->id}}" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_edit_{{$val->id}}_button" data-kt-drawer-close="#kt_edit_{{$val->id}}_close" data-kt-drawer-width="{'md': '1200px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-4 text-gray-900 text-hover-success me-1 lh-1">{{__('Edit Article')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_edit_{{$val->id}}_close">
                        <span class="svg-icon svg-icon-2">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body text-wrap">
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" method="post" wire:submit.prevent="update">
                        <div class="row">
                            <div class="col-md-4">
                                <!--begin::Thumbnail settings-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card body-->
                                    <div class="card-body text-center pt-0">
                                        <!--begin::Image input-->
                                        <!--begin::Image input placeholder-->
                                        <style>
                                            .image-input-placeholder{
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
                                                <input type="file" wire:model="image" id="image{{$val->id}}" accept=".png, .jpg, .jpeg">
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
                                        @error('val.image')
                                        <span class="form-text text-danger">{{$message}}</span>
                                        @enderror
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Category')}}</label>
                                    <select class="form-select form-select-solid" wire:model="val.cat_id" required>
                                        <option value="">{{__('Select Category')}}</option>
                                        @foreach($categoryAll as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('val.cat_id')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6">
                                    <label class="form-label text-dark fs-7">{{__('Status')}}</label>
                                    <select class="form-select form-select-solid" wire:model="val.status" required>
                                        <option value="0">{{__('Draft')}}</option>
                                        <option value="1">{{__('Published')}}</option>
                                    </select>
                                    @error('val.status')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                @if($val->created_by != null)
                                <li class="d-flex align-items-center py-2">
                                    <span class="bullet me-5 bg-warning bullet-vertical"></span> <span>{{__('Created by')}}: {{$val->createdBy->first_name.' '.$val->createdBy->last_name}}</span>
                                </li>
                                @endif
                                @if($val->edited_by != null)
                                <li class="d-flex align-items-center py-2">
                                    <span class="bullet me-5 bg-warning bullet-vertical"></span> <span>{{__('Edited by')}}: {{$val->EditedBy->first_name.' '.$val->EditedBy->last_name}}</span>
                                </li>
                                @endif
                                <li class="d-flex align-items-center py-2">
                                    <span class="bullet me-5 bg-warning bullet-vertical"></span> <span>{{__('Updated at')}}: {{date("Y/m/d h:i:A", strtotime($val->updated_at))}}</span>
                                </li>
                            </div>
                            <div class="col-md-8">
                                <div class="fv-row mb-6">
                                    <input class="form-control form-control-solid" type="text" wire:model="val.title" required placeholder="{{__('Title of article')}}" />
                                    @error('val.title')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-6" wire:ignore>
                                    <textarea class="form-control form-control-solid tinymce" rows="10" type="text" wire:model="val.details" placeholder="{{__('Type your text')}}"></textarea>
                                    @error('val.details')
                                    <span class="form-text text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="text-center mt-10">
                                    <button type="submit" class="btn btn-success btn-block me-3 my-2" wire:loading.attr="disabled" wire:click.prevent="update">
                                        <span wire:loading.remove wire:target="update">{{__('Update Article')}}</span>
                                        <span wire:loading wire:target="update">{{__('Processing Request...')}}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="delete{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Delete Article')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    @if($val->deleted_at == null)
                    <p>{{__('Are you sure you want to delete this article')}}?</p>
                    <div class="text-center">
                    <button wire:click="delete" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="delete">{{__('Delete')}}</span>
                            <span wire:loading wire:target="delete">{{__('Processing Request...')}}</span>
                        </button>
                    </div>
                    @else
                    <p>{{__('Are you sure you want to delete this article?, you can\'t restore it after this')}}</p>
                    <div class="text-center">
                        <button wire:click="forceDelete" class="btn btn-danger btn-block" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="forceDelete">{{__('Delete')}}</span>
                            <span wire:loading wire:target="forceDelete">{{__('Processing Request...')}}</span>
                        </button>
                    </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.livewire.on('textarea.tinymce', data => {
        @this.set('val.details', data);
    });    

</script>
@endpush