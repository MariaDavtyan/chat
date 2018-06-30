requests = [];
$(document).ready(function(){
    //send request to get chat info
    $('.chat-name-link').click(function(){

        var chat_id = $(this).attr('data-id');
        var chat_name = $(this).attr('href');
        if (requests.indexOf(chat_name) == -1)
        {
            console.log("done");
            requests.push(chat_name);
            $('.chat-container').append(
                '<div id="' + chat_name.substring(1) + '" class="chat-div">\n' +
                '<h5><strong>' + chat_name.substring(1) + '</strong></h5>\n' +
                '<ul class="list-group message-container media border ' + chat_name.substring(1) + '">\n' +
                '</ul>\n' +
                '<div class="form-group">\n' +
                '<label for="message">Message:</label>\n' +
                '<textarea class="form-control message_area" rows="5" name="text"></textarea>\n' +
                '</div>\n' +
                '<button type="button" class="btn btn-primary send-message" data-id="' + chat_id + '">Send</button>\n' +
                '</div>'
            )

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: 'chat_info',
                dataType: 'JSON',
                data: {chat_id: chat_id},
                success: function (result) {
                    console.log(result);
                    $.each(result, function (res, value) {
                        if (typeof(value.user) != "undefined" && value.user !== null) {
                            $('.' + chat_name.substring(1)).append(
                                '<div class="media-body">' +
                                '<h5>' + value.user.name +
                                ' <small><i>Posted on ' +
                                value.created_at +
                                '</i></small>' +
                                '</h5>' +
                                '<li class="list-group-item">' + value.message + '</li>\n' +
                                '</div>'
                            )
                        }
                        else {
                            $('.' + chat_name.substring(1)).append(
                                '<div class="media-body">' +
                                '<h5>Guest' +
                                ' <small><i>Posted on ' +
                                value.created_at +
                                '</i></small>' +
                                '</h5>' +
                                '<li class="list-group-item">' + value.message + '</li>\n' +
                                '</div>'
                            )
                        }
                    })
                }
            })
        }
    });
    $(document).on('click', '.send-message', function(){
        var message = $(this).parent().find($('.message_area')).val();
        var chat_id = $(this).attr('data-id');
        console.log(message);
        $.ajax
        ({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: 'message',
            dataType: 'JSON',
            data: {message: message, chat_id: chat_id},
            success: function (result)
            {
            }
        })
    });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('ad6015b24f5abc645e0b', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('chat-development');
    channel.bind('App\\Events\\MessagePusherEvent', function(data) {
        //alert(JSON.stringify(data));
        $('.'+data.chat_name).append(
            '<div class="media-body">'+
                '<h5>'+
                    data.name+
                    ' <small><i>Posted on '+
                        data.created_at +
                    '</i></small>'+
                '</h5>'+
                '<li class="list-group-item">'+data.message+'</li>'+
            '</div>'
        );
        $('.message_area').val('');
    });
})