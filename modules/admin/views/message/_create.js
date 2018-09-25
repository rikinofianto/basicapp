autocompletecall('#message-destination', '/admin/message/destination');


function autocompletecall(id, url, success_function) {
    var _count= 0;
    $(id).bind('keyup.autocomplete', function() {
        var dest_type = $('#message-destination_type').val();
        $(this).autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: "json",
                    data: {
                        name: request.term,
                        type: dest_type
                    },
                    success: function(data) {
                        $(id).removeClass('loading');
                        response($.map(data.value, function(item) {
                        return {
                            label: item.label
                            }
                        }));
                    }
                });
            },
            error: function() {
                $(id).removeClass('loading');
            },
            focus: function(event, ui) {
                $(this).val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                setDestination(ui.item, dest_type, _count);
                if (success_function)
                    success_function(ui);
                _count++;
                return false;
            },
            search: function(){$(id).addClass('loading');},
            open: function(){$(id).removeClass('loading');}
        });
    });
}

var setDestination = function(item, dest_type, _count) {
    var html = '';
    html += '<div>';
    html += '<div class="label label-warning">' + item.label;
    html += '</div>';
    html += "<button type='button' class='btn btn-danger delete-dest'>x</button>";
    html +=  "<input type='hidden' id='message-destination' name='Message[destination][" 
                    + dest_type + "]["+ _count +"]' value ='"+ item.value +"'>";
    html += '</div>';
    console.log(item);

    $('.list-destination').append(html);
}

$(document).ready(function () {
    $(document).on('click', '.delete-dest', function () {
        $(this).parent().remove();
        return false;
    });
});  