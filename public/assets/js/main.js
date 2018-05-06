$(document).ready(function() {

  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  $('#showOptionBtn').on('click', function() {
    $('#subMenu').hide();
    $('#subMenu').css("top", "60px");
    $('#subMenu').fadeIn("slow");
    $('.mainContent').css("margin-top", "100px");
    $('#showOptionBtn').hide();
    $('#hideOptionBtn').show();
  });

  $('#hideOptionBtn').on('click', function() {
    $('#subMenu').slideUp("slow");
    $('#subMenu').css("top", "-23px");
    $('#subMenu').slideDown("fast");
    $('.mainContent').css("margin-top", "20px");
    $('#showOptionBtn').show();
    $('#hideOptionBtn').hide();
  });

  $(function() {
    $('#input-search').on('keyup', function() {
      var rex = new RegExp($(this).val(), 'i');
      $('.searchable-container .items').hide();
      $('.searchable-container .items').filter(function() {
        return rex.test($(this).text());
      }).show();
    });
  });

});
