document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('.search-container input[type="text"]');
    const searchCategory = document.querySelector('.search-container .dropdown-toggle');

    document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
        item.addEventListener('click', function () {
            searchCategory.textContent = this.textContent;
            searchCategory.value = this.textContent;
        });
    });

    searchInput.addEventListener('input', function () {
        const category = searchCategory.textContent.trim();
        const query = this.value.trim();

        // Placeholder for API call
        console.log(`Search for ${query} in category ${category}`);
        // Implement API call here
    });
});
