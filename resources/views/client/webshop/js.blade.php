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
    });
</script>