
// function loaddatasensor(mindatefilter, maxdatefilter) {
function loaddatasensor_realtime() {
    var id_kandang = $('#filter_kandang_sensor').val();
    // var periode = $('#filter_periode_sensor').val();
    // var sensor = "weighing";
     var id_kandangnih = $("#filter_kandang_sensor").val();
     if (id_kandangnih) {
         setInterval(function () {
             getdata(id_kandang);
         }, 3000);
     }
}

const getdata = (id_kandang) => {
    $.ajax({
        'type': "GET",
        'url': base_url + 'api/plc/getdataplc/' + id_kandang,
        'cache': false,
        'success': function (data) {
            var parsedata = JSON.parse(data);
            $("#temp_text").text(parseFloat(parsedata.message.avg) / 10 + " °C | " + parseFloat(parsedata.message.set_temp) / 10 + " °C");
            $("#humidity_text").text(parseFloat(parsedata.message.hum));
            $("#water_text").text(parseFloat(parsedata.message.water) + " L");
            $("#weighingbw_text").text(parsedata.message.bw + " Gram");
        }
    });
}
