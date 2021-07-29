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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
    <link href="{{asset('/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('/css/remodal.css')}}" rel="stylesheet">
    <link href="{{asset('/css/remodal-default-theme.css')}}" rel="stylesheet">
    <link href="{{asset('/css/Chart.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/pin.css')}}" rel="stylesheet">

    <!-- Script -->
    <script type="text/javascript" src="{{asset('/js/jquery-3.5.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <script type="text/javascript" src="{{asset('/js/Chart.min.js')}}" ></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" ></script>
    <script type="text/javascript" src="{{asset('/js/select2_start.js')}}" defer></script>

    <!-- ウォーターフォール -->
    <script type="text/javascript" src="{{asset('/js/chartjs-plugin-waterfall.min.js')}}" ></script>
    <!-- グラフに数値を表示 -->
    <script type="text/javascript" src="{{asset('/js/chartjs-plugin-datalabels.min.js')}}" ></script>
    
  </head>
  <body class="">
    <!-- ! ヘッダー ============================== -->
    @include('element._header')
    @include('element.flash.flash_message')
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