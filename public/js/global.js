WebFont.load({google:{families:['Droid Arabic Kufi']}});$(document).ready(function(){$(".events > .content").easySlider({autoPlay:true,pagination:false,autoSpeed:3000,speed:1000});$(".image-slider").easySlider({pagination:false,autoPlay:true,autoSpeed:3000,speed:1000});$(".title-font").css('font-family','Droid Arabic Kufi');$(".slides_container .slide").css('display','block');$(".errors .close, .success .close").live('click',function(){$(this).parent().fadeTo("slow",0,function(){$(this).remove()})});if($.browser.webkit){$(".search-btn").css('top','2px')}if(!$.browser.webkit){$(".title-font").css({'line-height':'40px'});$("#top-header h2").css({'position':'relative','bottom':'7px'});$("#top-header-form").css({'position':'relative','top':'3px'});$("#top-header-form .btn").css({'top':'0px'})}$(".plus-icon").each(function(){$(this).parent().css('cursor','pointer')});$(".plus-icon").parent().click(function(){triggerPlusIcon($(this).next('div'),$(this).find(".plus-icon"))});$('.boxgrid.caption').hover(function(){$(".cover",this).stop().animate({top:'125px'},{queue:false,duration:160})},function(){$(".cover",this).stop().animate({top:'175px'},{queue:false,duration:160})});preLoadImages(['images/light-grey-gradient.jpg'])});function preLoadImages(images){imageObj=new Image();for(var i=0;i<images.length;i++){imageObj.src=assetUrl+'css/'+images[i]}}function triggerPlusIcon(target,button){if(target.is(":visible")){target.slideUp('slow');if(button!==undefined)button.html('إظهار')}else{target.slideDown('slow');if(button!==undefined)button.html('إخفاء')}}function addLoadingIcon(x,y){removeLoadingIcon();$('<div class="circle-loader"></div>').css({left:x-10+'px',top:y-10+'px',}).prependTo('body')}function removeLoadingIcon(){$(".circle-loader").remove()}function showMessage(type,messages){var string='<div class="'+type+'"><div class="close">×</div><ul>';if(messages instanceof Array){for(var i=0;i<messages.length;i++){string+='<li>'+messages[i]+'</li>'}}else{string+='<li>'+messages+'</li>'}string+='</ul></div>';$("#left-body").prepend(string)}
(function(e){e.fn.toolTip=function(){this.each(function(){var t=e('<div class="tool-tip"></div>');e(this).mouseenter(function(n){t.html(e(this).attr("tip"));t.css({position:"absolute",top:n.pageY+5,left:n.pageX+5,display:"none"});e("body").append(t);t.fadeTo(200,1)}).mouseleave(function(){t.remove()})})}})(jQuery)

$(document).ready(function(){
    setTimeout('show_argent()',5000);

    loadNewsRss();
});

var rssItem = null;

function loadNewsRss()
{
    $.ajax({
        url: 'http://pipes.yahoo.com/pipes/pipe.run?_id=2382d7300fd8bdfed2d8be8696ecfc0c&_render=json',
        type: 'GET',
        dataType: 'json',
        success:function(d){
            rssItem = d.value.items[0];
        }
    });
}

function show_argent(){

    if(rssItem == null)
    {
        setTimeout('show_argent()', 2000);
    }
    else
    {
        if($.cookie('rssItemPubDate') != rssItem.pubDate)
        {
            $.cookie("rssItemPubDate", rssItem.pubDate, { expires: 7 });

            $("#argent_news").show('slow');
            $("#argent_news > h3").html("<a href='" + rssItem.link + "' target='_blank'>" + rssItem.title + "</a>");
            $("#argent_news > #argent_body").html(rssItem.description);
        }
    }
}