<div class="btn btn-icon btn-active-light-success position-relative w-30px h-30px w-md-40px h-md-40px" id="kt_notify_button">
    <i class="bi bi-bell text-dark" style="font-size:23px;"></i>
</div>
@if ($unread->count() > 0)
<span class="badge badge-sm badge-circle badge-danger mb-7 ms-n3">{{$unread->count()}}</span>
@endif