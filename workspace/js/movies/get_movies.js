document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/search') // Adjust the API endpoint as necessary
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('moviesContainer');
            data.forEach(movie => {
                const div = document.createElement('div');
                div.textContent = `Title: ${movie.primaryTitle}`;
                container.appendChild(div);
            });
        })
        .catch(error => console.error('Error loading the movies:', error));
});
