$(document).ready(function() {
    notification = function () {
        
        $.ajax({
            url: 'core/ajax/notification.php',
            method: 'GET',
            dataType: 'json',
            data: {
                showNotification: true,
            }, success: function (response) {
                if (response) {
                    if (response.notification > 0) {
                        $('#notification').addClass('span-i');
                        $('#notification').html(response.notification);
                    }
                    if (response.messages > 0) {
                        $("#messages").show();
                        $('#messages').addClass('span-i');
                        $('#messages').html(response.messages);
                    }
                }
                console.log(response);
            }
        });
    };
setInterval(notification, 10000);
});