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
	
	$.localScroll();
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


