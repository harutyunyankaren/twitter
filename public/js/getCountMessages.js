$(document).ready(function () {
    var user_id = $('.newMassege').attr('data-auth-id');

    setInterval(function () {
        $.ajax({
            url: '/updateNewMessage',
            type: 'POST',
            data: { newMessage : 'true' },
            success: function (response) {
                var countNewMessage = response;
                if( typeof (countNewMessage) === 'object'){
                    $.each(countNewMessage,function (index, value) {
                        var friend_id = $('.newMassege').attr('data-id');
                        var sender_id = $('.newMassege input').attr('data-sender-id');

                        if(value['read'] == 0 && value['sender_id'] == sender_id) {
                            if (value['unread'] > 0){
                                $('#'+sender_id).next().show();
                            }

                            $('#'+sender_id).prev().html(value.massege);
                            // $('#'+friend_id).prev().html(value.massege);
                            $('#'+sender_id).next().html(value.unread);
                        }else  {
                            if (value['sender_id'] == friend_id){
                                $('#'+sender_id).prev().html(value.massege);
                            }
                        }
                    })
                }




            }

        })
    },3000);
})