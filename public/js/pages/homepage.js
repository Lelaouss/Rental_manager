$(document).ready(function () {

    // LIEN SUR LES ITEMS DE LA HOME
    $('.home-item').on('click', function () {
        window.location = $(this).data('home-item-path');
    });

});