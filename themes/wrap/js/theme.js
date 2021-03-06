$(function() {

    $.Notification();

    $('#upload').on('hide', function (b) {
        //console.log(b.target.attributes.role);
        if(b.target.attributes.role == 'dialog') console.log('ok');
        //alert(b.target.attributes.role)
        if(b.target.attributes.role) $( 'body' ).css( "overflow", "auto" );
    });

    $('#upload').on('show', function (b) {
        //console.log('show');
        if(b.target.attributes.role) $( 'body' ).css( "overflow", "hidden" );
    });

    /*$('.filter-block').click(function(){
        //$('.new-alert').slideToggle('slow');
        show_alert('success', 'Успешно что-то произошло');
    });*/

    setInterval(function()
    {
        $('.alert-error').slideUp('slow');

        $('.alert-success').slideUp('slow');

    }, 15000);

    /*$("#commentsform").submit(function() {

        var str = $(this).serialize();

        $. ajax ({
            type: 'POST',
            url: '/request',
            data: str,
            success: function(msg) {
                $('#load').load('/request/comments/'+$("#ths").val(), function() {
                    $('#scrl').animate({scrollTop: $('#scrl')[0].scrollHeight});
                })
            }
        });

        return false;
    });*/

    $("#workform").submit(function() {

        var str = $(this).serialize();

        $. ajax ({
            type: 'POST',
            url: '/projects',
            data: str,
            success: function(msg) {

                $('#load').load('/projects/work/'+$("#ths").val(), function() {
                    $('#scrl').animate({scrollTop: $('#scrl')[0].scrollHeight});
                })
            }
        });

        return false;
    });

    $(".wysihtml5").wysihtml5({
        "font-styles": false,
        "emphasis": false,
        "lists": false,
        "html": false,
        "link": false,
        "image": false
    });

    var cache = {};

    $("#hint")
        .click(function(){
            alert($(this).data("tpol"));
        })
        .autocomplete({
             source: function( request, response ) {
                 var term = request.term;
                 if ( term in cache ) {
                     response( cache[ term ] );
                     return;
                 }

                 $.getJSON( "/api/getAutocomplete/address", request, function( data, status, xhr ) {
                     cache[ term ] = data;
                     response( data );
                 });
             },
             //source: '/api/getAutocomplete/address',
             delay:10,
             cacheLength:10
        });

    $('.datepicker').live('focus', function(){
        $(this).datepicker({
            language: 'ru'
        });
    });

    var tpol = 'address';

    var tbl = 'address';

    $(".autocomp")
        .focus(function(){
            tpol = $(this).data("tpol");
            //console.log(tpol);
            tbl = $(this).data("tbl");
        })
        .autocomplete({
            source: function( request, response ) {
                var term = request.term;
                if ( term+tpol in cache ) {
                    response( cache[ term+tpol ] );
                    return;
                }

                $.getJSON( "/api/getAutocomplete/"+tbl+"/"+tpol, request, function( data, status, xhr ) {
                    cache[ term+tpol ] = data;
                    response( data );
                });
            },
            //source: '/api/getAutocomplete/address',
            delay:10,
            cacheLength:10
        });

    var i = $(".addstr").data("count");

    var q = 0;

    var trzd = 0;

    var oldrazd = $("input[name='total']").val();

    if(!rzd) var rzd = {};

    function calctrazd(arr) {

        trzd = 0;

        $.each( arr, function( key, val ) {

            trzd = Number(trzd) + Number(val);

        });

        if(!oldrazd) $("input[name='total']").val(trzd);

    }

    function calcrazd(arr) {

        $.each( arr, function( key, val ) {

            trzd = Number(trzd) + Number(val);

            $("input[name='"+key+"']").keyup(function () {

                trzd = Number(trzd) + Number($(this).val());

                arr[key] = $(this).val();

                calctrazd(arr)

                console.log(trzd);
            });
        });
    }

    calcrazd(rzd);

    $('#addstr1').click(function() {

        if(q<10) {

            $('table.addr').append(
                '<tr><td>'+i+'</td><td><textarea class="span6 wysihtml5'+i+'" rows="5" id="trasprname'+i+'" name="trasprname'+i+'" placeholder="Наименование"></textarea></td><td><input class="inline-input" type="text" id="trasprpr'+i+'" name="trasprpr'+i+'" placeholder="Стоимость работ"/></td><td><input class="inline-input" type="text" id="trasprsr'+i+'" name="trasprsr'+i+'" placeholder="Сроки исполнения"/></td></tr> '
            );

            $(".wysihtml5"+i).wysihtml5({
                "font-styles": false,
                "emphasis": false,
                "lists": false,
                "html": false,
                "link": false,
                "image": false
            });

            q++;
            i++;

        } else {

            alert('За один раз можно отправлять только 10 файлов!');
        }
    });

    $(window).scroll(function() {
        var top = $(document).scrollTop();
        if (top > 115) $('.form-actions .btn-group').addClass('fix-action');
        else $('.form-actions .btn-group').removeClass('fix-action');
    });

    $( document ).ajaxStart(function() {
        $( "#loading" ).show();
    });
  
    $( document ).ajaxComplete(function() {
        $( "#loading" ).hide();
    });
  
    $("#loading").bind("ajaxSend", function(){
        $(this).show(); // ���������� �������
    }).bind("ajaxComplete", function(){
        $(this).hide(); // �������� �������
    });

    var $window = $(window);

    // fix sub nav on scroll
    var $win = $(window)
        , $nav = $('.subnav')
        , navTop = $('.subnav').length && $('.subnav').offset().top - 40
        , isFixed = 0

    processScroll();

    // hack sad times - holdover until rewrite for 2.1
    $nav.on('click', function () {
        if (!isFixed) {
            setTimeout(function () {
                $win.scrollTop($win.scrollTop() - 47)
            }, 10)
        }
    });

    $win.on('scroll', processScroll);

    function processScroll() {
        var scrollTop = $win.scrollTop();
        if (scrollTop >= navTop && !isFixed) {
            isFixed = 1;
            $nav.addClass('subnav-fixed');
        } else if (scrollTop <= navTop && isFixed) {
            isFixed = 0;
            $nav.removeClass('subnav-fixed');
        }
    }
    // navbar notification popups
    $(".notification-dropdown").each(function (index, el) {
        var $el = $(el);
        var $dialog = $el.find(".pop-dialog");
        var $trigger = $el.find(".trigger");
    
        /*$dialog.click(function (e) {
            e.stopPropagation()
        });*/

        $dialog.find(".close-icon").click(function (e) {
            e.preventDefault();
            $dialog.removeClass("is-visible");
            $trigger.removeClass("active");
        });

        $(".content").click(function () {
            $dialog.removeClass("is-visible");
            $trigger.removeClass("active");
        });

        $trigger.click(function (e) {
            e.preventDefault();
            e.stopPropagation();
      
            // hide all other pop-dialogs
            $(".notification-dropdown .pop-dialog").removeClass("is-visible");
            $(".notification-dropdown .trigger").removeClass("active");

            $dialog.toggleClass("is-visible");
            if ($dialog.hasClass("is-visible")) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });
    });

    $("#clnt").change(function () {
        //$(this).html('test');
        $('#zsurname').val($(this).find("option:selected").data("sn"));
        $('#zname').val($(this).find("option:selected").data("n"));
        $('#zmname').val($(this).find("option:selected").data("mn"));
        $('#organization').val($(this).find("option:selected").data("org"));
        $('#phone').val($(this).find("option:selected").data("phone"));
        $('#email').val($(this).find("option:selected").data("email"));
        $('#hear').val($(this).find("option:selected").data("hear"));
    });

    $(".upl").click(function () {
        var href = $(this).attr('href');
        $('#load').html('');
        $('#load').load(href);
        $("#ths").val(this.id);
    });

    $("#edt").click(function () {
        alert('sdfasd');
        //var href = $(this).attr('href')
        //$.get(href, function(data){
        //  $('#load').html(data);
        //});
        //$('#load').html('');
        //$('#load').load(href);
        //$("#ths").val(this.id);
       	//alert(this.id)
        //$("#ps").html($(this).data("ps"));
        //$("#tp").html($(this).data("tp"));
        //$("#ep").html($(this).data("ep"));
    });

    // sidebar menu dropdown toggle
    $("#dashboard-menu").find(".dropdown-toggle").click(function (e) {
        e.preventDefault();
        var $item = $(this).parent();
        $item.toggleClass("active");
        if ($item.hasClass("active")) {
            $item.find(".submenu").slideDown("fast");
        } else {
            $item.find(".submenu").slideUp("fast");
        }
    });


    // mobile side-menu slide toggler
    var $menu = $("#sidebar-nav");
    $("body").click(function () {
        if ($menu.hasClass("display")) {
            $menu.removeClass("display");
        }
    });
    //$menu.click(function(e) {
    //  e.stopPropagation();
    //});
    $("#menu-toggler").click(function (e) {
        e.stopPropagation();
        $menu.toggleClass("display");
    });

    $('body').tooltip({
        selector: "[data-toggle=tooltip]",
        html: "true"
    });

	// build all tooltips from data-attributes
	$("[data-toggle='tooltip']").each(function (index, el) {
		$(el).tooltip({
			placement: $(this).data("placement") || 'top',
            html: "true"
		});
	});

    $("[data-toggle1='tooltip']").each(function (index, el) {
        $(el).tooltip({
            placement: $(this).data("placement") || 'top',
            html: "true"
        });
    });


  // custom uiDropdown element, example can be seen in user-list.html on the 'Filter users' button
	var uiDropdown = new function() {
  	    var self;
  	    self = this;
  	    this.hideDialog = function($el) {
    	    return $el.find(".dialog").hide().removeClass("is-visible");
  	    };
  	    this.showDialog = function($el) {
    	    return $el.find(".dialog").show().addClass("is-visible");
  	    };
		return this.initialize = function() {
  		    $("html").click(function() {
    		    $(".ui-dropdown .head").removeClass("active");
      		    return self.hideDialog($(".ui-dropdown"));
    	    });
    		$(".ui-dropdown .body").click(function(e) {
      		    return e.stopPropagation();
    		});
    		return $(".ui-dropdown").each(function(index, el) {
      		    return $(el).click(function(e) {
      			    e.stopPropagation();
      			    $(el).find(".head").toggleClass("active");
      			    if ($(el).find(".head").hasClass("active")) {
        			    return self.showDialog($(el));
      			    } else {
        			    return self.hideDialog($(el));
      			    }
      		    });
    		});
    	};
  	};

    // instantiate new uiDropdown from above to build the plugins
  	new uiDropdown();


  	// toggle all checkboxes from a table when header checkbox is clicked
  	$(".table th input:checkbox").click(function () {
  		var $checks = $(this).closest(".table").find("tbody input:checkbox");
  		if ($(this).is(":checked")) {
  			$checks.prop("checked", true);
  		} else {
  			$checks.prop("checked", false);
  		}  		
  	});


});