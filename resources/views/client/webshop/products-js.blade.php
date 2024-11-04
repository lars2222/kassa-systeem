<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count-value').textContent = data.count; 
                })
                .catch(error => console.error('Error fetching cart count:', error));
        }

        updateCartCount();
  
        const searchInput = document.querySelector('input[name="search"]');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value;

            fetch(`/products/search?search=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('.products-list').innerHTML = html; 
                    updateCartCount(); 
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>