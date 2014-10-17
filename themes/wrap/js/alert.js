$(document).ready(function(){

    $('.new-alert').click(function() {

        Alert.hide_alert();
    });

});

var Alert = {

    data : {
        
        timeout		: ''
    },

    show_alert : function(type, text) {

        if(Alert.data.timeout != '') Alert.hide_alert();

        $('.'+type+'-alert').slideDown('slow');

        $('.'+type+'-text').html(text);

        Alert.data.timeout = setTimeout(Alert.hide_alert, 3000);

        console.log('show' + Alert.data.timeout);
    },

    hide_alert : function() {

        $('.new-alert').slideUp('slow');

        clearTimeout(Alert.data.timeout);

        console.log('hide' + Alert.data.timeout);
    }
};
