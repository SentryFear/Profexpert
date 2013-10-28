$(function () {

    $.getJSON( "/api/getNotification", function( data ) {
        var items = [];
        $.each( data, function( key, val ) {
            items.push( "<a href='" + val.uri + "' class='item'><i class='icon-signin'></i> " + val.name + " <span class='time'><i class='icon-time'></i> " + val.time + "</span></a>" );
        });

        $('.count').html(items.length);

        $('.count1').html(items.length);

        $( items.join( "" ) ).appendTo( ".notifications" );
    });

    $(".wysihtml5").wysihtml5({
        "font-styles": false,
        "emphasis": false,
        "lists": false,
        "html": false,
        "link": false,
        "image": false
    });

    var i = $(".addstr").data("count");

    var q = 0;

    $('#addstr1').click(function(e) {

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
        };


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
  
  var $window = $(window)
  
  // fix sub nav on scroll
  var $win = $(window)
    , $nav = $('.subnav')
    , navTop = $('.subnav').length && $('.subnav').offset().top - 40
    , isFixed = 0

  processScroll()

  // hack sad times - holdover until rewrite for 2.1
  $nav.on('click', function () {
    if (!isFixed) setTimeout(function () {  $win.scrollTop($win.scrollTop() - 47) }, 10)
  })

  $win.on('scroll', processScroll)

  function processScroll() {
    var i, scrollTop = $win.scrollTop()
    if (scrollTop >= navTop && !isFixed) {
      isFixed = 1
      $nav.addClass('subnav-fixed')
    } else if (scrollTop <= navTop && isFixed) {
      isFixed = 0
      $nav.removeClass('subnav-fixed')
    }
  }
  // navbar notification popups
  $(".notification-dropdown").each(function (index, el) {
    var $el = $(el);
    var $dialog = $el.find(".pop-dialog");
    var $trigger = $el.find(".trigger");
    
    $dialog.click(function (e) {
        e.stopPropagation()
    });
    $dialog.find(".close-icon").click(function (e) {
      e.preventDefault();
      $dialog.removeClass("is-visible");
      $trigger.removeClass("active");
    });
    $("body").click(function () {
      $dialog.removeClass("is-visible");
      $trigger.removeClass("active");
    });

    $trigger.click(function (e) {
      e.preventDefault();
      e.stopPropagation();
      
      // hide all other pop-dialogs
      $(".notification-dropdown .pop-dialog").removeClass("is-visible");
      $(".notification-dropdown .trigger").removeClass("active")

      $dialog.toggleClass("is-visible");
      if ($dialog.hasClass("is-visible")) {
        $(this).addClass("active");
      } else {
        $(this).removeClass("active");
      }
    });
  });

  $(".upl").click(function () {
    var href = $(this).attr('href')
    //$.get(href, function(data){
    //  $('#load').html(data);
    //});
    $('#load').html('');
    $('#load').load(href);
    $("#ths").val(this.id);
   	//alert(this.id)
    //$("#ps").html($(this).data("ps"));
    //$("#tp").html($(this).data("tp"));
    //$("#ep").html($(this).data("ep"));
  });
  
  $("#edt").click(function () {
    alert('sdfasd')
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

  // skin changer
  $(".skins-nav .skin").click(function (e) {
    e.preventDefault();
    if ($(this).hasClass("selected")) {
      return;
    }
    $(".skins-nav .skin").removeClass("selected");
    $(this).addClass("selected");
    
    if (!$("#skin-file").length) {
      $("head").append('<link rel="stylesheet" type="text/css" id="skin-file" href="">');
    }
    var $skin = $("#skin-file");
    if ($(this).attr("data-file")) {
      $skin.attr("href", $(this).data("file"));
    } else {
      $skin.attr("href", "");
    }

  });


  // sidebar menu dropdown toggle
  $("#dashboard-menu .dropdown-toggle").click(function (e) {
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
    selector: "[data-toggle=tooltip]"
  })

	// build all tooltips from data-attributes
	$("[data-toggle='tooltip']").each(function (index, el) {
		$(el).tooltip({
			placement: $(this).data("placement") || 'top'
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
  		$checks = $(this).closest(".table").find("tbody input:checkbox");
  		if ($(this).is(":checked")) {
  			$checks.prop("checked", true);
  		} else {
  			$checks.prop("checked", false);
  		}  		
  	});


});