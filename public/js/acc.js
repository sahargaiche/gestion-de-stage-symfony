$(document).ready(function() {
    $('.btn-download').click(function(event) {
        event.preventDefault();

        var url = $(this).attr('href');

        window.open(url, '_blank');

        setTimeout(function() {
            window.location.href = 'http://127.0.0.1:8000/'; // Redirect to index page
        }, 5000); // 60000 milliseconds = 1 minute
    });
});
