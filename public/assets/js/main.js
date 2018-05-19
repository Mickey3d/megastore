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


  /*****************************************************************************
  *               SubCategories Adder
  *****************************************************************************/
  var $container = $('div#category_subCategories');

      var index = $container.find(':input').length;

      $('#add_subcategory').click(function(e) {
        addSubCategory($container);

        e.preventDefault();
        return false;
      });

      if (index == 0) {
        addSubCategory($container);
      } else {
        $container.children('div').each(function() {
          addDeleteLink($(this));
        });
      }

      function addSubCategory($container) {
        var template = $container.attr('data-prototype')
          .replace(/__name__label__/g, 'SubCatégory n°' + (index+1))
          .replace(/__name__/g,        index)
        ;

        var $prototype = $(template);
        addDeleteLink($prototype);
        $container.append($prototype);
        index++;
      }

      function addDeleteLink($prototype) {
        var $deleteLink = $('<a href="#" class="btn btn-danger">Delete</a>');
        $prototype.append($deleteLink);
        $deleteLink.click(function(e) {
          $prototype.remove();
          e.preventDefault();
          return false;
        });
      }

});
