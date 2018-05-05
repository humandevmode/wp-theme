import './hamburger.scss';

export default function () {
	let hamburger = document.getElementById('mobile-menu-trigger');
	const CLASS_TOGGLE = 'js-mobile-menu-open';

	hamburger.addEventListener('click', function () {
		this.classList.toggle('is-active');
		document.body.classList.toggle(CLASS_TOGGLE);
	});
}
