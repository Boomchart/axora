<div class="pl-3 w-full">
    <div class="items-center justify-between w-full pr-2">
        <div class="row">
            <div class="col-12 col-md-8">
                <p class="block w-full focus:outline-none text-md leading-none my-0 mb-2">
                    <span class="text-dark font-bold">
                        @if(! empty($announcement['link']))
                            @endif
                            {{ $announcement['title'] }}
                            @if(! empty($announcement['link']))
                        @endif
                    </span>
                </p>
            </div>
            <div class="col-12 col-md-4 text-md-end">
                @if($unread->read_at === null)
                <a href="javascript:void;" x-on:click="$wire.markAsRead('{{$unread->id}}')" class="btn btn-sm btn-danger mb-2"><i class="bi bi-hand-thumbs-up"></i> {{__('Read')}}</a>
                @endif
            </div>
        </div>
        <p class="block w-full focus:outline-none text-sm leading-none">
            {{ $announcement['body'] }}
        </p>
    </div>
    <div class="flex justify-between">
        <p class="focus:outline-none text-xs leading-3 pt-1 text-gray-500" title="{{ $created_at->format('jS M Y H:i') }}">
            {{ $created_at->diffForHumans() }}
        </p>

        @if(! empty($announcement['link']))
        <p class="text-right focus:outline-none text-xs leading-3 pt-1 mt-3">
            <a href="{{ $announcement['link'] }}" {{ ! empty($announcement['linkNewWindow']) ? ' target="_blank"' : '' }} class="cursor-pointer no-underline bg-gray-100 text-gray-800 rounded-md border border-gray-300 p-2 hover:bg-gray-300 no-wrap">
                {{ ! empty($announcement['linkText']) ? $announcement['linkText'] : 'View' }}
            </a>
        </p>
        @endif
    </div>
</div>