<div class="col-lg-4">
    <div class="card">
        <div class="card-header bg-transparent">
            <span class="h6 m-0px">{{__('Categories')}}</span>
        </div>
        <div class="list-group list-group-flush">
            @foreach(getBlogCat() as $val)  
            <a href="{{route('category', ['category' => $val->id, 'slug' => Str::slug($val->categories)])}}" class="list-group-item list-group-item-action d-flex justify-content-between p15px-tb">
                <div>
                    <span>{{$val->categories}}</span>
                </div>
                <div>
                    <i class="ti-angle-right"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="card m-35px-t">
        <div class="card-header bg-transparent">
            <span class="h6 m-0px">{{__('Recent Posts')}}</span>
        </div>
        <div class="list-group list-group-flush">
            @foreach(getBlog() as $val)
            <a href="{{route('article', ['article' => $val->id, 'slug' => $val->slug])}}" class="list-group-item list-group-item-action d-flex p15px-tb">
                <div>
                    <div class="avatar-50 border-radius-5">
                        <img src="{{asset('asset/thumbnails/'.$val->image)}}" title="" alt="">
                    </div>
                </div>
                <div class="p-15px-l">
                    <p class="m-0px">{{$val->title}}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>