function pendapatan() {
    const outputpendapatan = $("#outputpendapatan");
    if (outputpendapatan.html() == "") {
        $.ajax({
            method: "POST",
            data: { user_id: useridfinal, token: tokenfinal, kandangperiode: idkandangperiode },
            url: base_url + 'ajax/pendapatan/',
            cache: false,
            beforeSend: function () {
                outputpendapatan.html(loadingnih());
            },
            success: function (response) {
                outputpendapatan.html(response);
            }
        });
    }
}