import './site-overlay.scss';

jQuery(function($) {
  let showClass = 'site-overlay--js-show';
  window.$overlay = $('#site-overlay');

  window.hideModals = function() {
    $('.modal').hide();
  };

  window.showOverlay = function() {
    $overlay.addClass(showClass);
    $page.addClass('noscroll');
  };

  window.hideOverlay = function() {
    hideModals();
    $overlay.removeClass(showClass);
    $page.removeClass('noscroll');
  };

  $overlay.on('click', function(event) {
    if (event.target === this) {
      hideOverlay();
    }
  });

  $(document).keydown(function(e) {
    if (e.keyCode === 27) {
      hideOverlay();
    }
  });
});
