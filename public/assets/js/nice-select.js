$(document).on('input', '.product-input', function () {
    let input = $(this);
    let val = input.val();
    let options = $('#productList option');
    let hidden = input.siblings('.product-id'); // find hidden input next to it

    let found = false;
    options.each(function () {
        if ($(this).val() === val) {
            hidden.val($(this).data('id')); // set ID
            found = true;
            return false; // break loop
        }
    });
    if (!found) {
        hidden.val(""); // reset if not matched
    }
});

