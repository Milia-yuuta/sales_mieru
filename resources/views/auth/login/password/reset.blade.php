@extends('layouts.auth')

@section('title', 'TOP')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="area_login">
                <div class="logo">
                    <img src="{{ asset('img/logo/logo.png') }}" alt="">
                </div>
                <ul class="list_form">
                    <li>
                        <div class="head">
                            <p class="ttl">新しいパスワード</p>
                        </div>
                        <div class="cnt">
                            <div class="f">
                                <div class="f_parts">
                                    <input type="text" id="" name="" placeholder="6文字以上12文字内の半角英数字" value="">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="head">
                            <p class="ttl">確認のためもう一度パスワードを入力</p>
                        </div>
                        <div class="cnt">
                            <div class="f">
                                <div class="f_parts">
                                    <input type="text" id="" name="" placeholder="新しいパスワードをもう一度入力" value="">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="btnarea">
                    <button class="btn">新しいパスワードを設定する</button>
                    <a class="btn" href="{{ route('login') }}" data-option="style-ghost">アカウントをお持ちの方</a>
                </div>
            </div>
        </form>
    </div>
@endsection
