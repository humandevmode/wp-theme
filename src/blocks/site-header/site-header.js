import './site-header.scss';

let $header;
let lastScrollTop = 0;

jQuery(function($) {
  $header = $('#site-header');

  $(window).scroll(function(event) {
    let st = $(this).scrollTop();

    if (st > lastScrollTop && st > 120) {
      //scroll down
      $header.addClass('site-header--js-hide');
    }
    else {
      //scroll up
      $header.removeClass('site-header--js-hide');
    }
    lastScrollTop = st;
  });
});

export {
  $header,
  lastScrollTop
}
