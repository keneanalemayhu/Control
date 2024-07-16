$(document).ready(function () {
  // Increment button
  $(".increment-btn").click(function (e) {
    e.preventDefault();

    var qty = $(this).closest(".product_data").find(".input-qty").val();
    var value = parseInt(qty, 10);
    value = isNaN(value) ? 0 : value;
    if (value < 10) {
      value++;
      $(this).closest(".product_data").find(".input-qty").val(value);
    }
  });

  // Decrement button
  $(".decrement-btn").click(function (e) {
    e.preventDefault();

    var qty = $(this).closest(".product_data").find(".input-qty").val();
    var value = parseInt(qty, 10);
    value = isNaN(value) ? 0 : value;
    if (value > 1) {
      value--;
      $(this).closest(".product_data").find(".input-qty").val(value);
    }
  });
  $(".addToCartBtn").click(function (e) {
    e.preventDefault();
    var qty = $(this).closest(".product_data").find(".input-qty").val();
    var prod_id = $(this).val();

    $.ajax({
        method: "POST",
        url: "functions/handlecart.php",
        data: {
            "prod_id": prod_id,
            "prod_qty": qty,
            "scope": "add"
        },
        success: function (response) {
            if (response.trim() === "201") {
                alertify.success("Product added to cart!");
            } else if (response.trim() === "existing") {
                alertify.error("Product already in cart!");
            } else if (response.trim() === "401") {
                alertify.error("Login to Continue");
            } else if (response.trim() === "500") {
                alertify.error("Something went wrong!");
            } else {
                // Default error message for unexpected responses
                alertify.error(response.trim());
            }
        }
    });
});
});
