$(function() {
	var winH = $(window).height();
	var winW = $(window).width();
	
	$('.story').css({ 'height': winH });
	
	$.stellar({
		responsive: true
	});
	
	if($(window).width()/winH>1280/720) {
		$("#introVideo, #videoBG").css({
			width:winW,
			height:winW/(1280/720)
		})
	}else{
		$("#introVideo, #videoBG").css({
			width:winH*(1280/720),
			height:winH
		})
	}	
	
	$('.signIn').click(function(e) {
		$('.splash-wrap').css('display', 'block').addClass('active').animate({'opacity': 1});
		$('.content-container').addClass('blur');
		e.preventDefault();
	});	
	
	$.localScroll();
});

$(document).keyup(function(e) {		
    if(e.keyCode == 27) {
       $('.splash-wrap').removeClass('active').animate({'opacity': 0}, 800, function() {
	       $('.splash-wrap').css('display', 'none');
	       $('.content-container').removeClass('blur');
       });
    }
});

$(window).resize(function() {
	var winH = $(window).height();
	var winW = $(window).width();
	
	$('.story').css({ 'height': winH });	
	
		if($(window).width()/winH>1280/720) {
		$("#introVideo, #videoBG").css({
			width:winW,
			height:winW/(1280/720)
		})
	}else{
		$("#introVideo, #videoBG").css({
			width:winH*(1280/720),
			height:winH
		})
	}
});

$('#about').waypoint(function() {
	$('#about .fade').animate({
		opacity: 1
	}, 800);
}, { offset: 300 });

$('#platform').waypoint(function() {
	$('#platform .fade').animate({
		opacity: 1
	}, 500);
}, { offset: 400 });

$('#become').waypoint(function() {
	$('#become .fade').animate({
		opacity: 1
	}, 500);
}, { offset: 200 });

$('#recommend').waypoint(function() {
	$('#recommend .fade').animate({
		opacity: 1
	}, 500);
}, { offset: 200 });

$('#connect').waypoint(function() {
	$('#connect .fade').animate({
		opacity: 1
	}, 500);
}, { offset: 200 });


