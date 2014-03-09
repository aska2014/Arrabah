
    <div style="padding: 10px; margin-top:20px;">

        <div>
            <strong>عدد المشتركين :</strong>
            <strong style="margin-right:5px; color: #28579C; font-family: 'Comic Sans MS', cursive, sans-serif; letter-spacing: 4px;">
                {{ $userCount }}
            </strong>
        </div>

        <div style="margin-top:5px;">
            <strong>عدد الزوار</strong>
            <img style="position:relative; top:4px; right:5px;" src="http://www.easycounter.com/counter.php?kareem3d" border="0" alt="Counter">
        </div>
    </div>

    <div class="clr"></div>


	<div id="footer">
		<ul>
			<li><a href="{{ URL::to('') }}">الرئيسية</a></li>
			@if($aboutPage)
			<li>
				<a href="{{ URL::page($aboutPage) }}">{{ $aboutPage->title }}</a>
			</li>
			@endif
			<li><a href="{{ URL::route('families') }}">العائلات</a></li>
			<li><a href="#">مكتبة الصور</a></li>
			<li><a href="{{ URL::route('events') }}">مناسبات و أحداث</a></li>
			<li><a href="#">الأعضاء</a></li>
			@if($authUser)
			<li><a href="{{ URL::profile($authUser) }}">الصفحة الشخصية</a></li>
			@else
			<li><a href="{{ URL::route('register') }}">التسجيل</a></li>
			<li><a href="{{ URL::route('login') }}">صفحة الدخول</a></li>
			@endif
			<li><a href="#">أتصل بنا</a></li>
		</ul>

		<div class="clr"></div>

		<div class="copyright">
			جميع الحقوق محفوظة لموقع أهالى عرابة فى الوطن والمهجر © 2013
		</div>
	</div>


</div>

<script type="text/javascript">
    var assetUrl = "{{ URL::asset('') }}";
</script>

{{ Asset::scripts() }}

@yield('scripts')

</body>
</html>