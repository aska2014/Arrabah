<script type="text/javascript">
$(document).ready(function()
{

	$('#register-password').keypress(function(e)
	{ 
	    var s = String.fromCharCode( e.which );
		var patt = /[ذضصثقفغعهخحجدطكمنتالبيسشئءؤرلاىةوزظ\x00]/;

		var str = $(this).val().substr( $(this).val().length - 1 );

		if(str.match( patt ))

			$("#password-char").html('أنت تكتب بالغة <span style="color:#900">العربية</span>');
		
		else
		
			$("#password-char").html('أنت تكتب بالغة <span style="color:#900">الإنجليزية</span>');

	    if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey )

	    	$("#password-char").html('زر <span style="color:#900">CAPS</span> مفعل');
	});

	$( '.datepicker-basic' ).datepicker({ changeMonth: true, changeYear: true, defaultDate:  new Date(1990, 1, 1), });
	
	$("#sex-slct").select2({placeholder: 'أختار الجنس'});
	$("#family-slct").select2({placeholder: 'أسم العائلة'});
	$("#country-slct").select2({placeholder: 'أسم الدولة'});
	$("#city-slct").select2({placeholder: 'أسم المدينة'});


	$("#sex-slct").select2('val', "{{ Input::old('Register.sex') }}");
	$("#age-{{ Input::old('Register.age') }}").prop("checked", true);
	$("#{{ Input::old('Register.from_arrabah') }}-arrabah").prop("checked", true);

});

$(document).ready(function()
{

	// Initalize vars from old input
	hideSlct( $("#city-slct") );
	hideSlct( $("#region-slct") );

	@if(Input::old('Address.country'))

		showSlct( $("#country-slct") );
		$("#country-slct").select2('val', "{{ Input::old('Address.country') }}");
		loadTarget( $("#country-slct"), $("#" + $("#country-slct").attr('target')), function()
		{
			@if(Input::old('Address.city'))

				showSlct( $("#city-slct") );
				$("#city-slct").select2("val", "{{ Input::old('Address.city') }}");
				console.log("Select2 city {{ Input::old('Address.city') }}");

			@endif
		});

	@endif
	//////////////////////////////////////////////////////////////////////////

	$("#country-slct, #city-slct").change(function()
	{
		var current = $(this);
		var target  = $("#" + current.attr('target'));

		loadTarget( current, target, function(){} );
	});

	// Initalize vars from old input
	$("#family-txt").hide();

	@if(Input::old('Family.id'))

		setFamily(true);
		$("#family-slct").select2('val', "{{ Input::old('Family.id') }}");

	@elseif(Input::old('Family.name'))

		setFamily(false);
		$("#family-txt").val("{{ Input::old('Family.name') }}");

	@endif
	//////////////////////////////////////////////////////////////////////////
	$("#family-change-link").click(function()
	{
		if($("#family-slct-div").is(':visible')) {
			setFamily( false );
		}else {
			setFamily( true );
		}
	});
});

function setFamily( slct )
{
	if(slct) {
		
		$("#family-change-link").html('لم تجد عائلتك هنا ؟');
		$("#family-slct-div").show();
		$("#family-txt").val('');
		$("#family-txt").hide();
	} else {

		$("#family-change-link").html('الرجوع لقائمة العائلات ؟');
		$("#family-slct").select2('val', '');
		$("#family-slct-div").hide();
		$("#family-txt").show();
	}
}

function loadTarget( current, target, successFunction )
{
	fadeSlct( current, 200, 0.4 );
	hideSlct( target );

	// There's another target for this!
	if(target.attr('target')) {
		hideSlct( $("#" + target.attr('target')) );
	}

	$.ajax({
		cache:false,
		type:"GET",
		url:"{{ URL::to('request-cities') }}/" + current.val(),
		success:function( data )
		{
			fadeSlct( current, 200, 1 );
			if(data.length > 0) {
				showSlct( target );
				target.find('option').remove();
				target.append('<option value=""></option>');

				for (var i = 0; i < data.length; i++) {
					var option_txt = data[i].arabic != '' ? data[i].arabic : data[i].english
					target.append($("<option></option>")
				            .attr("value",data[i].id)
				            .text(option_txt)); 
				};

				target.select2('val', '');
	
				successFunction();
			}
		}
	});
}

function fadeSlct( $slct, duration, alpha )
{
	$slct.parent().fadeTo( duration, alpha );
}

function hideSlct( $slct )
{
	$slct.parent().hide();
}

function showSlct( $slct )
{
	$slct.parent().show();
}


//function refreshCaptcha()
//{
//	var img = document.images['captchaimg'];
//	img.src = img.src.substring(0,img.src.lastIndexOf("/"))+"/"+parseInt(Math.random()*1000);
//}

</script>