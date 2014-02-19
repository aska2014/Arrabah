<script type="text/javascript">
    $(document).ready(function()
    {
        $( '.datepicker-basic' ).datepicker({ changeMonth: true, changeYear: true, defaultDate:  new Date(1990, 1, 1), });

        $("#country-slct").select2({placeholder: 'أسم الدولة'});
        $("#city-slct").select2({placeholder: 'أسم المدينة'});

    });

    $(document).ready(function()
    {

        // Initalize vars from old input
        hideSlct( $("#city-slct") );
        hideSlct( $("#region-slct") );

	@if($userCountry)

        showSlct( $("#country-slct") );
        $("#country-slct").select2('val', "{{ $userCountry }}");
        loadTarget( $("#country-slct"), $("#" + $("#country-slct").attr('target')), function()
        {
            @if($userCity)

            showSlct( $("#city-slct") );
            $("#city-slct").select2("val", "{{ $userCity }}");

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
    });


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