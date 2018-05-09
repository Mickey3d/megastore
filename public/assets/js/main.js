$(document).ready(function() {

  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  var topValueMax = $('#subMenu').css('height');
  var barSubMenuheight = $('#barSubMenu').css('height');
  var subMenuHeaderHeight = $('#subMenuHeader').css('height');
  var topValueMin = $('#subMenu').css('height');
  console.log(topValueMax);
  console.log(barSubMenuheight);
  console.log(subMenuHeaderHeight);


  $('.mainContent').css("margin-top", topValueMax);

  $('#showOptionBtn').on('click', function() {
    $('#subMenuHeader').slideDown("slow");
    $('.mainContent').css("margin-top", topValueMax);
    $('#showOptionBtn').hide();
    $('#hideOptionBtn').show();
  });

  $('#hideOptionBtn').on('click', function() {
    $('#subMenuHeader').slideUp("slow");
    $('.mainContent').css("margin-top", barSubMenuheight);
    $('#showOptionBtn').show();
    $('#hideOptionBtn').hide();
  });

  $(function() {
    $('.input-search').on('keyup', function() {
      var rex = new RegExp($(this).val(), 'i');
      $('.searchable-container .items').hide();
      $('.searchable-container .items').filter(function() {
        return rex.test($(this).text());
      }).show();
    });
  });

});
