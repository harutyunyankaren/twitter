$(document).ready(function () {
    $('body').delegate('.send', 'keydown' ,function (e) {
        var text = $(this).val();
        var element = $(this);
        var getter_id = $('#text').attr('data-friend-id');
        var auth_name = $('#text').attr('data-auth-name');

        if (text != "" && e.keyCode == 13) {
            $.ajax({
                url: '/sendMessage',
                type: 'POST',
                data: {
                    text: text,
                    getter_id: getter_id
                },
                success: function (response) {
                    if(response){
                        $('.chat').append('<div class="me">' + 'You'+ ':' + text + '</div>');
                    }
                }
            });
            element.val("");
        }
    });

    $(function() {
        $('.read-chat-box').focus();
    });

    $('body').delegate('.read-chat-box', 'focus', function () {
        var getter_id = $('.read-chat-box').attr('data-friend-id');
        var getter_id = $('.read-chat-box').attr('data-friend-id');
        var getter_id = $('.read-chat-box').attr('data-friend-id');
        var room_id = $("input[name='room_id']").val();
        var sender_id = $("input[name='sender_id']").val();
        var chat_box = $(".chat-box .chat");
        console.log(room_id);
        setInterval(function () {
            $.ajax({
                url: '/updateMessage',
                type: 'POST',
                data: {
                    room_id: room_id,
                    sender_id: sender_id
                },
                success: function (response) {
                    if (response){
                        var newMessages = response;
                        $.ajax({
                            url: '/readMessage',
                            type: 'POST',
                            data: {
                                getter_id: sender_id,
                                read: 'true'
                            },
                            success: function (response) {

                            }
                        });

                        if(typeof newMessages.messages != 'undefined' && newMessages.messages.length > 0){
                            var sender_name = newMessages['sender_name'];
                            console.log(sender_name);

                            $.each(newMessages['messages'], function (index) {
                                console.log(newMessages['messages'][index]);
                                if(newMessages['messages'][index]['sender_id'] == sender_id){
                                    chat_box.append("<div class='box you'>"  + newMessages['messages'][index].massege + ':' + sender_name +"</div>");
                                }
                            });
                        }
                    }
                }
            });
        },3000)

    });


    $('body').delegate('.newMassege', 'click', function () {
        var chats;
        var newMessage = $(this)
        var chat_box = $(".chat-box .chat");
        var sender_id = $(this).attr('data-id');
        var auth_name = $(this).attr('data-auth-name');

            $.ajax({
                url: 'newMessage',
                type: "POST",
                data: {
                    sender_id: sender_id
                },
                success: function (response) {
                    if (response){
                        newMessage.removeClass('alert-info').addClass('alert-success');
                        newMessage.children('.badge').hide();
                        chats = response;
                        $('.send').remove();
                        chat_box.html('');
                        var room_id = chats[0]['messages'][0].room_id;

                        $.each(chats, function (index) {
                            // console.log(chats[index]['messages']);
                            $.each(chats[index]['messages'], function (dd) {
                                if(chats[index]['messages'][dd].sender_id == sender_id){
                                    chat_box.append("<div class='box you'>"  + chats[index]['messages'][dd].massege + ':'
                                        + chats[index]['sender_name'] + "</div>");
                                } else{
                                    chat_box.append("<div class='box me'>" +'You' + ':' + chats[index]['messages'][dd].massege + "</div>");
                                }
                            })

                        });
                        $("#scroll").animate({ scrollTop: $('#scroll').height()}, 0);
                        $('.chat-box').append("<input type='text' id='text' class='form-control send' data-friend-id=''" +
                            "data-auth-name=''>");
                        $('.send').attr('data-friend-id', sender_id);
                        $('.send').attr('data-auth-name', auth_name);

                        setInterval(function () {
                            $.ajax({
                                url: '/updateMessage',
                                type: 'POST',
                                data: {
                                    room_id: room_id,
                                    sender_id: sender_id
                                },
                                success: function (response) {
                                    if (response){
                                        var newMessages = response;
                                        $.ajax({
                                            url: '/readMessage',
                                            type: 'POST',
                                            data: {
                                                getter_id: sender_id,
                                                read: 'true'
                                            },
                                            success: function (response) {

                                            }
                                        });

                                        if(typeof newMessages.messages != 'undefined' && newMessages.messages.length > 0){
                                            var sender_name = newMessages['sender_name'];
                                            console.log(sender_name);

                                            $.each(newMessages['messages'], function (index) {
                                                console.log(newMessages['messages'][index]);
                                                if(newMessages['messages'][index]['sender_id'] == sender_id){
                                                    chat_box.append("<div class='box you'>"  + newMessages['messages'][index].massege + ':' + sender_name +"</div>");
                                                }
                                            });
                                        }
                                    }
                                }
                            });
                        },3000)


                        $.ajax({
                            url: '/readMessage',
                            type: 'POST',
                            data: {
                                getter_id: sender_id,
                                read: 'true'
                            },
                            success: function (response) {

                            }
                        });
                    }
                }
            });

    });

    $("#scroll").animate({ scrollTop: $('#scroll').height()}, 0);



        
        setInterval(function () {
            $.ajax({
                url: '/updateCountUserMessage',
                type: 'POST',
                data: { newMessage : 'true' },
                success: function (response) {
                    var countUserMessage = response;
                    $('#message span').html('');
                    $('#message span').addClass('badge badge-notify').html(countUserMessage)
                }
                
            })
        },3000);
        
        




})