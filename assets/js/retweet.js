$(document).ready(function() {
  $(document).on('click','.retweet',function() {
       $tweet_id= $(this).data('tweet');
       $tweet_by= $(this).data('user');
       $counter= $(this).find('.retweetcounter');
       $count= $counter.text();
       $button= $(this);

         $.ajax({
                    url: 'core/ajax/retweet.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        showpopretweet: $tweet_id,
                        tweet_By: $tweet_by,
                    }, success: function (response) {
                        $('.popupTweet').html(response);
                        $('.close-retweet-popup').click(function() {
                             $('.retweet-popup').hide();
                        });

                        console.log(response);
                    }
                });
      });

    $(document).on('click','.retweet-it',function() {
    //    var tweet_id= $('.retweet').data('tweet');
    //    var tweet_by= $('.retweet').data('user');
    //    var counter= $('.retweet').find('.retweetcounter');
    //    var count= counter.text();
    //    var button= $('.retweet');
       $comment = $('.retweetMsg').val();

         $.ajax({
                    url: 'core/ajax/retweet.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        retweet: $tweet_id,
                        tweet_By: $tweet_by,
                        comments: $comment
                    }, success: function (response) {
                        $('.retweet-popup').hide();
                        $count++;
                        $counter.text($count++);
                        $button.removeClass('.retweet').addClass('.retweeted');

                        console.log(response);
                    }
                });
      });
});
