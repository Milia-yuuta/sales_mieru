@extends('layouts.auth')

@section('title', 'ログイン画面')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="area_login">
                <div class="logo">
                    <img src="{{ asset('img/logo/logo.png') }}" alt="">
                </div>
                <ul class="list_form">
                    <li>
                        <div class="head">
                            <p class="ttl">ID</p>
                        </div>
                        <div class="cnt">
                            <div class="f">
                                <div class="f_parts">
                                    <input type="email" id="email"  name="email" value="{{ old('email') }}" placeholder="IDを入力してください" required autocomplete="email" autofocus>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="head">
                            <p class="ttl">PASSWORD</p>
                        </div>
                        <div class="cnt">
                            <div class="f">
                                <div class="f_parts">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="PASSWORDを入力してください" autocomplete="current-password">
                                </div>
                            </div>
                        </div>
                    </li>
                    @include('element.error.validate_error')
{{--                    @forelse($errors->all() as $error)--}}
{{--                        <p style="color: red">IDまたはパスワードが間違っています。</p>--}}
{{--                    @empty--}}
{{--                    @endforelse--}}
                </ul>
                <div class="btnarea">
                    <button class="btn">ログイン</button>
                    <a class="btn" href="{{ route('password.request') }}" data-option="style-ghost">パスワード設定へ</a>
                </div>
            </div>
        </form>
    </div>
@endsection
