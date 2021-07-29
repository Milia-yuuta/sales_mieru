@extends('layouts.auth')
@include('element._header_auth')
@section('title', 'パスワード設定メール')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('password.email') }}">
            @CSRF
            <div class="area_login">
                <div class="logo">
                    <img src="{{ asset('img/logo/logo.png') }}" alt="">
                </div>
                <ul class="list_form">
                    <li>
                        <div class="head">
                            <p class="ttl">メールアドレス</p>
                        </div>
                        <div class="cnt">
                            <div class="f">
                                <div class="f_parts">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="メールアドレスを入力してください" >
                                </div>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert" style="color: #1d68a7">
                                        <p>パスワードリセットメールを送信しました。</p>
                                    </div>
                                @endif
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">入力されたメールアドレスは登録が御座いません。</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="btnarea">
                    <button class="btn">パスワード設定メールを送信</button>
                    <a class="btn" href="{{ route('login') }}" data-option="style-ghost">アカウントをお持ちの方</a>
                </div>
            </div>
        </form>
    </div>
@endsection
