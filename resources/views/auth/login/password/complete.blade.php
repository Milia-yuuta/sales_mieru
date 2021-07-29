@extends('layouts.auth')

@section('title', 'TOP')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  <div class="container">
    <form action="/?flash=successLogin" method="" accept-charset="utf-8">
      <div class="area_login">
        <div class="logo">
          <img src="{{ asset('img/logo/logo.png') }}" alt="">
        </div>
        <div class="text">
          <p class="ttl">メールを送信しました</p>
          <p class="description">入力したメールアドレス宛に<br />パスワード再設定URLを送付しました。</p>
        </div>  
        <div class="btnarea">
          <a class="btn" href="{{ route('login') }}" data-option="style-ghost">ログインページへ</a>
        </div>           
      </div>
    </form>
  </div>
@endsection