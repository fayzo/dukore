$(document).ready(function () {
    $(document).on('click','.addTweetBtn',function () {
        $('.status').removeClass().addClass('status-remove');
        $('.hash-box').removeClass().addClass('hash-remove');
        $('#count').attr('id','count-remove');
        $('#file').attr('id','file');

              $.ajax({
                    url: 'core/ajax/popupTweetForm.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                    }, success: function (response) {
                        $(".popupTweet").html(response);
                         $(".closeTweetPopup").click(function () {
                             $('.status-remove').removeClass().addClass('status');
                             $('.hash-remove').removeClass().addClass('hash-box');
                             $('#count-remove').attr('id','count');
                             $(".popup-tweet-wrap").hide();
                        });

                        console.log(response);
                    }
                });
     });

    $(document).on('submit',"#popupForm", function (e) {
        e.preventDefault();
        var result= '';
        var FormDAta= new FormData($(this)[0]);
        FormDAta.append('file',$('#file')[0].files[0]);
        console.log($('#popupForm').serialize());
         

            $.ajax({
                     url: 'core/ajax/addTweet.php',
                     method: 'POST',
                     data: FormDAta,
                     cache:false,
                     contentType:false,
                     processData: false,
                     success: function (response) {
                        //  result= JSON.parse(response);

                             if (result.error) {
                                 $('<div class="error-banner"><div class="error-banner-inner"><p id="errorMsg">' + result.error + '</p></div></div>').insertBefore('.header-wrapper');
                                 $('.error-banner').hide().slideDown(300).delay(5000).slideUp(300);
                                 $('.popup-tweet-wrap').hide();

                             } else if (result.success) {
                                 $('<div class="error-banner"><div class="error-banner-inner"><p id="errorMsg">' + result.success + '</p></div></div>').insertBefore('.header-wrapper');
                                 $('.error-banner').hide().slideDown(300).delay(5000).slideUp(300);
                                 $('.popup-tweet-wrap').hide();
                             }
                             
                             $('.status-remove').removeClass().addClass('status');
                             $('.hash-remove').removeClass().addClass('hash-box');
                             $('#count-remove').attr('id', 'count');
                             $(".popup-tweet-wrap").hide();
                             console.log(response);

                        }
                   });
                    
         }); //#popupForm End form submitted 

});