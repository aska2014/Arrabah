<div class="white-box">
	<h2 class="title title-font">التسجيل</h2>

	<form action="{{ $postRegister }}" method="POST" enctype= "multipart/form-data">

		<div class="main-form">


			<p>
				<b style="color:#A00;">برجاء إدخال جميع الحقول بالأسفل*</b>
			</p>

			<div class="clr"></div>

			<div class="form-header" style="margin-top:0px;">
				بيانات شخصية
			</div>

			<div class="clr"></div>

			<div class="row">
				<div class="right">
					<div class="label">اسم المستخدم</div>
					<input type="text" style="background:#FAFFBD" class="txt" id="register-username" name="Register[username]" value="{{ Input::old('Register.username') }}" />
				</div>
				<div class="left">
					<div class="label">كلمة المرور</div>
					<input type="password" style="background:#FAFFBD" class="txt" name="Register[password]" id="register-password" />
					<div class="clr"></div>
					<div class="info" style="float:left; font-size:11px; color:#999" id="password-char">
						أنت تكتب بالغة <span style="color:#900">العربية</span>
					</div>
				</div>
			</div>

			<div class="clr"></div>


			<div class="row">
				<div class="right">
					<div class="label">الاسم الاول</div>
					<input type="text" class="txt" name="Register[first_name]" value="{{ Input::old('Register.first_name') }}" />
				</div>
				<div class="left">
					<div class="label">اسم الاب</div>
					<input type="text" class="txt" name="Register[father_name]" value="{{ Input::old('Register.father_name') }}" />
				</div>
			</div>
			<div class="clr"></div>
			
			<div class="row">
				<div class="right">
					<div class="label">اسم الجد</div>
					<input type="text" class="txt" name="Register[grand_father_name]" value="{{ Input::old('Register.grand_father_name') }}" />
				</div>
				<div class="left">
					<div class="label">اسم العائلة</div>

					<div id="family-slct-div" style="float:right;">
						<select class="normal-slct basic-select" id="family-slct" name="Family[id]">
							<option value=""></option>
							@foreach($families as $family)
								<option value="{{ $family->id }}">{{ $family->name }}</option>
							@endforeach
						</select>
					</div>
					<input type="text" class="txt" id="family-txt" name="Family[name]" /><br />
					<div class="clr"></div>
					<div class="info" style="">
						<a style="" href="javascript:void(0)" id="family-change-link">لم تجد عائلتك هنا ؟</a>
					</div>
					
				</div>
			</div>
			<div class="clr"></div>

			<div class="row">
				<div class="all">
					<div class="label" style="width:150px;">هل انت من أبناء عرابة؟</div>
					<input type="radio" id="true-arrabah" name="Register[from_arrabah]" value="true" /> نعم
					<input type="radio" id="false-arrabah" name="Register[from_arrabah]" value="false" /> لا
				</div>
			</div>
			<div class="clr"></div>
			
			<div class="form-header">
				بيانات إضافية مطلوبة
			</div>

			<div class="clr"></div>
			
			<div class="row">
				<div class="right">
					<div class="label">العمر</div>
					<input type="radio" id="age-above" name="Register[age]" value="above" /> أكبر من 18 سنة
					<input type="radio" id="age-below" name="Register[age]" value="below" /> أصغر من 18 سنة
				</div>
			</div>
			<div class="clr"></div>
			
			<div class="row">
				<div class="right">
					<div class="label">تاريخ الميلاد</div>
					<input type="text" class="txt datepicker-basic" name="Register[day_of_birth]" value="{{ Input::old('Register.day_of_birth') }}" />
				</div>
				<div class="left">
					<div class="label">مكان الميلاد</div>
					<input type="text" class="txt" name="Register[place_of_birth]" value="{{ Input::old('Register.place_of_birth') }}" />
				</div>
			</div>
			<div class="clr"></div>
			
			<div class="row">
				<div class="right">
					<div class="label">الجنس</div>
					<select class="special basic-select" name="Register[sex]" id="sex-slct">
						<option></option>
						<option value="male">ذكر</option>
						<option value="female">أنثى</option>
					</select>
				</div>
			</div>
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
				
				<div id="region-slct-div">
					<select class="special basic-select" id="region-slct" name="Address[region]" value="{{ Input::old('Address.region') }}">
						<option value=""></option>
					</select>
				</div>
			</div>
			<div class="clr"></div>
			
			<div class="form-header">
				بيانات التواصل
			</div>

			<div class="clr"></div>
			
			<div class="row">
				<div class="right">
					<div class="label">رقم الهاتف</div>
					<input type="text" class="txt" name="Register[telephone_no]" value="{{ Input::old('Register.telephone_no') }}" />
				</div>
				<div class="left">
					<div class="label">البريد الإلكترونى</div>
					<input type="text" class="txt" name="Register[email]" value="{{ Input::old('Register.email') }}" />
				</div>
			</div>
			<div class="clr"></div>
			
			<div class="form-header">
				الصورة الشخصية
			</div>

			<div class="clr"></div>

			<div class="row">
				<div class="right">
					<div class="label">رفع الصورة</div>
					<input type="file" class="file" name="Register[image]" />
				</div>
			</div>
			<div class="clr"></div>
			
			<div class="form-header">
				رمز التأكيد 
			</div>

			<div class="clr"></div>
			
			<div class="row">
				<div class="all">
					<input type="text" class="txt" name="Register[spam-check]" />
					<div class="info" style="float:right; padding:10px;">
						لا يمكنك قرائة الرمز؟ أضغط <a href='javascript: refreshCaptcha();'>هنا</a> لتحميل رمز جديد
					</div>
					<div class="clr"></div>
					<img src="{{ URL::route('request-captcha', array(rand())) }}" id='captchaimg'>
				</div>
			</div>
			<div class="clr"></div>

			<div class="row buttons">
				<input type="submit" class="register-btn grey-btn" value="التسجيل" />
			</div>
			
			<div class="clr"></div>
		</div>
	</form>

</div><!-- END of white-box -->