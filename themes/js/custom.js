jQuery.noConflict();
!function ($) {

  $(function(){
    
    $("#loading").bind("ajaxSend", function(){
	$(this).show(); // показываем элемент
    }).bind("ajaxComplete", function(){
	$(this).hide(); // скрываем элемент
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
    
    setTimeout(function () {
      $('.bs-docs-sidenav').affix({
        offset: {
          top: function () { return $window.width() <= 980 ? 290 : 210 }
        , bottom: 270
        }
      })
    }, 100)
    
    // tooltip demo
    $('body').tooltip({
      selector: "[data-toggle=tooltip]"
    })
    
    $(".upl").click(function () {
      var href = $(this).attr('href')
      $.get(href, function(data){
	$('#load').html(data);
      });
      $('#load').load(href);
      $("#ths").val(this.id);
     	//alert(this.id)
      //$("#ps").html($(this).data("ps"));
      //$("#tp").html($(this).data("tp"));
      //$("#ep").html($(this).data("ep"));
    });
  })

}(window.jQuery)