$(document).ready(function () {
    $('.folow').click(function () {

        var f_id = $(this).attr('data-friend-id');
        var button = $(this);

        console.log( $(this).attr('data-folow') );

        if( $(this).attr('data-folow') == 0 ){
            $.ajax({
                type: "POST",
                url: "/folow",
                data: {
                    f_id: f_id
                },
                success: function (response) {
                    if(response.save === true){
                        button.attr('data-folow', 1);
                        button.text('Folowed');
                        button.removeClass('btn-success').addClass('btn-warning')
                    }
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "/notfolow",
                data: {
                    f_id: f_id
                },
                success: function (response) {
                    if(response.removed === true){
                        button.attr('data-folow', 0);
                        button.text('Folow');
                        button.removeClass('btn-warning').addClass('btn-success')
                    }
                }
            });
        }
    });

})