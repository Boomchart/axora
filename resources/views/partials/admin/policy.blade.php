    <div class="mb-10">
        <div class="card-body">
            <form action="{{route('admin.settings.update', ['type' => 'policies'])}}" method="post">
                @csrf
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Privacy policy')}}</label>
                    <textarea class="form-control form-control-solid tinymce" rows="20" name="privacy">{{$set->privacy}}</textarea>
                </div>
                <div class="fv-row mb-6">
                    <label class="form-label text-dark fs-7">{{__('Terms & Conditions')}}</label>
                    <textarea class="form-control form-control-solid tinymce" rows="20" name="terms">{{$set->terms}}</textarea>
                </div>
                <div class="text-start">
                    <button type="submit" class="btn btn-success me-3 my-2">{{__('Update')}}</a>
                </div>
            </form>
        </div>
    </div>