@extends('master.layout1')

@section('body')
<div class="white-box families" style="padding-bottom:20px;">
    <h2 class="title title-font"><div class="family-icon"></div>العائلات</h2>

    <div class="tools">

    </div>

    <div style="float: right; width: 33%;">
        <ul class="family-list">
            @foreach($families->slice(0, $tolt) as $family)
            <li><a href="{{ URL::family($family) }}">{{ $family->name }}</a></li>
            @endforeach
        </ul>
    </div>
    <div style="float: right; width: 33%;">
        <ul class="family-list">
            @foreach($families->slice($tolt, $tolt) as $family)
            <li><a href="{{ URL::family($family) }}">{{ $family->name }}</a></li>
            @endforeach
        </ul>
    </div>
    <div style="float: right; width: 33%;">
        <ul class="family-list">
            @foreach($families->slice($tolt * 2) as $family)
            <li><a href="{{ URL::family($family) }}">{{ $family->name }}</a></li>
            @endforeach
        </ul>
    </div>

    <style type="text/css">

        .family-list a{font-size:14px; color:#555; line-height: 24px;}
    </style>

    <div class="clr"></div>

</div><!-- END of white-box -->
@stop