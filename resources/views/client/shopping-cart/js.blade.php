<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Toggle cash input field based on selected payment method
        const cashInputDiv = $('.cash-input');
        $('#payment_method').on('change', function() {
            $(this).val() === 'cash' ? cashInputDiv.show() : cashInputDiv.hide();
        });

        // Increase quantity and update cart
        $('.increase-quantity').click(function() {
            let row = $(this).closest('tr');
            let productId = row.data('product-id');
            let quantity = parseInt(row.find('.quantity').val()) + 1;
            updateCart(productId, quantity);
        });

        // Decrease quantity (ensure quantity remains above 1)
        $('.decrease-quantity').click(function() {
            let row = $(this).closest('tr');
            let productId = row.data('product-id');
            let quantity = parseInt(row.find('.quantity').val()) - 1;
            if (quantity > 0) updateCart(productId, quantity);
        });

        // Remove product from cart
        $('.remove-product').click(function() {
            let row = $(this).closest('tr');
            let productId = row.data('product-id');
            
            $.ajax({
                url: '/cart/remove/' + productId,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function() {
                    row.remove();
                    updateTotal();
                },
                error: function(xhr) {
                    alert("Er is een fout opgetreden bij het verwijderen van het product.");
                    console.error(xhr);
                }
            });
        });

        // Function to update cart with new quantity
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
                    row.find('.subtotal').text(formatCurrency(response.price * quantity));
                    updateTotal();
                },
                error: function(xhr) {
                    alert("Er is een fout opgetreden bij het bijwerken van de hoeveelheid.");
                    console.error(xhr);
                }
            });
        }

        // Calculate and display updated cart total
        function updateTotal() {
            let total = 0;
            $('.subtotal').each(function() {
                total += parseFloat($(this).text().replace(' €', '').replace(',', '.'));
            });
            $('.total').text(formatCurrency(total));
        }

        // Format number as currency (with comma separator and Euro symbol)
        function formatCurrency(amount) {
            return amount.toLocaleString('nl-NL', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
        }
    });
</script>
