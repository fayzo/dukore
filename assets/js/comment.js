$(document).ready(function () {
    $(document).on('click','#postComment',function () {
        var comment = $('#commentField').val();
        var tweet_id = $('#commentField').data('tweet');

        if (comment != "") {
              $.ajax({
                    url: 'core/ajax/comment.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        comments: comment,
                        tweet_id: tweet_id,
                    }, success: function (response) {
                        $('#comments').html(response);
                        $('#commentField').val("");
                        console.log(response);
                    }
                });
        }

    });
});