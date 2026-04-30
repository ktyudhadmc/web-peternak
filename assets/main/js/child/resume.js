function resume() {
    const outputresume = $("#outputresume");
    // console.log(document.getElementById('outputresume').innerHTML);

    if (outputresume.html() == "") {
        // console.log('1');
        $.ajax({
            method: "POST",
            data: { user_id: useridfinal, token: tokenfinal, kandangperiode: idkandangperiode },
            url: base_url + 'ajax/resume/',
            cache: false,
            beforeSend: function () {
                outputresume.html(loadingnih());
            },
            success: function (response) {
                outputresume.html(response);
                chartjs();
            }
        });
    }

}
const outputresume = $("#outputresume");
if (outputresume) {
    resume();
}

function selectperiodeaction() {
    var periode = $('#selectperiodeinput').val();
    // console.log(id_kandang);
    // http://192.168.58.58/peternak_main/main/ternak/detail/aktif/35/2205
    window.location.href = base_url + "main/ternak/detail/" + status_kandang + "/" + id_kandang + "/" + periode;
}