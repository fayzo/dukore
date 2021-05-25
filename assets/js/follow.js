$(document).ready(function() {
  $(document).on('click','.follow-btn',function() {
      var follow_id = $(this).data('follow');
      var button = $(this);
      if (button.hasClass('following-btn')) {

             $.ajax({
                    url: 'core/ajax/follow.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        unfollow: follow_id,
                    }, success: function (response) {
                        // response = JSON.parse(response);
                        button.removeClass('following-btn');
                        button.removeClass('unfollow-btn');
                        button.html('<i class="fa fa-user-plus"></i>Follow');
                        $('.count-following').text(response.following);
                        $('.count-followers').text(response.followers);

                        console.log(response);
                    }
                });
          
      }else{

            $.ajax({
                    url: 'core/ajax/follow.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        follow: follow_id,
                    }, success: function (response) {
                        // response = JSON.parse(response);
                        button.removeClass('follow-btn');
                        button.addClass('following-btn');
                        button.text('Following');
                        $('.count-following').text(response.following);
                        $('.count-followers').text(response.followers);

                        console.log(response);
                    }
                });
      }
  });
  $('.follow-btn').hover(function () {
      $button= $(this);
      if ($button.hasClass('following-btn')) {
          $button.addClass('unfollow-btn');
          $button.text('unfollow');
      }
      
  },function () {
       if ($button.hasClass('following-btn')) {
          $button.removeClass('unfollow-btn');
          $button.text('Following');
      }
  });
});