function logrh() {
    const outputlogrh = $("#outputlogrh");
    if (outputlogrh.html() == "") {
        $.ajax({
            method: "POST",
            data: {
                user_id: useridfinal,
                token: tokenfinal,
                kandangperiode: idkandangperiode
            },
            url: base_url + 'ajax/logrh/',
            cache: false,
            beforeSend: function () {
                outputlogrh.html(loadingnih());
            },
            success: function (response) {
                outputlogrh.html(response);
                loaddatasensor();
                loaddatasensor_water();
                loaddatasensor_weighing();
                loaddatasensor_realtime();
            }
        });
    }
}