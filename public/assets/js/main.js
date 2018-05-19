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
  var $subCategoriyContainer = $('div#category_subCategories');
  var index = $subCategoriyContainer.find(':input').length;

      $('#add_subcategory').click(function(e) {
        addSubCategory($subCategoriyContainer);
        e.preventDefault();
        return false;
      });
      $subCategoriyContainer.children('div').each(function() {
        addDeleteLink($(this));
      });

      function addSubCategory($subCategoriyContainer) {
        var $subCategoriyTemplate = $subCategoriyContainer.attr('data-prototype')
          .replace(/__name__label__/g, 'SubCatégory n°' + (index+1))
          .replace(/__name__/g,        index)
        ;

        var $subCategoriyPrototype = $($subCategoriyTemplate);
        addDeleteLink($subCategoriyPrototype);
        $subCategoriyContainer.append($subCategoriyPrototype);
        index++;
      }

      function addDeleteLink($subCategoriyPrototype) {
        var $deleteLink = $('<a href="#" class="delete-btn-sublist btn btn-danger btn-sm p-1 mt-0 float-right">Delete</a><hr>');
        $subCategoriyPrototype.append($deleteLink);
        $deleteLink.click(function(e) {
          $subCategoriyPrototype.remove();
          e.preventDefault();
          return false;
        });
      }

});
