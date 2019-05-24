$(document).ready(function () {

    $('#btn-properties-add-modal').on('click', function () {
        $('#properties-add-form').trigger('reset');
    });

    $('body').on('submit','#properties-add-form',function (event) {
        event.preventDefault();

        const form = $(this);
        const url = form.attr('action');

        $.ajax({
            method: 'POST',
            url: url,
            data: form.serializeArray()
        })
            .done(function (data, status, xhr) {
                if (status == "success") {
                    let ct = xhr.getResponseHeader("content-type") || "";

                    if (ct.indexOf('html') > -1) {
                        $('#properties-add-modal-content').empty();
                        $('#properties-add-modal-content').append(data);
                    }

                    if (ct.indexOf('json') > -1) {
                        if (data.result === 1) {
                            $('#properties-add-modal').modal('hide');
                            $('#properties-add-modal-content').empty();
                            $('#properties-add-modal-content').append(data.data.template.content);
                        }
                    }
                }
            })
            .fail(function (error) {
                console.log(error);
            });
    });

});

function buildPropertiesTable() {
    const svg = getSVG();

    $('#properties-table tbody').empty();
    let html = '<tr data-id-property=""><td>CENTRAL FAC</td><td><div class="d-flex flex-column"><span>Résidence Central Fac</span><span>7 rue des Amaryllis</span><span>34070 Montpellier</span></div></td><td>Loué depuis 8 mois</td><td><div class="d-flex justify-content-center properties-actions"></div></td></tr><tr data-id-property=""><td>LA RADIEUSE</td><td><div class="d-flex flex-column"><span>Résidence Central Fac</span><span>7 rue des Amaryllis</span><span>34090 Montpellier</span></div></td><td>Loué depuis 10 mois</td><td><div class="d-flex justify-content-center properties-actions"></div></td></tr>';

    $('#properties-table tbody').append(html);

    $('.properties-actions').append(svg);
}

function getSVG() {
    return $('.properties-action:lt(2)');
}