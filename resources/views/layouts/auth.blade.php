<!doctype html>
<html lang="{{ app()->getLocale() }}" class="admin">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta property="og:title" content="{{ config('app.name') }} | @yield('ogtitle')">
    <meta property="og:url" content="@yield('url')">
    <meta property="og:image" content="@yield('image')">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700i,900i&display=swap" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('/css/remodal.css')}}" rel="stylesheet">
    <link href="{{asset('/css/remodal-default-theme.css')}}" rel="stylesheet">
    
  </head>
  <body class="page_auth">
    <!-- ! ヘッダー ============================== -->
    @include('element._header_auth')
    <div class="l">
      <div class="l_auto">
        <!-- ! メイン ============================== -->
        <main class="main">
          @yield('content')
        </main>
      </div>
    </div>
    <!-- ! フッター ============================== -->
    @include('element._footer')
    @include('element._script')
  </body>
</html>