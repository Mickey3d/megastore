$(document).ready(function() {

  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  var topValueMax = $('#subMenu').css('height');
  var subMenuHeaderHeight = $('#subMenuHeader').css('height');
  var topValueMin = $('#barSubMenu').css('height');
  $('.mainContent').css("margin-top", topValueMax);
  $('#subMenuHeader').slideUp("slow");
  $('.mainContent').css("margin-top", topValueMin);

  $('#showOptionBtn').on('click', function() {
    $('#subMenuHeader').slideDown("slow");
    $('.mainContent').css("margin-top", topValueMax);
    $('#showOptionBtn').hide();
    $('#hideOptionBtn').show();
  });

  $('#hideOptionBtn').on('click', function() {
    $('#subMenuHeader').slideUp("slow");
    $('.mainContent').css("margin-top", topValueMin);
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
