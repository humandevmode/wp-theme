jQuery(function ($) {
	let $hamburger = $('#hamburger');

	$hamburger.on('click', function () {
		this.classList.toggle('is-active');
	});
});
