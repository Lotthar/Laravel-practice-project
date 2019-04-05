{{-- Glavna stranica koja spaja sve ostale --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{config('app.name', 'LSAPP')}}</title>
</head>
<body>
    {{-- uzima navbar blade i stavlja ga na vrh svih stranica --}}
    @include('inc.navbar')
    <div class="container">
        {{-- izbacuje sadrzaj error poruke --}}
        @include('inc.messages') 
        {{-- uzima sav sadrzaj od svih naslednika koji nasledjuju 'content' --}}
        @yield('content')
    </div>
    {{-- SKRIPTA KOJA DAJE TEXTAREA mogucnost da upravlja tekstom --}}
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' ); 
    </script>
</body>
</html>