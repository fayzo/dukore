$(document).ready(function() {
    $(document).on('click','#messagePopup',function () {
        var getmessage=1;

        $.ajax({
                    url: 'core/ajax/messages.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        showMessage: getmessage,
                    }, success: function (response) {
                        $(".popupTweet").html(response);
                        $("#messages").hide();
                        console.log(response);
                    }
                });
    });

     $(document).on('click','.people-message',function () {
        var get_id= $(this).data('user');

        $.ajax({
                    url: 'core/ajax/messages.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        showChatPopup: get_id,
                    }, success: function (response) {
                        $(".popupTweet").html(response);
                             if (autoscroll) {
                                    scrolldown();
                            }
                            $('#chat').on('scroll',function () {
                                  if ($(this).scrollTop() < this.scrollHeight - $(this).height()) {
                                      autoscroll=false;
                                  }else{
                                      autoscroll=true;
                                  }
                                 console.log(response);
                             });

                         console.log(response);
                         $('.close-msgPopup').click(function () {
                              clearInterval(timer);
                          });
                    }
                });

         getmessages = function () {
              
             $.ajax({
                 url: 'core/ajax/messages.php',
                 method: 'POST',
                 dataType: 'text',
                 data: {
                     showChatMessage: get_id,
                 }, success: function (response) {
                     $(".main-msg-wrap").html(response);
                     if (autoscroll) {
                         scrolldown();
                     }
                     $('#chat').on('scroll', function () {
                         if ($(this).scrollTop() < this.scrollHeight - $(this).height()) {
                             autoscroll = false;
                         } else {
                             autoscroll = true;
                         }
                         console.log(response);
                     });

                     $('.close-msgPopup').click(function () {
                         clearInterval(timer);
                     });
                 }
             });
         };

        var timer=  setInterval(getmessages, 1000);
        getmessages();
        autoscroll=true;
         scrolldown = function () {
             $('#chat').scrollTop($('#chat').scrollHeight);
         };

        $(document).on('click','.back-messages',function () {
        var getmessage=1;

                 $.ajax({
                             url: 'core/ajax/messages.php',
                             method: 'POST',
                             dataType: 'text',
                             data: {
                                 showMessage: getmessage,
                             }, success: function (response) {
                                 $(".popupTweet").html(response);
                                 clearInterval(timer);
                                 console.log(response);
                             }
                         });
            });

         $(document).on('click','.deleteMsg',function () {
             var message_id= $(this).data('message');
             $('.message-del-inner').height('100px');
            
            $(document).on('click','.cancel',function () {
                $('.message-del-inner').height('0px');
            });

            $(document).on('click','.delete',function () {
                
                    $.ajax({
                                url: 'core/ajax/messages.php',
                                method: 'POST',
                                dataType: 'text',
                                data: {
                                    deleteMessage: message_id,
                                }, success: function (response) {
                                    $('.message-del-inner').height('0px');
                                    getmessages();
                                    console.log(response);
                                }
                            });
            });

         });
    });
});