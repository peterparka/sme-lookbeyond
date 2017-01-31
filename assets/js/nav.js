$nav = $('.js-nav');

$('.hamburger').on('click', function() {

    $(this).toggleClass('is-active');

    $nav.toggleClass('is-active');
});
