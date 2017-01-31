function getImageSize(img, callback){
    img = $(img);

    var wait = setInterval(function(){
        var w = img.width(),
            h = img.height();

        if(w && h){
            done(w, h);
        }
    }, 0);

    var onLoad;
    img.on('load', onLoad = function(){
        done(img.width(), img.height());
    });


    var isDone = false;
    function done(){
        if(isDone){
            return;
        }
        isDone = true;

        clearInterval(wait);
        img.off('load', onLoad);

        callback.apply(this, arguments);
    }
}

$article = $('.post-infographic');

$imgContainer = $article.find('.image-container');
$imgContainer.append('<a class="btn btn--zoom">Zoom</a>');

$imgSrc = $imgContainer.find('img').attr('src');

$imgContainer.on('click', function() {

	if ($('.popup').length) {
		$popup = $('.popup');
		if ($popup.not(':visible')) {
			$popup.show();
		}
	}
	else {

		$popup = $('<div class="popup"><div class="container--zoomed-image"><img src="'+ $imgSrc +'" class="image--full-size"><button class="btn btn--close">X</button></div></div>');

		$article.append($popup);

		$newImg = $popup.find('.image--full-size');

		getImageSize( $newImg, function(){

			$imgWidth = $newImg.width() + 20;
			$imgHeight = $newImg.height() + 20;

			console.log( $imgWidth );
			console.log( $imgHeight );

			//$newImg.css({'margin-top': - $imgHeight / 2, 'margin-left': - $imgWidth / 2});

			$('.btn--close').on('click', function() {
				$('.popup').fadeOut('fast');
			});

		})
	}
});

$('.watch-action').remove();
