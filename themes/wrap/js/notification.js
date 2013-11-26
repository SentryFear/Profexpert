/**
 * Notification
 * Notification.js class for profexpert
 */
(function($) {
    'use strict';

    $.Notification = function() {

        var lock = 0;

        if($.cookie("lock")) lock = $.cookie("lock");

        var get_notification = function() {
            $.getJSON( "/api/getNotification/"+lock, function( data ) {
                var items = [];
                $.each( data, function( key, val ) {
                    var cls = '';
                    if(val.lock == 1) cls = 'lock';
                    items.push( "<a href='" + val.uri + "#hs" + val.rid + "' data-nid='" + val.id + "' data-scroll-nav='" + val.rid + "' class='item "+ cls +"' data-toggle='tooltip' data-original-title='" + val.text + "'><i class='icon-signin'></i> " + val.name + " <span class='time'><i class='icon-time'></i> " + val.time + "</span></a>" );
                });
                $('.count').html(items.length);
                $('.count1').html(items.length);
                $('.notifications').html('');
                $( items.join( "" ) ).appendTo( ".notifications" );
            });
        };

        var lock_notification = function(ndx) {
            $.getJSON( "/api/lockNotification/"+ndx)
                .success(function() {  })
                .error(function() { alert("Ошибка выполнения"); })
                .complete(function() {  });
            get_notification();
        };

        var show_lock = function() {
            if(lock == 0) $('#notifies').html('<a href="javascript:void(0)" data-nlock="1" class="logout">Показать все уведомления</a>');
            else $('#notifies').html('<a href="javascript:void(0)" data-nlock="0" class="logout">Скрыть удалённые уведомления</a>');
        };

        var setCookie = function(name, value){
            var DAY = 24 * 60 * 60 * 1000;
            var date = new Date();
            date.setTime(date.getTime() + (1 * DAY)); // 1 день
            $.cookie(name, value, {expires: date});
        };

        $('body').on('click','[data-nid]', function(e){
            lock_notification($(this).attr('data-nid'));
        });

        $('body').on('click','[data-nlock]', function(e){
            e.stopPropagation()
            setCookie('lock', $(this).attr('data-nlock'));
            lock = $(this).attr('data-nlock');
            get_notification();
            show_lock();
        });

        get_notification();

        show_lock();

        setInterval(function()
        {
            //get_notification();

        }, 10000);
    };
}(jQuery));