// Actions appelées au chargement de la page
$(document).ready(function () {

    // Boutons de changement entre connexion et inscription
    $('#action-go-register').on('click', function () {
        registerClick();
    });

    $('#action-go-connection').on('click', function () {
        connectionClick();
    });

});


function registerClick() {
    $('#go-register').fadeOut();
    $('#block-connection').fadeOut();

    $('#absolute-container-forms').animate({
        left: "+=520px"
    }, 1000, function () {
        $('#absolute-container-buttons').css('right', '+=520px');
        $('#block-register').fadeIn();
        $('#go-connection').fadeIn();
    });
}

function connectionClick() {
    $('#go-connection').fadeOut();
    $('#block-register').fadeOut();

    $('#absolute-container-forms').animate({
        left: "-=520px"
    }, 1000, function () {
        $('#absolute-container-buttons').css('right', '-=520px');
        $('#block-connection').fadeIn();
        $('#go-register').fadeIn();
    });
}