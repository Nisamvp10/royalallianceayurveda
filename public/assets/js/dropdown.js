
// Toggle dropdown
$("#dropdownButton").click(function () {
  $("#dropdownMenu").toggleClass("hidden");
  $("#dropdownSearch").val("").trigger("input").focus();
});

// Filter search
$("#dropdownSearch").on("input", function () {
  let val = $(this).val().toLowerCase();
  $("#dropdownOptions li").each(function () {
    $(this).toggle($(this).text().toLowerCase().includes(val));
  });
});

// Select option
$(document).on("click", "#dropdownOptions li", function () {
  let value = $(this).data("value");
  let text = $(this).text();

  $("#selectedText").text(text).data("value", value);
  $("#category_id").val(value); // store value for form submit
  $("#dropdownMenu").addClass("hidden");
});

// Close if clicked outside
$(document).click(function (e) {
  if (!$(e.target).closest("#categoryWrapper").length) {
    $("#dropdownMenu").addClass("hidden");
  }
});

getCategories();

function getCategories() {
  $.ajax({
    method: 'POST',
    url: App.cust() + 'categories',
    dataType: "json",
    success: function (response) {
      // Clear old options
      $("#dropdownOptions").empty();

      if (response.result.length > 0) {
        $.each(response.result, function (i, category) {
          $("#dropdownOptions").append(
            `<li data-value="${category.id}" 
                                class="px-4 py-2 cursor-pointer hover:bg-blue-100">
                                ${category.category}
                            </li>`
          );
        });
      } else {
        $("#dropdownOptions").append(
          `<li class="px-4 py-2 text-gray-500">No categories found</li>`
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("Error loading categories:", error);
    }
  });
}




