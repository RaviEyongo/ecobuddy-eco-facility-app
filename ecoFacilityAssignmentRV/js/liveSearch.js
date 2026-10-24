class LiveSearch {
    static validateInput(query) {
        //
        const pattern = /^[a-zA-Z0-9\s]{1,30}$/; //This patterns allows letters, numbers & spaces
        return pattern.test(query); //Test if the input matches the pattern
    }


    //Send AJAX  GET request to searchFacilities.php with the query
    static fetchResults(query, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `searchFacilities.php?query=${encodeURIComponent(query)}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const jsonData = JSON.parse(xhr.responseText); //Try parsing JSON
                    callback(null, jsonData); //Success, send it to callback
                } catch (err) {
                    callback(err, null); //JSON parsing failed
                }
            } else {
                callback(new Error(`Error status: ${xhr.status}`), null); // Server error
            }
        };
        xhr.onerror = () => callback(new Error('Network error occurred'), null); // Network fail
        xhr.send();
    }

   //Show search results on the page
    static renderResults(results) {
        const resultsDiv = document.getElementById('searchResults');
        resultsDiv.innerHTML = ''; // Clear old results

        if (results.length === 0) {
            // If no results, show a "No facilities" message
            resultsDiv.innerHTML = '<div class="list-group-item">No facilities found</div>';
            return;
        }

        // Loop through the search results and create clickable links
        results.forEach((item) => {
            resultsDiv.innerHTML += `
            <a href="ecoFacilityDetails.php?id=${item.id}" 
               class="list-group-item list-group-item-action">
                ${item.facilityName}
            </a>
        `;
        });


    }
}