/**
 * Created by hiweb on 09.08.2016.
 */

var hw_io_tool = {

    data: [],
    total: 0,
    current: 0,


    init: function (data, start_button_selector) {
        hw_io_tool.data = data;
        if(typeof data == 'object') { hw_io_tool.total = data.length; }
        hw_io_tool.make_events(start_button_selector)
    },

    make_events: function (start_button_selector) {
        jQuery(start_button_selector).on('click', function () {
            jQuery(this).fadeOut();
            hw_io_tool.do_step(hw_io_tool.do_end);
        });
    },

    do_step: function (fn_end) {
        if (typeof hw_io_tool.data != 'object') {
            if (typeof fn_end == 'function') {
                fn_end();
            }
            return;
        }
        if (hw_io_tool.data.length == 0) {
            if (typeof fn_end == 'function') {
                fn_end();
            }
            return;
        }
        ///
        var element = hw_io_tool.data.pop();
        hw_io_tool.current ++;
        jQuery.ajax({
            url: ajaxurl + '?action=hiweb_image_orient',
            type: 'post',
            dataType: 'json',
            data: {do: 'reorient', id: element.id},
            success: function (data) {
                console.info(data);
                hw_io_tool.do_step(fn_end);
                hw_io_tool.loader_update();
            },
            error: function (data) {
                console.warn(data);
                hw_io_tool.do_step(fn_end);
            }
        });

    },


    do_end: function(){
        jQuery('.media-toolbar').hide();
        jQuery('[data-count]').html(hw_io_tool.total);
        jQuery('.hw_io_message_done').fadeIn();
    },

    loader_update: function(){
        jQuery('.progress-bar > div').css('width', hw_io_tool.current / hw_io_tool.total * 100 + '%');
    }

};