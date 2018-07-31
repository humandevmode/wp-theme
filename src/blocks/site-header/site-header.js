import './site-header.scss';

jQuery(function($) {
  window.$siteHeader = $('#site-header');
  let $header = window.$siteHeader;
  let lastScrollTop = 0;

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
