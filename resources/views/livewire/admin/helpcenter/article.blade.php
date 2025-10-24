<div>
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bold my-1 fs-4">{{$topic->name}}</h1>
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-success">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('faq.index')}}" class="text-muted text-hover-success">{{__('Help Center')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('Article')}}</li>
                </ul>
            </div>
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <button data-bs-toggle="modal" data-bs-target="#filter" class="btn btn-white text-dark me-4"><i class="bi bi-filter"></i> {{__('Filter')}}</button>
                <button id="kt_article_button" class="btn btn-dark me-4"><i class="bi bi-plus-lg"></i> {{__('Add an Article')}}</button>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{__('Filter Articles')}}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-success ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <i class="bi bi-x-lg fs-2"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-body">
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
                            <option value="views">{{__('Views')}}</option>
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
                                <input type="search" class="form-control form-control-solid text-dark rounded-4 bg-white" wire:model="search" placeholder="{{__('Search Article')}}" />
                            </div>
                        </div>
                    </div>
                    @if($articles->count() > 0)
                    <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, sortBy, orderBy, perPage, loadMore">
                        <thead>
                            <tr class="fw-semibold fs-7">
                                <th>{{__('S/N')}}</th>
                                <th>{{__('Questions')}}</th>
                                <th>{{__('Views')}}</th>
                                <th>{{__('Likes')}}</th>
                                <th>{{__('Dislikes')}}</th>
                                <th>{{__('Created')}}</th>
                                <th>{{__('Updated')}}</th>
                                <th class="scope"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $val)
                            <tr>
                                <td>{{$loop->iteration}}.</td>
                                <td>{{substr($val->question, 0, 30)}}</td>
                                <td>{{$val->views}}</td>
                                <td>{{$val->likes()}}</td>
                                <td>{{$val->reactions() - $val->likes()}}</td>
                                <td>{{$val->created_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                                <td>{{$val->updated_at->setTimezone($admin->timezone)->format('Y/m/d h:i:A')}}</td>
                                <td class="text-center">
                                    <button id="kt_article_{{$val->id}}_button" class="btn btn-sm btn-whitelabel rounded-pill"><i class="bi bi-pen"></i> {{__('Edit')}}</button>
                                    <a data-bs-toggle="modal" data-bs-target="#delete{{$val->id}}" href="" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-trash"></i> {{__('Delete')}}</a>
                                </td>
                            </tr>
                            <div><livewire:admin.helpcenter.edit-article :val=$val :topics=$topics :wire:key="'kt_article_'. $val->id"></livewire:admin.helpcenter.edit-article></div>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center mt-20">
                        <div class="symbol symbol-150px symbol-circle me-5 mb-10">
                            <div class="symbol-label fs-1 text-dark bg-whitelabel">
                                <i class="bi bi-question-circle text-dark" style="font-size:66px;"></i>
                            </div>
                        </div>
                        <h3 class="text-dark">{{__('No Article Found')}}</h3>
                        <p class="text-dark">{{__('We couldn\'t find any article on this topic')}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>