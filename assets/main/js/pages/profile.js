var iduser = $("#iduser").val()

function bannedfunction() {
    var output;
    output = $('#bannedid').prop('checked') ? 1 : 0;

    $.ajax({
        method: "POST",
        url: base_url + 'test',
        data: { output: output },
        success: function (data) {
            console.log(data)
        }
    });
}
function submitform() {
    var fd = new FormData();
    var files = $('#avatar')[0].files;
    if (files.length > 0) {
        fd.append('fileimg', files[0]);
    }
    fd.append('first_name', $("#first_name").val());
    fd.append('last_name', $("#last_name").val());
    fd.append('alamat', $("#alamat").val());
    fd.append('number', $("#number").val());
    // console.log(fd);

    $.ajax({
        url: base_url + 'user/input_user',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function (response) {
            var parsedata = JSON.parse(response);
            if (parsedata.status == true) {
                alert('oke')
            } else {
                alert('uhui')
            }
        },
    });
}