<header class="header">
  <div class="container">
    <!-- ! ロゴ -->
    <div class="area_logo_header">
      <a href="{{ route('home') }}">
        <img src="{{ asset('img/logo/logo.png') }}" alt="">
      </a>
    </div>
    <!-- ! 日付 -->
    <div class="area_today">
      <p class="day">{{\Carbon\Carbon::now()->format('Y年m月d日')}}{{\Carbon\Carbon::now()->isoFormat('(ddd)')}}</p>
      <p class="date"></p>
    </div>
    <!-- ! 所属 -->
    @if(isset($loginUser))
    <div class="myarea_header">
      <p class="sales_office">{{$loginUser->userAffiliation->name}}営業所</p>
      <p class="field">
      @forelse($loginUser->AllAreaSearchName as $areaName)
      {{$areaName}}
      @empty
      @endforelse
      </p>
      <p class="name">{{$loginUser->PositionSearch}} / {{$loginUser->FullName}}</p>
    </div>
      @endif
  </div>
  <div class="area_menu">
    <div class="button_hamburger">
      <p></p>
      <p></p>
      <p></p>
      <span>MENU</span>
    </div>
    <ul class="list_menu">
      <li>
        <a href="{{ route('prospect') }}" class="ico list">見込リスト</a>
      </li>
      <li>
        <a href="{{ route('property') }}" class="ico mansion">顧客リスト</a>
      </li>
      <li>
        <a href="{{ route('dailyReport') }}" class="ico report">日報</a>
      </li>
      <li>
        <p class="ico analytics">分析</p>
        <ol>
          <li><a href="{{ route('todayStock') }}">今日のストック</a></li>
          <li><a href="{{ route('stageTrend') }}">ステージ推移</a></li>
          <li><a href="{{ route('exactionReport') }}">発掘レポート</a></li>
          <li><a href="{{ route('pursuitReport') }}">追客レポート</a></li>
          <li><a href="{{ route('yield') }}">歩留まり集計</a></li>
          <li><a href="{{ route('monthlyResult') }}">月次結果一覧</a></li>
          <li><a href="{{ route('webResponse') }}">ネット反響各指標</a></li>
        </ol>
      </li>
      <li class="logout">
        <a href="{{ route('logout') }}?flash=successLogout">ログアウト</a>
      </li>
    </ul>
  </div>
</header>
