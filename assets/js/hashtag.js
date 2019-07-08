$(document).ready(function() {
    var regex = /[#|@](\w+)$/ig;
    $(document).on('keyup','.status',function () {
        var content = $.trim($(this).val());
        var text = content.match(regex);
        var max= 140;
        if (text != null) {
            var datastring= ''+text;
         
         $.ajax({
                    url: 'core/ajax/gethashtag.php',
                    method: 'POST',
                    dataType: 'text',
                    cache:false,
                    data:{
                        hashtag:datastring
                    }, success: function (response) {
                        $(".hash-box ul").html(response).hover();
                        $(".hash-box li").click(function () {
                            var value = $.trim($(this).find('.getValue').text());
                            var oldcontent = $('.status').val();
                            var newcontent = oldcontent.replace(regex, '');
                            $('.status').val(newcontent + value + '');
                            $(".status").html(response);
                            $('.hash-box li').hide();
                            $('.status').focus();
                            $('#count').text(max - content.length);
                        });
                        console.log(response);
                    }
                });
          }else{
                $('.hash-box li').hide();
          }
           $('#count').text(max - content.length);
           if (content.length === max) {
               $('#count').css('color','red');
          }else{
              $('#count').css('color','black');
          }
      });
});