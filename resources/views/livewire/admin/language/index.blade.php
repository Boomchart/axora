<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{__('Language')}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Language')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button id="kt_language_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add a Translation')}}</button>
            </div>
        </div>
    </div>
    <div wire:ignore.self id="kt_language" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true" data-kt-drawer-toggle="#kt_language_button" data-kt-drawer-close="#kt_language_close" data-kt-drawer-width="{'md': '500px'}">
        <div class="card w-100">
            <div class="card-header pe-5 border-0">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <div class="fs-5 text-gray-900 text-hover-success me-1 lh-1">{{__('Create a Translation')}}</div>
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="btn btn-sm btn-icon btn-icon-dark btn-active-light-success" data-kt-drawer-dismiss="true" id="kt_language_close">
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
                            <i class="bi bi-translate text-dark fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="pb-5 mt-10 position-relative zindex-1">
                    <form class="form w-100 mb-10" wire:submit.prevent="addLanguage" method="post">
                        <div class="fv-row mb-6">
                            <div wire:ignore>
                                <select class="form-select form-select-solid" wire:model="name" id="name" data-control="select2">
                                    <option>{{__('Select Language')}}</option>
                                    @foreach(collect(config('language.nameToLocale'))->sortKeys()->toArray() as $key => $val)
                                    <option value="{{$val}}*{{$key}}">{{ucwords($key)}} - {{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('name')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="fv-row mb-6">
                            <div wire:ignore>
                                <select class="form-select form-select-solid" wire:model="iso2" id="iso2" data-control="select2">
                                    <option>{{__('Select Country')}}</option>
                                    @foreach(collect(config('language.countryToLocale'))->sortKeys()->toArray() as $key => $val)
                                    <option value="{{$key}}">{{ucwords($key)}} - {{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('iso2')
                            <span class="form-text">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="text-center mt-10">
                            <button type="submit" class="btn btn-success btn-block me-3 my-2">
                                <span wire:loading.remove wire:target="addLanguage">{{__('Submit Request')}}</span>
                                <span wire:loading wire:target="addLanguage">{{__('Processing Request...')}}</span>
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
                    @if($language->count() > 0)
                    <div class="table-responsive">
                        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                            <thead>
                                <tr class="fw-semibold fs-7">
                                    <th class="min-w-20px">{{__('S/N')}}</th>
                                    <th class="min-w-50px">{{__('Name')}}</th>
                                    <th class="min-w-50px">{{__('ISO2')}}</th>
                                    <th class="50px">{{__('Status')}}</th>
                                    <th class="min-w-50px">{{__('Json Path')}}</th>
                                    <th class="scope"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($language as $val)
                                <tr>
                                    <td>{{$loop->iteration}}.</td>
                                    <td>{{ucwords($val->name)}} ({{$val->code}})</td>
                                    <td>{{$val->iso2}}</td>
                                    <td>
                                        @if($val->status==1)
                                        <span class="badge badge-pill badge-success">{{__('Active')}}</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">{{__('Blocked')}}</span>
                                        @endif
                                    </td>
                                    <td>{{'resources/lang/'.$val->code.'.json'}}</td>
                                    <td class="text-center">
                                        <a wire:click="download('{{$val->id}}')" class="btn btn-sm btn-warning text-dark rounded-pill"><i class="bi bi-arrow-down-circle text-dark"></i> {{__('Download')}}</a>
                                        <a href="{{route('admin.edit.language', ['lang' => $val->id])}}" class="btn btn-sm btn-whitelabel rounded-pill"><i class="bi bi-pen"></i> {{__('Edit keywords')}}</a>
                                        @if($val->status==1)
                                        <a wire:click="block('{{$val->id}}')" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-ban"></i> {{__('Disable')}}</a>
                                        @else
                                        <a wire:click="unblock('{{$val->id}}')" class="btn btn-sm btn-secondary rounded-pill"><i class="fa fa-check"></i> {{__('Activate')}}</a>
                                        @endif
                                        <button data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <div>
                                    <livewire:admin.language.delete :val=$val :wire:key="'kt_language_'. $val->id"></livewire:admin.language.delete>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-translate text-dark" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark">{{__('No Translation Found')}}</h3>
                        <p class="text-dark">{{__('We couldn\'t find any translation, create your first translation')}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        $('#name').on('change', function(e) {
            @this.set('name', $(this).val());
        });
        $('#iso2').on('change', function(e) {
            @this.set('iso2', $(this).val());
        });
    });
</script>
@endpush