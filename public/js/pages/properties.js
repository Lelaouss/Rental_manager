$(document).ready(function () {

    // Recherche d'une ville
    $('body').on('keyup', '.city-search', function () {
        $(".city-select").html("");
        $('.city-select').attr('disabled', true);
        if ($(this).val().length >= 2) {
            const url = $(this).data('search-path');
            searchCityByZipCode($(this).val(), url);
        }
    });

    // Sélection d'une ville
    $('body').on('change', '.city-select', function () {
        $('.city-search').val($(this).find(':selected').data('zip-code'));
    });
    $('body').on('click', '.city-select', function () {
        if ($('.city-select option').length === 1) {
            $('.city-search').val($(this).find(':selected').data('zip-code'));
        }
    });


    // Création d'un local
    $('body').on('submit','#properties-add-form',function (event) {
        event.preventDefault();

        const form = $(this);
        const url = form.attr('action');

        $.ajax({
            method: 'POST',
            url: url,
            data: form.serializeArray(),
            success: function (data) {
                // Si OK on cache la modale et on reconstruit le tableau des locaux
                if (data.result === 1) {
                    buildPropertiesTable(data.data.properties);
                    $('#properties-add-modal').modal('hide');

                }
                // Sinon on affiche les erreurs dans le form
                if (data.result !== undefined) {
                    $('#properties-add-modal-content').empty();
                    $('#properties-add-modal-content').append(data.data.html.content);
                    if ($('.city-search').val().length >= 2) {
                        searchCityByZipCode($('.city-search').val(), '/city/search');
                    }

                    showToast(data.message.body, data.message.title, data.result, {timeOut: 2500});
                }
            }
        });
    });

    // Édition d'un local
    $('body').on('click', '.properties-action-edit', function () {

        const propertyId = $(this).closest('tr').data('property-id');
        const data = {
            id_property: propertyId
        };
        const url = '/properties/edit/' + propertyId;

        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            success: function (data) {
                $('#properties-edit-modal-content').empty();
                $('#properties-edit-modal-content').append(data.data.html.content);

                let html = '<option value="'+ data.data.city.idCity + '" data-zip-code="'+ data.data.city.zipCode +'">'+ data.data.city.name +'</option>';
                $('.city-select').append(html);
                $('.city-select').attr('disabled', false);

                $('#properties-edit-modal').modal('show');
            }
        });
    });
    $('body').on('submit','#properties-edit-form',function (event) {
        event.preventDefault();

        const form = $(this);
        const url = form.attr('action');

        $.ajax({
            method: 'POST',
            url: url,
            data: form.serializeArray(),
            success: function (data) {
                // Si OK on cache la modale et on reconstruit le tableau des locaux
                if (data.result === 1) {
                    buildPropertiesTable(data.data.properties);
                    $('#properties-edit-modal').modal('hide');
                }
                // Sinon on affiche les erreurs dans le form
                if (data.result !== undefined) {
                    $('#properties-edit-modal-content').empty();
                    $('#properties-edit-modal-content').append(data.data.html.content);
                    if ($('.city-search').val().length >= 2) {
                        searchCityByZipCode($('.city-search').val(), '/city/search');
                    }

                    showToast(data.message.body, data.message.title, data.result, {timeOut: 2500});
                }
            }
        });
    });

    // Suppression d'un local
    $('body').on('click', '.properties-action-delete', function () {
        const propertyId = $(this).closest('tr').data('property-id');
        const propertyLabel = $(this).closest('tr').data('property-label');

        $('#properties-delete-modal-id').val(propertyId);
        $('#properties-delete-modal-label').html(propertyLabel);
    });
    $('#btn-delete-properties').on('click', function () {
        const url = $('#properties-delete-modal-url').val();
        const data = {
            id_property: $('#properties-delete-modal-id').val()
        };

        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            success: function (data) {
                // Si OK on cache la modale et on reconstruit le tableau des locaux
                if (data.result === 1) {
                    showToast(data.message.body, data.message.title, data.result, {timeOut: 2500});

                    // const properties = $.parseJSON(data.data.properties[0]);
                    buildPropertiesTable(data.data.properties);
                    $('#properties-delete-modal').modal('hide');
                }
            }
        });
    });

});

/**
 * Fonction buildPropertiesTable
 * Reconstruction du tableau des locaux
 *
 * @param datas
 */
function buildPropertiesTable(datas) {
    // Récupération des images SVG pour pouvoir les réinjecter en JS
    const svg = getSVGPropertiesAction();

    // Vidage du corps de tableau
    $('#properties-table tbody').empty();

    // Construction du corps de tableau (HTML + SVG)
    let html = "";
    $(datas).each(function () {
        let occupation = "";
        if (this.purchaseDate !== null) {
            occupation = 'Acquis depuis le '+ moment(this.purchaseDate).format('DD/MM/YYYY');
        }

        let additionalAdress = "";
        if (this.idAdress.additionalAdress !== null) {
            additionalAdress = this.idAdress.additionalAdress;
        }

        html += '<tr data-property-id="'+ this.idProperty +'" data-property-label="'+ this.label +'"><td>'+ this.label +'</td><td><div class="d-flex flex-column"><span>'+ this.idAdress.street +'</span><span>'+ additionalAdress +'</span><span>'+ this.idAdress.zipCode +' '+ this.idAdress.idCity.name +'</span></div></td><td>'+ occupation +'</td><td><div class="d-flex justify-content-center properties-actions"></div></td></tr>';

    });
    $('#properties-table tbody').append(html);
    $('.properties-actions').append(svg);
}

/**
 * Fonction getSVGPropertiesAction
 * Récupération des images SVG des boutons d'action du tableau
 *
 * @returns {*|jQuery.fn.init|jQuery|HTMLElement}
 */
function getSVGPropertiesAction() {
    return $('.properties-action:lt(2)');
}


/**
 * Fonction searchCityByZipCode
 * Recherche d'une ville à partir d'un code postal complétement ou partiellement renseigné
 *
 * @param zipCode
 * @param url
 */
function searchCityByZipCode(zipCode, url) {
    const data = {
        zip_code: zipCode
    };

    $.ajax({
        method: 'POST',
        url: url,
        data: data,
        success: function (data) {
            // Si moins de 50 résultats on construit le select des villes
            if (data.result === 1) {
                $('.city-select').html("");
                let html = '';
                $(data.data.cities).each(function () {
                    html += '<option value="'+ this.idCity + '" data-zip-code="'+ this.zipCode +'">'+ this.name +'</option>'
                });
                $('.city-select').append(html);
                $('.city-select').attr('disabled', false);
            }
            else if (data.result === 0) {
                $('.city-select').html("");
                $('.city-select').attr('disabled', true);
            }
        }
    });
}