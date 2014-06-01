<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Arrabah design</title>

	{{ Asset::styles() }}

	@yield('styles')
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=316240738510949";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Argent news -->
<div id="argent_news"> <!-- This div display argent news -->
    <a href="#"><h1>العربية</h1></a>
    <h3></h3>
    <div id="argent_body"></div>
    <a id="argent_close" href="javascript:void(0);" onclick='$("#argent_news").hide("slow")'>إغلاق</a>
</div>
<!-- END OF Argent news -->

<div id="Container">

	<div id="header">
		<div id="top-header">

			@if(! $authUser)
			<h2 class="title-font">تسجيل الدخول</h2>
			<div id="top-header-form">
				<form action="{{ URL::route('login') }}" method="POST">
					<label for="">إيميل المستخدم: </label>
					<input id="authUsername" name="Login[email]" type="text" class="txt user-icon" />
					<label for="">كلمة السر: </label>
					<input id="password" name="Login[password]" type="password" class="txt pass-icon" />
					<input type="submit" value="" class="btn" />
				</form>
			</div>
			@else
            @if($authUser->family)
			<h2 class="title-font">مرحباً {{ $authUser->first_name }} {{ $authUser->family->name }}</h2>
            @else
            <h2 class="title-font">مرحباً {{ $authUser->first_name }}</h2>
            @endif
			<div id="top-header-account">

				<ul>
					<li><div class="icon home-i"></div><a href="{{ URL::profile($authUser) }}">الصفحة الشخصية</a></li>
					<li class="sep">|</li>
					<li><div class="icon messages-i"></div>
						<a href="{{ URL::route('inbox') }}">الرسائل 
							@if($newMessages)
							<span>({{ $newMessages }})</span>
							@endif
						</a>
					</li>
					<li class="sep">|</li>
					<li><div class="icon gallery-i"></div><a href="{{ URL::userGallery($authUser) }}">مكتبة الصور</a></li>
					<li class="sep">|</li>
					<li><div class="icon exit-i"></div><a href="{{ URL::route('logout') }}" style="color:#F70">الخروج</a></li>
				</ul>
			</div>
			@endif

		</div><!-- END of top-header -->

		<div id="middle-header">
			<div id="middle-left-header">
				<div class="socials">
					@foreach($allLinks as $link)
						@if(in_array($link->identifier, $headerSocials) && $link->url)
						<a href="{{ $link->url }}"><div class="{{ $link->identifier }}"></div></a>
						@endif
					@endforeach
				</div>
				<div class="search">
					<form action="{{ URL::route('search-members') }}" method="GET">
						<input type="text" class="search-txt" value="بحث عن صديق او قريب ..." onfocus="if(this.value=='بحث عن صديق او قريب ...')this.value = ''" onblur="if(this.value =='') this.value = 'بحث عن صديق او قريب ...';"  name="keyword"/>
						<input type="submit" value="" class="search-btn" />
					</form>
				</div>
                <div class="down-search" style="color:#FFF; font-size:12px;">
                    <a href="{{ URL::route('search.members') }}">
                    بحث متقدم
                    </a>
                </div>
			</div>
		</div><!-- END of middle-header -->

		<div id="bottom-header">
			<div id="header-menu">
				<ul>
                    <li><a href="{{ URL::route('home') }}">الرئيسية</a></li>
                    <li><a href="{{ URL::to('page/introduction-1.html') }}">المقدمة</a></li>
					@if($aboutPage)
					<li>
						<a href="{{ URL::page($aboutPage) }}">{{ $aboutPage->title }}</a>
						@if($aboutPage->hasChildren())
						<ul>
							@foreach($aboutPage->getChildren() as $childPage)
							<li><a href="{{ URL::page($childPage) }}">{{ Str::limit($childPage->title, 10) }}</a></li>
							@endforeach
						</ul>
						@endif
					</li>
					@endif
					<li><a href="{{ URL::route('families') }}">العائلات</a></li>
					<li><a href="{{ URL::route('galleries') }}">مكتبة الصور</a></li>
					<li><a href="{{ URL::route('events') }}">مناسبات وأحداث</a></li>
					<li>
						<a href="#">الأعضاء</a>
						<ul>
							<li><a href="{{ URL::route('premium-members') }}">أعضاء مشاركين</a></li>
							<li><a href="{{ URL::route('normal-members') }}">أعضاء شرف</a></li>
						</ul>
					</li>
					@if($authUser)
					<li><a href="{{ URL::route('chat') }}">صفحة الشات</a></li>
					@else
					<li><a href="{{ URL::route('register') }}">التسجيل</a></li>
					@endif
					<li><a href="#">وظائف</a>
                        <ul>
                            <li><a href="{{ URL::route('jobs') }}">وظائف شاغرة</a></li>
                            <li><a href="{{ URL::route('search.jobs') }}">بحث عن عمل</a></li>
                        </ul>
                    </li>
					<li><a href="{{ URL::route('contact-us') }}">اتصل بنا</a></li>
				</ul>
			</div>
		</div><!-- END of bottom-header -->
	</div><!-- END of header -->

	<div class="clr"></div>