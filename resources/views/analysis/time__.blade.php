@extends('layouts.default')

@section('title', 'TOP')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <div class="box" data-option="style-page" data-page="page-prospects">
      <div class="head_box">
        <p class="ttl" data-ico="time">タイムレポート</p>
      </div>
      <div class="body_box">
      </div>
      <div class="foot_box" data-option="margin-m">
        <ul class="c-list_nav" data-option="style-analytics">
          <li>
            <article>
              <a href="{{ route('todaysStock') }}"></a>
              <p class="stock">今日のストック</p>
            </article>
          </li>
          <li class="current">
            <article>
              <a href="{{ route('stageTrend') }}"></a>
              <p class="stage">ステージ推移</p>
            </article>
          </li>
          <li>
            <article>
              <a href="{{ route('exactionReport') }}"></a>
              <p class="excavation">発掘レポート</p>
            </article>
          </li>
          <li>
            <article>
              <a href="{{ route('pursuitReport') }}"></a>
              <p class="pursuit">追客レポート</p>
            </article>
          </li>
          <li>
            <article>
              <a href="{{ route('yield') }}"></a>
              <p class="aggregate">歩留まり集計</p>
            </article>
          </li>
          <li>
            <article>
              <a href="{{ route('monthlyResult') }}"></a>
              <p class="table">月次結果一覧</p>
            </article>
          </li>
          <li>
            <article>
              <a href="{{ route('webResponse') }}"></a>
              <p class="table">ネット反響各指標</p>
            </article>
          </li>
        </ul>
      </div>
    </div>
  </div>
@endsection