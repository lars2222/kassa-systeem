<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        const resultsContainer = document.querySelector('.results-container');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value;

            fetch(`/products/search?search=${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(html => {
                    resultsContainer.innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        });

        function openForm() {
            document.getElementById("product-info").style.display = "block";
        }

        function closeForm() {
            document.getElementById("product-info").style.display = "none";
        }

        function toggleProductInfo(button) {
            const productInfo = button.closest('.card-body').querySelector('.product-info');
            if (productInfo.style.display === "none") {
                productInfo.style.display = "block";
            } else {
                productInfo.style.display = "none";
            }
        }

        // Zet de functies in de globale scope
        window.openForm = openForm;
        window.closeForm = closeForm;
        window.toggleProductInfo = toggleProductInfo;
    });
</script>
