<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.increase-quantity').click(function() {
            let row = $(this).closest('tr');
            let productId = row.data('product-id');
            let quantityInput = row.find('.quantity');
            let currentQuantity = parseInt(quantityInput.val()) + 1;

            updateCart(productId, currentQuantity);
        });

        $('.decrease-quantity').click(function() {
            let row = $(this).closest('tr');
            let productId = row.data('product-id');
            let quantityInput = row.find('.quantity');
            let currentQuantity = parseInt(quantityInput.val());

            if (currentQuantity > 1) {
                currentQuantity -= 1;
                updateCart(productId, currentQuantity);
            }
        });

        $('.remove-product').click(function() {
            let row = $(this).closest('tr');
            let productId = row.data('product-id');

            $.ajax({
                url: '/cart/remove/' + productId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    row.remove();
                    // Update the total
                    updateTotal();
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        });

        function updateCart(productId, quantity) {
            $.ajax({
                url: '/cart/update/' + productId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity,
                },
                success: function(response) {
                    let row = $('tr[data-product-id="' + productId + '"]');
                    row.find('.quantity').val(quantity);
                    row.find('.subtotal').text(numberWithCommas((response.price * quantity).toFixed(2)) + ' €');
                    updateTotal();
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }

        function updateTotal() {
            let total = 0;
            $('.subtotal').each(function() {
                total += parseFloat($(this).text().replace(' €', '').replace(',', '.'));
            });
            $('.total').text(numberWithCommas(total.toFixed(2)) + ' €');
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").replace('.', ',');
        }
    });
</script>
