$(document).ready(function () {

    // Création d'un local
    $('body').on('submit','#properties-add-form',function (event) {
        event.preventDefault();

        const form = $(this);
        const url = form.attr('action');

        $.ajax({
            method: 'POST',
            url: url,
            data: form.serializeArray()
        })
            .done(function (data, status) {

                if (status == "success") {
                    // Si OK on cache la modale et on reconstruit le tableau des locaux
                    if (data.result === 1) {
                        buildPropertiesTable(data.data.properties);
                        $('#properties-add-modal').modal('hide');
                    }

                    showToast(data.message.body, data.message.title, data.result, {timeOut: 2500});
                    $('#properties-add-modal-content').empty();
                    $('#properties-add-modal-content').append(data.data.html.content);
                }
            })
            .fail(function (error) {
                console.log(error);
            });
    });

    // Suppression d'un local
    $('body').on('click', '.properties-action-delete', function () {
        const propertyId = $(this).closest('tr').data('property-id');
        const propertyLabel = $(this).closest('tr').data('property-label');

        console.log(propertyId);
        console.log(propertyLabel);

        $('#properties-delete-modal-id').val(propertyId);
        $('#properties-delete-modal-label').html(propertyLabel);

        $('#btn-delete-properties').on('click', function () {
            const url = $('#properties-delete-modal-url').val();
            const datas = {
                id_property: propertyId
            };

            $.ajax({
                method: 'POST',
                url: url,
                data: datas
            })
                .done(function (data, status, xhr) {

                    console.log(data);
                    console.log(status);
                    console.log(xhr);

                    if (status == "success") {
                        let ct = xhr.getResponseHeader("content-type") || "";

                        // Check de la réponse en JSON
                        if (ct.indexOf('json') > -1) {

                            // Si OK on cache la modale et on reconstruit le tableau des locaux
                            if (data.result === 1) {
                                showToast(data.message.body, data.message.title, data.result, {timeOut: 2500});

                                buildPropertiesTable(data.data.properties);
                                $('#properties-delete-modal').modal('hide');
                            }
                        }
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });
    });

});

function buildPropertiesTable(datas) {
    // Récupération des images SVG pour pouvoir les réinjecter en JS
    const svg = getSVGPropertiesAction();

    // Vidage du corps de tableau
    $('#properties-table tbody').empty();

    // Construction du corps de tableau (HTML + SVG)
    let html = "";
    $(datas).each(function () {
        html += '<tr data-id-property=""><td>CENTRAL FAC</td><td><div class="d-flex flex-column"><span>Résidence Central Fac</span><span>7 rue des Amaryllis</span><span>34070 Montpellier</span></div></td><td>Loué depuis 8 mois</td><td><div class="d-flex justify-content-center properties-actions"></div></td></tr>';

    });
    $('#properties-table tbody').append(html);
    $('.properties-actions').append(svg);
}

/**
 * Fonction de récupération des images SVG des boutons d'action du tableau
 *
 * @returns {*|jQuery.fn.init|jQuery|HTMLElement}
 */
function getSVGPropertiesAction() {
    return $('.properties-action:lt(2)');
}