$(document).ready(function () {
    let searchTimeout;

    $('#search-input').on('input', function () {
        const searchTerm = $(this).val();
        const searchType = $('.dropdown-toggle').text().trim().toLowerCase();
        console.log(searchTerm, searchType);
        // Min length of search term
        if (searchTerm.length >= 3) {
            // Showing load animation and hide=ing current content
            $('.main-container').each(function () {
                $(this).find(`#${searchType}-content-list`).hide(); // .content-list for its contents
                if ($(`#temp-${searchType}-list`).find('.spinner-border').length === 0) {
                    $(`#temp-${searchType}-list`).append(`<div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>`); // loader element
                }
            });

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                performSearch(searchTerm, searchType);
            }, 500); // Waiting for 500 ms before calling the API to reduce requests
        } else if (searchTerm.length === 0) {
            // If search is cleared, restore original content
            $('.main-container').each(function () {
                $(this).find('.spinner-border').remove();
                $(this).find(`#temp-${searchType}-list`).html('');
                $(this).find(`#${searchType}-content-list`).show();
                $(this).find('no-results').remove();
            });
        }
    });

    function performSearch(term, type) {
        $.ajax({
            url: 'api/search',
            type: 'GET',
            data: {
                query: term,
                type: type
            },
            success: function (data) {
                // =data is the HTML content from server through loadTemplate

                if (type === 'all') {
                    // If type is all, distribute content based on data-attribute
                    $('#movies-container, #episodes-container, #casts-container').each(function () {
                        const contentType = $(this).data('attribute');
                        const content = $(data).filter(`[data-attribute="${contentType}"]`).html();
                        $(this).html(content);
                    });
                } else {
                    // Target specific container based on type
                    const container = $(`#temp-${type}-list`);
                    if (data.trim().length === 0) {
                        container.html('<div class="no-results">No results found!</div>');
                    } else {
                        container.html(data);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("Error during search: " + error);
            },
            complete: function () {
                // Remove loaders after search is complete
                $('.spinner-border').remove();
            }
        });
    }
});
