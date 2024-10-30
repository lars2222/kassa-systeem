<script>
    function openForm() {
        document.getElementById("product-info").style.display = "block";
    }

    function toggleProductInfo(button) {
        const productInfo = button.closest('.card-body').querySelector('.product-info');
        if (productInfo.style.display === "none") {
            productInfo.style.display = "block";
        } else {
            productInfo.style.display = "none";
        }
    }

    function closeForm() {
        document.getElementById("product-info").style.display = "none";
    }
</script>