$(document).ready(function(){  
    //To switch directions up/down and left/right just place a "-" in front of the top/left attribute  
    //Vertical Sliding  
    $('.boxgrid.slidedown').hover(function(){
        $(".cover", this).stop().animate({top:'-195px'},{queue:false,duration:300});  
    }, function() {  
        $(".cover", this).stop().animate({top:'0px'},{queue:false,duration:300});  
    });  
    //Horizontal Sliding  
    $('.boxgrid.slideright').hover(function(){  
        $(".cover", this).stop().animate({left:'260px'},{queue:false,duration:300});  
    }, function() {  
        $(".cover", this).stop().animate({left:'0px'},{queue:false,duration:300});  
    });  
    //Diagnal Sliding  
    $('.boxgrid.thecombo').hover(function(){  
        $(".cover", this).stop().animate({top:'195px', left:'325px'},{queue:false,duration:300});  
    }, function() {  
        $(".cover", this).stop().animate({top:'0px', left:'0px'},{queue:false,duration:300});  
    });  
    //Partial Sliding (Only show some of background)  
    $('.boxgrid.peek').hover(function(){  
        $(".cover", this).stop().animate({top:'25px'},{queue:false,duration:160});  
    }, function() {  
        $(".cover", this).stop().animate({top:'0px'},{queue:false,duration:160});  
    });
    //Caption Sliding (Partially Hidden to Visible)  
    $('.boxgrid.caption').hover(function(){  
        $(".cover", this).stop().animate({top:'105px'},{queue:false,duration:160});  
    }, function() {  
        $(".cover", this).stop().animate({top:'165px'},{queue:false,duration:160});  
    });  
});