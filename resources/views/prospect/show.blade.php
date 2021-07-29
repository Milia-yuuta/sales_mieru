@extends('layouts.default')

@section('title', $firstProspect->propertyRooms->first()->property->property_name.$firstProspect->propertyRooms->first()->room_name)
@section('description', 'ダッシュボード')
@section('ogtitle', '見込詳細')
@section('url', request()->url())
<!-- @section('image', asset('img/ogp.png')) -->
@section('content')
    <div class="container">
        <div class="box" data-option="style-show" data-page="page-prospects">
            <div class="head_box">
                <div class="area_ttl" data-flex="align-center">
                    <div class="close_tab btn" style="margin-right: 15px; height: 30px; width: 170px;background: white; color: #3B96DD">× タブを閉じる</div>
                    <span class="stage" data-option=" {{ $firstProspect->prospectActionLogs->sortByDesc('created_at')->first()->CssStageName }} size-l"></span>
                    <p class="h1">{{ $firstProspect->propertyRooms->first()->property->property_name }} <span class="room">{{ $firstProspect->propertyRooms->first()->room_name }}担当者</span></p>
                </div>
            </div>
            @include('element.error.validate_error')
            <div class="body_box">
                <div class="l" data-space="30">
                    <div class="l_auto">
                        <!-- ! タブエリア -->
                        <div class="area_tab" data-option="style-fit">
                            <ul class="list_tab_button">
                                <li class="current_tab">
                                    <div class="button_tab">追客行動</div>
                                </li>
                                <li><div class="button_tab">見込情報</div></li>
                                <li><div class="button_tab">顧客情報</div></li>
                                <li><div class="button_tab">顧客情報</div></li>
                            </ul>
                            <!-- ! 追客行動 ============================== -->
                        @include('prospect.showColumn.prospect_action_log_list')
                        <!-- ! 見込情報 ============================== -->
                        @include('prospect.showColumn.prospect_information')
                        <!-- ! 顧客情報 ============================== -->
                        @include('prospect.showColumn.client_list')
                        <!-- ! 顧客情報 ============================== -->
                            @include('prospect.showColumn.property_list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('element._prospect_edit')
    @include('element._prospect_action_add')
    @include('element._prospect_delete')
    @include('element._prospect_action_log_delete')
{{--    <script type="text/javascript" src="{{asset('/js/prospect_show_remarks.js')}}" defer></script>--}}
{{--    <script type="text/javascript" src="{{asset('/js/prospect_add_form_alert.js')}}" defer></script>--}}
{{--    <script type="text/javascript" src="{{asset('/js/prospect_show_add_form.js')}}" defer></script>--}}
{{--    <script src="{{ asset('js/stage_change_for_prospect_action_log.js') }}" defer></script>--}}
{{--    <script type="text/javascript" src="{{asset('/js/prospect_open_close.js')}}" defer></script>--}}
{{--    <script src="{{ asset('js/generating_medium_for_prospect.js') }}" defer></script>--}}
    <script src="{{ asset('js/prospect/show/index.js') }}" defer></script>
    <script src="{{ asset('js/element/date/japanese_date.js') }}" defer></script>
    <script>
        $('.ProspectActionLogEditBtn').click(function (){
            $('.stage_display').addClass('display_none');
        })
        $('#NewProspectActionLogBtn').click(function (){
            $('.stage_display').addClass('display_none');
        })
        $('.stage_display_btn').click(function (){
            $('.stage_display').removeClass('display_none');
        })
    </script>
@endsection
