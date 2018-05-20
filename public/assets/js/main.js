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
  var $subCategoryContainer = $('div#category_subCategories');
  var indexSubCategory = $subCategoryContainer.find(':input').length;

  $('#add_subcategory').click(function(e) {
    addSubCategory($subCategoryContainer);
    e.preventDefault();
    return false;
  });
  $subCategoryContainer.children('div').each(function() {
    addDeleteSubCategoryLink($(this));
  });

  function addSubCategory($subCategoryContainer) {
    var $subCategoryTemplate = $subCategoryContainer.attr('data-prototype')
      .replace(/__name__label__/g, 'SubCatégory n°' + (indexSubCategory + 1))
      .replace(/__name__/g, indexSubCategory);

    var $subCategoryPrototype = $($subCategoryTemplate);
    addDeleteSubCategoryLink($subCategoryPrototype);
    $subCategoryContainer.append($subCategoryPrototype);
    indexSubCategory++;
  }

  function addDeleteSubCategoryLink($subCategoryPrototype) {
    var $deleteSubCategoryLink = $('<a href="#" class="delete-btn-sublist btn btn-danger btn-sm p-1 mt-0 float-right">Delete</a><hr>');
    $subCategoryPrototype.append($deleteSubCategoryLink);
    $deleteSubCategoryLink.click(function(e) {
      $subCategoryPrototype.remove();
      e.preventDefault();
      return false;
    });
  }



  /*****************************************************************************
   *               SubCItems Adder
   *****************************************************************************/
  var $subItemContainer = $('div#item_subItems');
  var indexSubItem = $subItemContainer.find(':input').length;

  $('#add_subitem').click(function(e) {
    addSubItem($subItemContainer);
    e.preventDefault();
    return false;
  });
  $subItemContainer.children('div').each(function() {
    addDeleteSubItemLink($(this));
  });

  function addSubItem($subItemContainer) {
    var $subItemTemplate = $subItemContainer.attr('data-prototype')
      .replace(/__name__label__/g, 'Sub Item n°' + (indexSubItem + 1))
      .replace(/__name__/g, indexSubItem);

    var $subItemPrototype = $($subItemTemplate);
    addDeleteSubItemLink($subItemPrototype);
    $subItemContainer.append($subItemPrototype);
    indexSubItem++;
  }

  function addDeleteSubItemLink($subItemPrototype) {
    var $deleteSubItemLink = $('<a href="#" class="delete-btn-sublist btn btn-danger btn-sm p-1 mt-0 float-right">Delete</a><hr>');
    $subItemPrototype.append($deleteSubItemLink);
    $deleteSubItemLink.click(function(e) {
      $subItemPrototype.remove();
      e.preventDefault();
      return false;
    });
  }



});
