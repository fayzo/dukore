$(document).ready(function() {
    var win  = $(window);
    var offset= 10;

    win.scroll(function () {
        if ($(document).height() <= (win.height() + win.scrollTop())) {
            offset +=10;
            $('#loader').show();
         
        $.ajax({
                    url: 'core/ajax/fetchpPost.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        fetchPost: offset,
                    }, success: function (response) {
                        $('.tweets').html(response);
                        $('#loader').hide();

                        console.log(response);
                    }
                });
        }
        
    })

});
