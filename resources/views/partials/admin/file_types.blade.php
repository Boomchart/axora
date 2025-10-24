<div>
    @livewire('admin.filetypes', ['settings' => $set, 'admin' => $admin])
    <h4 class="text-dark">{{__('File Types')}}</h4>
    <div class="table-responsive">
        <table id="kt_datatable_example_5" class="table align-middle table-row-bordered table-row-gray-300 gy-5 gs-7" wire:loading.class.delay="opacity-50" wire:target="search, status, sortBy, orderBy, perPage, loadMore">
            <thead>
                <tr class="fw-semibold fs-7">
                    <th class="min-w-20px">{{__('S/N')}}</th>
                    <th class="min-w-250px">{{__('Mimes Name')}}</th>
                    <th class="min-w-250px">{{__('Type Type')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach(config('mimes') as $key => $val)
                <tr>
                    <td>{{$loop->iteration}}.</td>
                    <td>{{$key}}</td>
                    <td>{{$val}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>