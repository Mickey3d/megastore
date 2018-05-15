$(document).ready(function() {

  $('#item_category').change(function() {
    var categorySelector = $(this);

    // Request the SubCategories of the selected category.
    $.ajax({
      url: subCategoriesLisFromCategorytUrl,
      type: "GET",
      dataType: "JSON",
      data: {
        categoryid: categorySelector.val()
      },
      success: function(subCategories) {
        var subCategorySelect = $("#item_subCategory");

        // Remove current options
        subCategorySelect.html('');

        // Empty value ...
        subCategorySelect.append('<option value> Select a Sub Category of ' + categorySelector.find("option:selected").text() + ' ...</option>');

        $.each(subCategories, function(key, subCategory) {
          subCategorySelect.append('<option value="' + subCategory.id + '">' + subCategory.name + '</option>');
        });
      },
      error: function(err) {
        alert("An error ocurred while loading data ...");
      }
    });
  });

});
