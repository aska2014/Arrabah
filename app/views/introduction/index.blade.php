@extends('master.layout1')

@section('body')
<div class="white-box events">
    <h2 class="title title-font"><div class="page-icon"></div>
        مقدمة
    </h2>

    <div class="description">

        <div class="text-center">
        <strong>
        بسم الله الرحمن الرحيم
        </strong><br /><br /><br />

        (واعتصموا بحبل الله جميعاً ولا تفرقوا)
        </div><br />
<div class="strong-text">
        يسرني أن أتقدم نيابة عن الأخوة من أبناء عرابه في المملكة العربية السعودية ورئيس وأعضاء رابطة أبناء عرابه في المملكة الأردنية الهاشمية بالتحية والتقدير الى جميع أبناء عرابه في الوطن والمهجر.<br />
        أخواني أهالي عرابه الكرام.<br />
        إن فكرة إنشاء هذا الموقع كان الهدف الأساسي منه العمل على تنمية أو مساعدة أهلنا في عرابه والمهجر أينما كانوا ولم شملهم في موقع إلكتروني يكون مرجعاً لكامل أبناء عرابه أينما وجدوا.<br />
        وإن هذا الموقع يتيح للجميع التسجيل في رابطة أبناء عرابة في الأردن والذي من خلال الإنضمام الى الرابطة سوف يكون له الأثر الكبير في العمل على مساعدة أبناء عرابه في المهجر أينما كانوا.<br />
        أن إنضمامكم الى هذا الموقع يعبر بالأكيد عن إنتمائكم وولائكم لبلدنا المحب عرابه.<br />
</div>
        <br />
        <div class="strong-text text-left">
        أخوكم<br />
        محمود غالب موسى
        </div>
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