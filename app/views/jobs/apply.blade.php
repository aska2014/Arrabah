@extends('master.layout1')

@section('body')
<div class="white-box">
    <h2 class="title title-font">تقدم للوظيفة</h2>

    <p>
    <form action="{{ URL::route('login') }}" method="POST">
        <div class="main-form">
            <div class="row">
                <div class="right">
                    <div class="label">إيميل المستخدم</div>
                    <input type="text" name="Login[email]" />
                </div>
            </div>

            <div class="clr"></div>

            <div class="row">
                <div class="right">
                    <div class="label">كملة المرور</div>
                    <input type="password" name="Login[password]" />
                </div>
            </div>

            <div class="clr"></div>

            <div class="row">
                <div class="right">
                    <small>لم تقم بالتسجيل بعد؟ سجل <a href="{{ URL::route('register') }}">من هنا</a></small><br />
                </div>
            </div>

            <div class="clr"></div>

            <div class="row">
                <div class="right">
                    <small>نسيت كلمة السر؟ <a href="{{ URL::route('reminder') }}">أضغط هنا</a></small><br />
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