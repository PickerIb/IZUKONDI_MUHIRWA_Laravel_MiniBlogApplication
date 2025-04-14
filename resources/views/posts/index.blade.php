<x-layout>

    <h1 class="title">Latest Posts</h1>

{{-- <img src="{{ asset('storage/posts_images/public/storage/posts_images/b2y4Zavc1wQg7PRzmVlygOH2WNn69qyTKtX7IMOC.jpg')}}" alt=""> --}}

    
    {{-- Grid container for two columns --}}

    {{--List of Posts--}}
    <div class="grid grid-cols-2 gap-6">
    
        @foreach ($posts as $post)
        <x-postCard :post="$post"/>
        @endforeach
    
    </div>

<br>

    {{--Pagination Links --}}

    <div>

        {{$posts->links()}}
    </div>
    
    </x-layout>
    