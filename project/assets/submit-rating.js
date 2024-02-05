document.addEventListener('DOMContentLoaded', function () {
    let selectedRating = 0;
    document.querySelectorAll('.star').forEach(function (star) {
        star.addEventListener('click', function () {
            selectedRating = parseInt(star.getAttribute('data-rating'));
            updateStarRating();
        });
    });

    function updateStarRating() {
        document.querySelectorAll('.star').forEach(function (star) {
            const rating = parseInt(star.getAttribute('data-rating'));
            star.classList.toggle('active', rating <= selectedRating);
        });
    }

    function handleModalClick(event) {
        const target = event.target;

        if (target && target.id === 'submit-rating') {
            if (selectedRating === 0) {
                console.error('Veuillez sélectionner une note avant de soumettre.');
                return;
            }

            const movieId = document.querySelector('#movie-modal').getAttribute('data-movie-id');

            submitRating(movieId, selectedRating);
        }
    }

    document.querySelector('#movie-modal').addEventListener('click', handleModalClick);

    function submitRating(movieId, selectedRating) {
        const updateRatingUrl = `/api/movies/${movieId}/rating`;

        console.log('movie to rate :' + movieId)
        const requestBody = {
            rating: selectedRating,
        };

        fetch(updateRatingUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestBody),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Échec de la requête PUT');
                }
                return response.json();
            })
            .then(data => {
                console.log('Réponse de la requête PUT:', data);
            })
            .catch(error => {
                console.error('Erreur lors de la requête PUT:', error);
            })
    }
});
