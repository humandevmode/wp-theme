jQuery(function($) {
	let $button = $('#go-top');
	let showClass = 'go-top--js-show';

	$(window).scroll(function() {
		if ($(this).scrollTop() >= 300) {
			$button.addClass(showClass);
		} else {
			$button.removeClass(showClass);
		}
	});

	$button.on('click', function() {
		$('html, body').animate({
			scrollTop : 0
		}, 500);
	});
});
