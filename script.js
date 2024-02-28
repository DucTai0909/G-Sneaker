// JavaScript code to handle adding product to cart
function addToCart(productId) {
    // Perform Ajax request to add product to cart
    // Example:
    $.ajax({
        url: 'addToCart.php',
        method: 'POST',
        data: {productId: productId},
        success: function(response) {
            // Update UI to show check mark icon instead of Add To Cart button
            $('#product_' + productId + ' .App_shopItemButton_23FO1 button').text('✓');
            $('#product_' + productId + ' .App_shopItemButton_23FO1 button').prop('disabled', true);
        }
    });
}
