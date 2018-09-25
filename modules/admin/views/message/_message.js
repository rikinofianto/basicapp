//Enable iCheck plugin for checkboxes
//iCheck for checkbox and radio inputs
$('.mailbox-messages input[type="checkbox"]').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
});

//Enable check and uncheck all functionality
$(".checkbox-toggle").click(function () {
    var clicks = $(this).data('clicks');
    if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
    } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
    }
    $(this).data("clicks", !clicks);
});

//Handle starring for glyphicon and font awesome
$(".mailbox-star").click(function (e) {
    e.preventDefault();
    //detect type
    var $this = $(this).find("a > i");
    var glyph = $this.hasClass("glyphicon");
    var fa = $this.hasClass("fa");

    //Switch states
    if (glyph) {
        $this.toggleClass("glyphicon-star");
        $this.toggleClass("glyphicon-star-empty");
    }

    if (fa) {
        $this.toggleClass("fa-star");
        $this.toggleClass("fa-star-o");
    }
});

$(document).on('click', '.trash', function() {
    var list = $('table').find('input[type=checkbox]:checked');
    var val  = populateCheckbox(list);
    var url  = '/admin/message/delete';
    var data = {type:action,id:val};

    if (val != '[]') {
        var conf = confirm('Yakin akan dihapus?');
        if (!conf) {
            return false;
        }
    }

    $.post(url, data).done(function(r) {
        if (r.value > 0) {
            location.reload();
        }
    });
});

var populateCheckbox = function(list) {
    var data = [];
    list.each(function(k, v) {
        data.push(v.value);
    });
    return JSON.stringify(data);
}