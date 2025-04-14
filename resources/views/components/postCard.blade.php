@props(['post', 'full' => false])

<div class="card">


    {{--Cover Photo--}}

    <div class="h-52 rounded-md mb-4 w-full object-cover overflow-hidden">
        @if ($post->image)
        <img src="{{ asset('storage/'. $post->image )}}" alt="">
 
        @else
        <img src="{{ asset('storage/post_images/default.jpg' )}}" alt="">  
        {{-- <img src="{{ asset('storage/posts_images/Zx5X8KiuTdTB3Mu6pVlBJEQiUFlAgKFWxByc8UBm.jpg')}}" alt=""> --}}

  
        @endif
    </div>

    {{-- Title --}}
    <h2 style="font-weight:bold;">{{ $post->title }}</h2>

    {{-- Author and Date --}}
    <div class="text-xs font-light mb-4">
        <span>Posted {{ $post->created_at->diffForHumans() }} By </span>
        <a href="{{ route('posts.user', $post->user) }}" class="text-blue-500 font-medium">{{ $post->user->username }}</a>
    </div>

    {{-- Section of the body --}}
    @if ($full)
        <div class="text-sm">
            <span>{{ $post->body }}</span> 
        </div>
    @else
        <div class="text-sm">
            <span>{{ Str::words($post->body, 15) }}</span> 
            <a href="{{ route('posts.show', $post) }}" class="text-blue-500 ml-2">Read more &rarr;</a>
        </div>
    @endif


    <div class="flex items-center justify-end gap-4 mt-6">
        
{{ $slot }}

    </div>

</div>