<div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter Messages')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Category')}}</label>
                        <select class="form-select form-select-solid" wire:model="category" required>
                            <option value="">Select Category</option>
                            @foreach($categoryAll as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <span class="form-text text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Sort by')}}</label>
                        <select class="form-select form-select-solid" wire:model="sortBy">
                            <option value="asc">{{__('ASC')}}</option>
                            <option value="desc">{{__('DESC')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Order by')}}</label>
                        <select class="form-select form-select-solid" wire:model="orderBy">
                            <option value="created_at">{{__('Date')}}</option>
                        </select>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label text-dark fs-7">{{__('Per page')}}</label>
                        <select class="form-select form-select-solid" wire:model="perPage">
                            <option value="10">{{__('10')}}</option>
                            <option value="25">{{__('25')}}</option>
                            <option value="50">{{__('50')}}</option>
                            <option value="100">{{__('100')}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="post fs-7 d-flex flex-column-fluid min-vh-100" id="kt_post">
        <div class="container">
            <div class="row g-xl-8">
                <div class="col-md-8">
                    <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                        <div class="input-group input-group-solid mb-5 rounded-4 bg-white">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search articles')}}" />
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                </div>
            </div>
            @if($articles->count() > 0)
            <div class="table-responsive">
                <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
                    <thead>
                        <tr class="fw-semibold fs-7">
                            <th class="min-w-20px">{{__('S/N')}}</th>
                            <th class="min-w-250px">{{__('Title')}}</th>
                            <th class="min-w-100px">{{__('Category')}}</th>
                            <th class="min-w-50px">{{__('Views')}}</th>
                            <th class="min-w-200px">{{__('Created')}}</th>
                            <th class="scope"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $val)
                        <tr>
                            <td>{{$loop->iteration}}.</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px">
                                        <span class="symbol-label" style="background-image:url({{url('/').'/storage/app/'.$val->image}});"></span>
                                    </div>
                                    <div class="ms-5">
                                        {{substr($val->title, 0, 60)}}...
                                    </div>
                                </div>
                            </td>
                            <td>{{$val->category->name}}</td>
                            <td>{{$val->views}}</td>
                            <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                            <td class="text-center">
                                <button id="kt_edit_{{$val->id}}_button" class="btn btn-sm btn-whitelabel rounded-pill">{{__('Edit')}}</button>
                                <a data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" href="" class="btn btn-sm btn-danger rounded-pill">{{__('Delete')}}</a>
                            </td>
                        </tr>
                        <div><livewire:admin.blog.edit-article :val=$val :admin=$admin :wire:key="'kt_edit_'. $val->id"></livewire:admin.blog.edit-article></div>
                        @endforeach
                    </tbody>
                </table>
                @if($articles->total() > 0 && $articles->count() < $articles->total())<button wire:click="loadMore" wire:loading.remove class="btn btn-secondary btn-block">{{__('See more')}}</button>@endif
            </div>
            @else
            <div class="text-center mt-20">
                <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                    <div class="symbol-label fs-1 text-dark bg-whitelabel">
                        <i class="bi bi-newspaper text-dark" style="font-size:66px;"></i>
                    </div>
                </div>
                <h3 class="text-dark">{{__('No Article Found')}}</h3>
                <p class="text-dark">{{__('We couldn\'t find any article')}}</p>
            </div>
            @endif
        </div>
    </div>
</div>