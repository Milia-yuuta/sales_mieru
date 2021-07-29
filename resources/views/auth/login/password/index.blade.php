@extends('layouts.auth')
@include('element._header_auth')
@section('title', 'TOP')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
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
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                    @enderror
                                </div>
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
