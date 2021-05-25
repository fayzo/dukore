$(document).ready(function() {
    $(document).on('click','#send',function () {
        var message= $('#msg').val();
        var get_id= $(this).data('user');

        $.ajax({
                    url: 'core/ajax/messages.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        sendMessage: message,
                        get_idd: get_id,
                    }, 
                    success: function (response) {
                        getmessages();
                        $("#msg").val('');
                        console.log(response);
                    }
                });
       });
});
