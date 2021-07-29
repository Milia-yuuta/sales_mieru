<div class="p-aside">
  <div class="p-aside_logo">
    <a>
      <img src="{{ asset('img/logo/logo.png') }}" alt="">
    </a>
  </div>
  <aside>
    <ul class="c-list_aside">
      <li>
        <a class="@if(Route::current()->getName() == 'welcome') current @endif" href="{{ route('welcome') }}">Top</a>
      </li>
      <li><a href="">レッスン管理</a></li>
      <li><a href="">クエスト管理</a></li>
      <li><a href="">コンテンツ管理</a></li>
      <li><a href="">イベント管理</a></li>
      <li><a href="">生徒管理</a></li>
      <li><a href="">保護者管理</a></li>
      <li><a href="">講師管理</a></li>
      <li><a href="">決済管理</a></li>
      <li><a href="">契約管理</a></li>
      <li><a href="">お問い合わせ管理</a></li>
      <li><a href="">マスタ管理</a></li>
      <li><a href="">管理者管理</a></li>
    </ul>             
  </aside>
</div>