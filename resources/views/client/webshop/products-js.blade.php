<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');

        console.log(html);

        searchInput.addEventListener('input', function() {
            const query = searchInput.value;

            fetch(`/products/search?search=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(html => {
                    document.querySelector('.products-list').innerHTML = html; 
                })
                .catch(error => console.error('Error:', error));
        });

        window.loadProducts = function(categoryId) {
            fetch(`/category/show/${categoryId}`)
                .then(response => response.text())
                .then(html => {

                    document.querySelector('.products-list').innerHTML = html; 
                })
                .catch(error => console.error('Error:', error));
        };

        window.toggleProductInfo = function(button) {
            const productInfo = button.closest('.card-body').querySelector('.product-info');
            productInfo.style.display = productInfo.style.display === "none" ? "block" : "none";
        };
    });
</script>
