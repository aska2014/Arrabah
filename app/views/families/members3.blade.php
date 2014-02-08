@extends('master.layout1')

@section('body')
<div class="white-box families" style="padding-bottom:20px;">
    <h2 class="title title-font">
        <div class="family-icon"></div>
        {{ $membersTitle }}
    </h2>

    <div class="tools">

        <select class="select2 age-slct" style="width:140px;">
            <option value=""></option>
            <option value="all-ages">كل الأعمار</option>
            <option value="above-18">أكبر من 18 سنة</option>
            <option value="below-18">أصغر من 18 سنة</option>
        </select>

    </div>

    <ul class="family-users">
        @foreach($familyUsers as $user)
        <li>
            <a href="{{ URL::profile($user) }}">
                {{ $user->first_name }} {{ $user->father_name }} {{ $user->family->name }}
            </a>

            <strong>
            {{ $user->telephone_no }}
            </strong>
        </li>
        @endforeach
    </ul>

    <style type="text/css">
        .family-users li{margin-bottom:10px;}
        .family-users a{color:#900;}
        .family-users strong{font-size:12px; display: block; line-height: 28px;}
    </style>

    <div class="clr"></div>
</div><!-- END of white-box -->
@stop

@section('scripts')
<script type="text/javascript">

    $(document).ready(function () {
        $(".select2").select2({placeholder: 'أختار العمر'});

        $(".age-slct").select2('val', "{{ Input::get('age') }}");

        $(".age-slct").change(function () {

            insertParam('age', $(this).val());
//		var url = [location.protocol, '//', location.host, location.pathname].join('');
//		url = url + "?age=" + $(this).val();
//
//		@if(Input::get('keyword'))
//		url = url + "&keyword={{ Input::get('keyword') }}";
//		@endif
//
//		window.location.href = url;
        });
    });


    function insertParam(key, value) {
        key = encodeURI(key);
        value = encodeURI(value);

        var kvp = document.location.search.substr(1).split('&');

        var i = kvp.length;
        var x;
        while (i--) {
            x = kvp[i].split('=');

            if (x[0] == key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }

        if (i < 0) {
            kvp[kvp.length] = [key, value].join('=');
        }

        //this will reload the page, it's likely better to store this until finished
        document.location.search = kvp.join('&');
    }

</script>

@stop