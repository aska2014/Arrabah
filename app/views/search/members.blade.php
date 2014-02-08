@extends('master.layout1')

@section('body')
<div class="white-box">
    <h2 class="title title-font">بحث متقدم</h2>

    <p>
    <form action="{{ URL::route('search.members') }}" method="GET">
        <div class="main-form">
            <div class="row">
                <div class="right">
                    <div class="label">اسم الأول</div>
                    <input type="text" name="first_name" />
                </div>
            </div>

            <div class="clr"></div>

            <div class="row">
                <div class="right">
                    <div class="label">اسم الأب</div>
                    <input type="text" name="father_name" />
                </div>
            </div>

            <div class="clr"></div>

            <div class="row">
                <div class="right">
                    <div class="label">اسم العائلة</div>
                    <input type="text" name="family_name" />
                </div>
            </div>

            <div class="clr"></div>

            <div class="row buttons">
                <input type="submit" class="register-btn grey-btn" value="بحث" />
            </div>
        </div>

    </form>
    </p>


</div><!-- END of white-box -->
@stop

@section('styles')

<style type="text/css">
    .main-form .row .label{text-align: right;}
</style>

@stop