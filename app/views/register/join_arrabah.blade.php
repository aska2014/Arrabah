@extends('master.layout1')

@section('body')
<div class="white-box">
    <h2 class="title title-font">إكمال عملية التسجيل</h2>

    <p>
    <form action="{{ URL::route('join-arrabah.post') }}" method="POST">
        <div class="main-form">

            <div class="row">
                <div class="all">
                    <div class="label" style="width:150px;"> هل تريد الاشتراك ب جمعية عرابة الخيرية ؟</div>
                    <input type="radio" checked="checked" id="true-arrabah" name="Register[from_arrabah]" value="true" /> نعم
                    <input type="radio" id="false-arrabah" name="Register[from_arrabah]" value="false" /> لا
                </div>
            </div>

            <input type="hidden" name="{{ $id['key'] }}" value="{{ $id['value'] }}" />

            <div class="clr"></div>

            <div class="row buttons">
                <input type="submit" class="register-btn grey-btn" value="حفظ" />
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