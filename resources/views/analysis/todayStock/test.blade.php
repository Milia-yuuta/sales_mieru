@extends('layouts.default')

@section('title', '今日のストックtest')
@section('description', 'ダッシュボード')
@section('ogtitle', 'トップ')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->

@section('content')
  {{--  {{dd($analysisDate)}}--}}
  @forelse($analysisDate as $value)
      <?php
      phpinfo();
      ?>
  @empty
  @endforelse
@endsection