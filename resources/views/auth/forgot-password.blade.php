<x-layout>
    <h1 class="title">Request  a password reset email</h1>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkmcfRyVX3pBnMFcV7oQPJkL9QevSCWr3W6A==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite(['resources/css/app.css','resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    
    {{-- Session Messages   --}}

    @if(session('status'))

    <x-flashMsg  msg="{{session('status')}}" />

    @endif

    <div class="mx-auto max-w-screen-sm  card">

<form action="{{route('password.request')}}" method="POST" x-data="formSubmit" @submit.prevent="submit" >


    @csrf  


        {{--Email--}}
        <div class="mb-4">
            <label for="email">Email:</label>
            <input type="text"  name="email" value="{{old('email')}}" class="input
            @error('email') ring-red-500 @enderror " >

            @error('email')
            <p class="error">{{$message}}</p>
                
            @enderror

        </div>

            {{--Submit Button--}}
           <button x-ref="btn" class="btn">Submit</button>
        
</form>
  
</x-layout>
    