@extends('master.layout1')

@section('body')
<div class="white-box">
    <h2 class="title title-font">بحث عن وظيفة</h2>

    <p>
    <form action="{{ URL::route('search.jobs') }}" method="GET">
        <div class="main-form">
            <div class="row">
                <div class="right">
                    <div class="label">اسم الوظيفة</div>
                    <input type="text" name="job_name" />
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