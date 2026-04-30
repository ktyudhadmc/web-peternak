if (flashdata_status != '') {
    set_flashdata(flashdata_status, flashdata_message);
}

function search_kandang(id_kandang) {
    // console.log(id_kandang);
    $.ajax({
        'type': "POST",
        'url': base_url + 'main/data_input/search_kandang',
        'data': {
            id: id_kandang,
        },
        'cache': false,
        'beforeSend': function () {
            document.querySelector('#id_kandang_value').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            document.querySelector('#nomorDO_value').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        },
        'success': function (data) {
            // console.log(data);
            var parsedata = JSON.parse(data);
            document.querySelector('#id_kandang_value').innerHTML = parsedata.result.id;
            document.querySelector('#nomorDO_value').innerHTML = parsedata.result.nomorDO;
        },
        // 'complete': function () {
        //     $("#button_calculate").prop('disabled', false); // enable button
        //     document.querySelector('#button_calculate').innerHTML = 'Calculate';
        // },

    });
}
function import_panen() {
    document.querySelector('#id_kandang_input').value = document.querySelector('#id_kandang_value').innerHTML;
}