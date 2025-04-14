<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>{{ env('APP_NAME')}}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">

    <header class="bg-slate-800 shadow-lg">
        <nav>
        <a href=" {{ route ('posts.index')}}" class="nav-link">Home</a> 
        @auth
          
        <div x-data="{open :false}" class="relative grid place-items-center">
         
          {{-- Drop Down Menu Button--}}

          <button @click="open = !open " type="button"  class="round-btn">
            <img src="https://picsum.photos/200" alt="">
          </button>

          {{-- Drop Down Menu--}}

          <div x-show="open"  @click.outside="open = false" class="bg-white shadow-lg absolute top-10 right-0 rounded-lg overflow-hidden font-light">
            <p class="username"> {{  auth()->user()->username }}</p>

            <a href=" {{ route('dashboard')}}" class="block hover:bg-slate-100 pl-4 pr-8 py-2 mb-1">Dashboard</a>

<form action=" {{ route('logout')}}" method="POST">
  @csrf

  <button type="submit" class="block hover:bg-slate-100 pl-4 pr-8 py-2 mb-1">Logout</button>
</form>

        </div>
        
        </div>
        @endauth



        @guest
          
        <div class="flex items-center gap">
            <a href="{{ route ('login')}}" class="nav-link">Login</a> 
            <a href="{{ route ('register')}}" class="nav-link">Register</a>
        </div>

        @endguest
       
        </nav>
    </header>
    
  <main class="py-8 px-4 mx-auto max-w-s">
    
{{ $slot  }}

  </main>  

</body>
</html>