<div>
    <div class="card mb-10">
        <div class="card-body">
            <form wire:submit.prevent="filetypeUpdate" method="post">
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Documents File Types allowed to be uploaded to server')}}</label>
                    <div wire:ignore>
                        <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="files_allowed" id="files_allowed" required />
                    </div>
                    @error('files_allowed')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Images File Type allowed to be uploaded to server')}}</label>
                    <div wire:ignore>
                        <input class="form-control form-control-solid" type="text" wire:model.debounce.1000ms="images_allowed" id="images_allowed" required />
                    </div>
                    @error('images_allowed')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('File upload size')}}</label>
                    <div class="input-group">
                        <input class="form-control form-control-solid" type="number" wire:model.debounce.1000ms="file_upload_size"/>
                        <span class="input-group-text border-0">{{__('KB')}}</span>
                    </div>
                    <span class="form-text text-muted">{{__('Maximum file size allowed on admin and user dashboard')}}</span>
                    @error('file_upload_size')
                    <span class="form-text text-danger">{{$message}}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success me-3 my-2" wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="filetypeUpdate">
                    <span wire:loading.remove wire:target="filetypeUpdate">{{__('Update')}}</span>
                    <span wire:loading wire:target="filetypeUpdate">{{__('Processing Request...')}}</span>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        var fileFilter = document.querySelector("#files_allowed");
        var imageFilter = document.querySelector("#images_allowed");
        var tagifyFileFilter = new Tagify(fileFilter);
        var tagifyImageFilter = new Tagify(imageFilter);

        fileFilter.addEventListener('change', function(e) {
            @this.set('files_allowed', e.target.value);
        });        
        imageFilter.addEventListener('change', function(e) {
            @this.set('images_allowed', e.target.value);
        });
    });
</script>
@endpush