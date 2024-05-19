function loadMoreMovies() {
    // Fetch more movie data and append it to the movies-list div at the end 
    let parentContainer = $('#movies-container');
    let container = $('#movies-content-list');
    let page = container.data('page') + 1;
    let type = container.data('type');
    parentContainer.find('#movies-pagination').hide();
    if (parentContainer.find('.loading-btn').length === 0) {
        parentContainer.append(`<div class="d-flex justify-content-center align-items-center loading-btn">
        <button class="btn btn-primary" type="button" disabled="">
                <span class="spinner-border spinner-border-sm " aria-hidden="true"></span>
                <span role="status">Loading...</span>
              </button>
        </div>`); // loader element
    }
    $.ajax({
        url: `api/load_more?page=${page}&limit=10&type=${type}`,
        type: 'GET',
        success: function (data) {
            // Append new content
            container.append(data);
            container.data('page', page); // Update the data-page attribute
        },
        error: function (xhr, status, error) {
            console.error("Error loading more content: " + error);
        },
        complete: function () {
            // Remove loaders after search is complete
            $('.loading-btn').remove();
            parentContainer.find('#movies-pagination').show();
        }
    });
}

function loadMoreEpisodes() {
    // Fetch more TV episodes data and append it to the episodes-list div
    let parentContainer = $('#episodes-container');
    let container = $('#episodes-content-list');
    let page = container.data('page') + 1;
    let type = container.data('type');
    parentContainer.find('#episodes-pagination').hide();
    if (parentContainer.find('.loading-btn').length === 0) {
        parentContainer.append(`<div class="d-flex justify-content-center align-items-center loading-btn">
        <button class="btn btn-primary" type="button" disabled="">
                <span class="spinner-border spinner-border-sm " aria-hidden="true"></span>
                <span role="status">Loading...</span>
              </button>
        </div>`); // loader element
    }
    $.ajax({
        url: `api/load_more?page=${page}&limit=10&type=${type}`,
        type: 'GET',
        success: function (data) {
            // Append new content
            container.append(data);
            container.data('page', page); // Update the data-page attribute
        },
        error: function (xhr, status, error) {
            console.error("Error loading more content: " + error);
        },
        complete: function () {
            // Remove loaders after search is complete
            $('.loading-btn').remove();
            parentContainer.find('#episodes-pagination').show();
        }
    });
}

function loadMoreCast() {
    // Fetch more cast data and append it to the cast-list div
}

// Example for handling search clearing and showing hidden content
function clearSearchAndShowAll() {
    document.querySelectorAll('.content-container').forEach(container => {
        container.style.display = 'block';
    });
    // Clear search input or reset search state
}
