$(document).ready(function () {
    $('.js-like-article').on("click", function(e) {
        e.preventDefault();

        var $link = $(this);
        $link.toggleClass('fa-heart-o fa-heart');

        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function(data) {
            $('.js-like-article-count').html(data.hearts);
        });

    });
});
