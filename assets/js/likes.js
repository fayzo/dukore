$(document).ready(function() {
  $(document).on('click','.like-btn',function() {
      var tweet_id= $(this).data('tweet');
      var user_id= $(this).data('user');
      var likescounter= $(this).find('.likescounter');
      var counter= likescounter.text();
      var button= $(this);

         $.ajax({
                    url: 'core/ajax/likes.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        like: tweet_id,
                        userid: user_id,
                    }, success: function (response) {
                        likescounter.show();
                        button.addClass('.unlike-btn');
                        button.removeClass('.like-btn');
                        counter++;
                        likescounter.text(counter++);
                        button.find('.fa-heart-o').addClass('.fa-heart').css('color','red');
                        button.find('.fa-heart').removeClass('.fa-heart-o');

                        console.log(response);
                    }
                });
      });
});


$(document).ready(function() {
  $(document).on('click','.unlike-btn',function() {
      var tweet_id= $(this).data('tweet');
      var user_id= $(this).data('user');
      var likescounter= $(this).find('.likescounter');
      var counter= likescounter.text();
      var button= $(this);

         $.ajax({
                    url: 'core/ajax/likes.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        unlike: tweet_id,
                        userid: user_id,
                    }, success: function (response) {
                        likescounter.show();
                        button.addClass('.like-btn');
                        button.removeClass('.unlike-btn');
                        counter--;
                        if (counter === 0) {
                            likescounter.hide();
                        }else{
                            likescounter.text(counter--);
                        }
                        button.find('.fa-heart').addClass('.fa-heart-o');
                        button.find('.fa-heart-o').removeClass('.fa-heart').css('color','red');

                        console.log(response);
                    }
                });
      });
});