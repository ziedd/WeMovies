document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('#search');
    const errorField = document.querySelector('#error-field');
    function generateMovieHtml(movie, index) {
        const isFirst = index === 0;
        if (index === 0) {
            console.log('first movie', movie);
        }
        const stars = [];
        for (let i = 0; i < movie.numberOfStars; i++) {
            stars.push('<span class="text-yellow-500">&#9733;</span>');
        }
        for (let i = movie.numberOfStars; i < 5; i++) {
            stars.push('<span class="text-yellow-500">&#9734;</span>');
        }

        return `
        <li class="bg-white rounded-md overflow-hidden shadow-md" data-id="${movie.id}">
            <img src="${movie.imageUrl}" alt="${movie.title}" class="w-full h-48 object-cover">
            <div class="p-4">
                <div class="flex items-center mb-2">
                    <h2 class="text-lg font-semibold mr-2">${movie.title}</h2>
                    <div class="flex items-center">${stars.join('')}</div>
                    <span class="ml-2 text-gray-500">(${movie.voteCount} votes)</span>
                </div>

                <div class="text-gray-500 mb-2">
                    <span class="mr-2">${movie.releasedYear}</span>
                    ${movie.productionCompanyName !== null ? `<span class="movie-company">${movie.productionCompanyName}</span>` : ''}
                </div>

                <p class="text-gray-600">${movie.description}</p>
            </div>
        </li>
    `;
    }

    function updateVideoHtml(movies) {
        const firstMovie = movies[0];

        if (firstMovie && firstMovie.videoUrl) {
            const embedUrl = `https://www.youtube.com/embed/${firstMovie.videoUrl}`;
            const videosContainer = document.querySelector('#videos-container');

            console.log('Updating video HTML:', embedUrl);
            console.log('Container:', videosContainer);

            videosContainer.innerHTML = `
            <div class="relative aspect-w-16 aspect-h-9 mb-4">
                <iframe src="${embedUrl}" frameborder="0" allowfullscreen class="absolute inset-0 w-full h-full"></iframe>
            </div>
        `;
        }
    }


    let debounceTimeout;

    searchInput.addEventListener('input', function (e) {
        const searchValue = e.target.value;

        if (searchValue.length < 3) {
            errorField.textContent = 'La recherche doit contenir au moins 3 caractères';
            return;
        }

        // Use debounce to avoid calling the API on every key stroke
        clearTimeout(debounceTimeout);
        // Set a new timeout to 500 milliseconds
        const debounceDelay = 500;

        debounceTimeout = setTimeout(function () {
            errorField.textContent = '';

            fetch('/api/movies/search?search=' + searchValue)
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    const movies = data.items;
                    document.querySelector('#movies-grid').innerHTML = movies.map((movie, index) => generateMovieHtml(movie, index)).join('');
                    updateVideoHtml(movies);
                });
        }, debounceDelay);
    });

    const categoryForm = document.querySelector('#category-form');
    categoryForm.addEventListener('change', function () {
        // Handle category changes and perform AJAX call
        const selectedCategories = Array.from(categoryForm.querySelectorAll('input[type="checkbox"]:checked')).map(checkbox => checkbox.value);
        performSearch(searchInput.value, selectedCategories);
    });

    function performSearch(searchValue, selectedCategories = []) {
        const apiUrl = '/api/movies/search';

        // Include selected categories in the API request if any
        const queryParams = selectedCategories.length > 0
            ? `?search=${searchValue}&genreIds=${selectedCategories.join(',')}`
            : `?search=${searchValue}`;

        fetch(apiUrl + queryParams)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                const movies = data.items;
                console.log("movies", movies);
                document.querySelector('#movies-grid').innerHTML = movies.map((movie, index) => generateMovieHtml(movie, index)).join('');
                updateVideoHtml(movies);
            });
    }
});