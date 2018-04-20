export default function() {
	let button = document.getElementById('#go-top');
	const CLASS_SHOW = 'go-top--js-show';

	if (button) {
		window.addEventListener('scroll', function () {
			if (window.scrollY >= 300) {
				button.classList.add(CLASS_SHOW);
			}
			else {
				button.classList.remove(CLASS_SHOW);
			}
		})

		button.addEventListener('click', function () {
			window.scrollTo(0, 0);
		})
	}
}
