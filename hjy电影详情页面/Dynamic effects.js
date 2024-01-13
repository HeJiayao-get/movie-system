document.addEventListener("DOMContentLoaded", function() {
    loadHTML('../PageElements/star-rating.html', function(data) {
        var container = document.getElementById('star-rating-container');
        container.innerHTML = data;

        var scriptTags = container.getElementsByTagName("script");
        for (var i = 0; i < scriptTags.length; i++) {
            eval(scriptTags[i].innerText);
        }
    });

    loadHTML('../PageElements/footer.html', function(data) {
        document.getElementById('footer-container').innerHTML = data;
    });
});

function loadHTML(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                callback(xhr.responseText);
            } else {
                console.error('Failed to load content. Status:', xhr.status);
            }
        }
    };
    xhr.open('GET', url, true);
    xhr.send();
}
