<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    const cashInputDiv = $('.cash-input');
    const bankInputDiv = $('.bank-input');
    const pinInputDiv = $('.pin-input');

    $('#payment_method').on('change', function() {
        const paymentMethod = $(this).val();
        if (paymentMethod === 'cash') {
            cashInputDiv.show();
            bankInputDiv.hide();
        } else if (paymentMethod === 'card') {
            cashInputDiv.hide();
            bankInputDiv.show();
        } else {
            cashInputDiv.hide();
            bankInputDiv.hide();
        }
    });

    $('#bank').on('change', function() {
        if ($(this).val()) {
            pinInputDiv.show();
        } else {
            pinInputDiv.hide();
        }
    });

    $('.increase-quantity').click(function() {
        const row = $(this).closest('tr');
        const productId = row.data('product-id');
        let quantity = parseInt(row.find('.quantity').val()) + 1;
        updateCart(productId, quantity);
    });

    $('.decrease-quantity').click(function() {
        const row = $(this).closest('tr');
        const productId = row.data('product-id');
        let quantity = parseInt(row.find('.quantity').val()) - 1;
        if (quantity > 0) updateCart(productId, quantity);
    });

    $('.remove-product').click(function() {
        const row = $(this).closest('tr');
        const productId = row.data('product-id');

        $.ajax({
            url: '/cart/remove/' + productId,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function() {
                row.remove();
                updateTotal();
                updateCartCount(); 
            },
            error: function(xhr) {
                console.error("Fout bij het verwijderen van het product.", xhr);
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
                const row = $('tr[data-product-id="' + productId + '"]');
                row.find('.quantity').val(quantity);
                row.find('.subtotal').text(formatCurrency(response.price * quantity)); 
                updateTotal(response.total, response.totalDiscount); 
            },
            error: function(xhr) {
                console.error("Fout bij het bijwerken van de hoeveelheid.", xhr);
            }
        });
    }

    function updateTotal(total = 0, totalDiscount = 0) {
        $('.total').text(formatCurrency(total));

        if (totalDiscount > 0) {
            $('.discount').text(formatCurrency(totalDiscount));
            $('.final-total').text(formatCurrency(total - totalDiscount));
            $('.discount').parent().show();
            $('.final-total').parent().show();
        } else {
            $('.discount').parent().hide();
            $('.final-total').parent().hide();
        }
    }

    function updateCartCount() {
        $.get('/cart/count', function(data) {
            $('#cart-count-value').text(data.count);
        }).fail(function(xhr) {
            console.error("Fout bij het ophalen van de winkelwagentje teller.", xhr);
        });
    }

    function formatCurrency(amount) {
        return amount.toLocaleString('nl-NL', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
    }

    updateCartCount();
});
</script>
