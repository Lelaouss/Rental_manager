$(document).ready(function () {

    let xeee = toto;



});

function buildPropertiesTable() {
    $('#properties-table tbody').empty();
    let html = '<tr>\n' +
        '                    <td>CENTRAL FAC</td>\n' +
        '                    <td>\n' +
        '                        <div class="d-flex flex-column">\n' +
        '                            <span>Résidence Central Fac</span>\n' +
        '                            <span>7 rue des Amaryllis</span>\n' +
        '                            <span>34070 Montpellier</span>\n' +
        '                        </div>\n' +
        '                    </td>\n' +
        '                    <td>Loué depuis 8 mois</td>\n' +
        '                    <td>\n' +
        '                        <div class="d-flex justify-content-center">\n' +
        '                            <span class="properties-action">{{ source(\'@img_path/edit.svg\') }}</span>\n' +
        '                            <span class="properties-action">{{ source(\'@img_path/garbage.svg\') }}</span>\n' +
        '                        </div>\n' +
        '                    </td>\n' +
        '                </tr>';
    $('#properties-table tbody').append(html);
}