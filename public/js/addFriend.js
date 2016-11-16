$(document).ready(function () {
    $('#requestSentModel').hide();
    $('#deleteFriendModel').hide();
    $('#addFriendModel').hide();
    $("body").delegate(".sendFriendRequest", "click", function(){
        var friend_id = $(this).attr('data-friend-id');
        var button = $(this);
        var dd = $(this).parents('.tools');
        var cloneModel = $('#requestSentModel').children().clone();
        var a = cloneModel.find("a").attr("data-friend-id", friend_id);
        // console.log(a);
        var dropdown = cloneModel.show();

            $.ajax({
                type: "POST",
                url: "/friendRequest",
                data: {
                    friend_id: friend_id
                },
                success: function (response) {
                    if(response.save === true){
                        dd.append(dropdown);
                        button.hide();
                    }
                }
            });
    });

    $("body").delegate(".cancelFriendRequest", "click", function(){
        var friend_id = $(this).attr('data-friend-id');
        var button = $(this).parents('.dropdown');
        var dd = $(this).parents('.tools');
        var addFriend = $('#addFriendModel').children().clone();
        var a = addFriend.attr("data-friend-id", friend_id);

        $.ajax({
            type: "POST",
            url: "/cancelOrDeleteFriendRequest",
            data: {
                friend_id: friend_id
            },
            success: function (response) {
                if (response.removed === true) {
                    button.hide();
                    dd.append(addFriend);
                }
            }
        })
    });

    $("body").delegate(".deleteFriend", "click", function(){
        var friend_id = $(this).attr('data-friend-id');
        var button = $(this).parents('.dropdown');
        var dd = $(this).parents('.tools');
        var addFriend = $('#addFriendModel').children().clone();
        var a = addFriend.attr("data-friend-id", friend_id);

        $.ajax({
            type: "POST",
            url: "/cancelOrDeleteFriendRequest",
            data: {
                friend_id: friend_id
            },
            success: function (response) {
                if(response.removed === true){
                    button.hide();
                    dd.append(addFriend);
                }
            }
        });
    });

    $("body").delegate(".accept", "click", function(){
        var friend_id = $(this).attr('data-friend-id');
        var accept = $(this);
        var dd = $(this).parents('.tools');
        var deleteFriend = $('#deleteFriendModel').children().clone();
        var a = deleteFriend.find("a").attr("data-friend-id", friend_id);
            $.ajax({
                type: "POST",
                url: "/acceptFriendRequest",
                data: {
                    friend_id: friend_id
                },
                success: function (response) {
                    if(response.save === true){
                        accept.hide();
                        accept.next().hide();
                        dd.append(deleteFriend);
                    }
                }
            })
    })
    $("body").delegate(".cancel", "click", function() {
        var friend_id = $(this).attr('data-friend-id');

        var cancel = $(this);
        var dd = $(this).parents('.tools');
        var cancelRequest = $('#addFriendModel').children().clone();
        var a = cancelRequest.attr("data-friend-id", friend_id);

        $.ajax({
            type: "POST",
            url: "/cancelOrDeleteFriendRequest",
            data: {
                friend_id: friend_id
            },
            success: function (response) {
                if (response.removed === true) {
                    cancel.hide();
                    cancel.prev().hide();
                    dd.append(cancelRequest);
                }
            }
        });
    })


    $("#searchForm").keydown(function (e) {
        if (e.keyCode == 13) {

            // if ($('#searchUsers').val() !== '') {
            //     // $("#searchForm").submit();
            // }
        }

    })
});