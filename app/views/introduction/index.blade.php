@extends('master.layout1')

@section('body')
<div class="white-box events">
    <h2 class="title title-font"><div class="page-icon"></div>
        مقدمة
    </h2>

    <div class="description">
        @if($placeable = $homeWelcome->placeable)
        {{ $placeable->description }}
        @endif
    </div>

    <style type="text/css">
        .text-center{text-align: center}
        .text-left{text-align: left}
        .strong-text{font-weight:bold; line-height:38px;}
    </style>

    <div class="clr"></div>
    @include('social.facebook')

</div><!-- END of white-box -->

@stop

@section('styles')
<style type="text/css">
    .white-box .description{ margin:20px; }
</style>
@stop