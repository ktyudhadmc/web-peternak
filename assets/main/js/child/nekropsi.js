
function nekropsi() {
    const outputnekropsi = $("#outputnekropsi");
    if (outputnekropsi.html() == "") {
        $.ajax({
            method: "POST",
            data: { user_id: useridfinal, token: tokenfinal, kandangperiode: idkandangperiode },
            url: base_url + 'ajax/nekropsi/',
            cache: false,
            beforeSend: function () {
                outputnekropsi.html(loadingnih());
            },
            success: function (response) {
                outputnekropsi.html(response);
            }
        });
    }
    console.log("nekropsi here");
}