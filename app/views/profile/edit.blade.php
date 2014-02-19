@extends('master.layout1')

@section('body')
<div class="white-box">
    <h2 class="title title-font">تعديل بياناتك الشخصية</h2>

    <p>
    <form action="{{ URL::route('profile.edit') }}" method="POST">
        <div class="main-form">
            <div class="clr"></div>

            <div class="row">
                <div class="label">العنوان</div>

                <div id="country-slct-div">
                    <select class="special basic-select" target="city-slct" id="country-slct" name="Address[country]" value="{{ Input::old('Address.country') }}">
                        <option value=""></option>
                        @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->getName() }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="city-slct-div">
                    <select class="special basic-select" id="city-slct" target="region-slct" name="Address[city]" value="{{ Input::old('Address.city') }}">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="clr"></div>
            <div class="row">
                <div class="right">
                    <div class="label">العنوان</div>
                    <input type="text" name="Profile[place_of_birth]" value="{{ $profileUser->place_of_birth }}" />
                </div>
            </div>

            <div class="clr"></div>
            <div class="row">
                <div class="right">
                    <div class="label">رقم التليفون</div>
                    <input type="text" name="Profile[telephone_no]" value="{{ $profileUser->telephone_no }}" />
                </div>
            </div>
            <div class="clr"></div>

            <div class="row buttons">
                <input type="submit" class="register-btn grey-btn" value="الدخول" />
            </div>
        </div>

    </form>
    </p>


</div><!-- END of white-box -->
@stop

@section('styles')

<style type="text/css">
    .main-form .row .label{text-align: right; width:95px; margin-left: 0px;}
    .main-form .row .right{width:350px;}
    .main-form{padding:20px 0px;}
    .main-form .normal-slct{width:193px;}
    .main-form .special{float:right; width:167px; margin-left:20px;}
</style>

@stop

@section('scripts')
@include('profile.edit_scripts')
@stop