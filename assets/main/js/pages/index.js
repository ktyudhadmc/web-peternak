// alert('hello');
const datakandang = [];
const datamati = [];
const datadeplesi = [];
var colomwidth = "10%";
$.ajax({
    type: 'GET',
    url: base_url + 'home/getdata',
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
        outputjson = JSON.parse(response);
        for (let i = 0; i < outputjson.length; i++) {
            datakandang.push(outputjson[i]['tgl']);
            datamati.push(outputjson[i]['mati']);
            datadeplesi.push(outputjson[i]['deplesi']);
        }
        if(outputjson.length > 4){
            colomwidth = "40%";
        }
        var KTChartsWidget3 = {
            init: function () {
                ! function () {
                    var e = document.getElementById("chartdashboard"),
                        a = parseInt(KTUtil.css(e, "height")),
                        t = KTUtil.getCssVariableValue("--bs-gray-900"),
                        l = KTUtil.getCssVariableValue("--bs-border-dashed-color");
                    if (e) {
                        var i = new ApexCharts(e, {
                            series: [{
                                    name: 'Mati',
                                    data: datamati
                                },
                                {
                                    name: 'Deplesi',
                                    data: datadeplesi
                                }
                            ],
                            chart: {
                                fontFamily: "inherit",
                                type: "bar",
                                height: a,
                                toolbar: {
                                    show: !1
                                }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: !1,
                                    columnWidth: colomwidth,
                                    borderRadius: 5,
                                    dataLabels: {
                                        position: "top"
                                    },
                                    barHeight: '80%',
                                    startingShape: "flat"
                                }
                            },
                            legend: {
                                show: !1
                            },
                            dataLabels: {
                                enabled: !0,
                                offsetY: -20,
                                style: {
                                    fontSize: "8px",
                                    fontWeight: 'bold',
                                    colors: ["#000000"]
                                },
                            },
                            stroke: {
                                width: 4,
                                colors: ["transparent"]
                            },
                            xaxis: {
                                categories: datakandang,
                                axisBorder: {
                                    show: !1
                                },
                                axisTicks: {
                                    show: !1
                                },
                                labels: {
                                    style: {
                                        colors: KTUtil.getCssVariableValue("--bs-gray-500"),
                                        fontSize: "7px",
                                        fontWeight: 'bold'
                                    }
                                },
                                crosshairs: {
                                    fill: {
                                        gradient: {
                                            opacityFrom: 0,
                                            opacityTo: 0
                                        }
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        colors: KTUtil.getCssVariableValue("--bs-gray-500"),
                                        fontSize: "9px"
                                    },
                                    // formatter: function (e) {
                                    //     return e + "H"
                                    // }
                                }
                            },
                            fill: {
                                opacity: 1
                            },
                            states: {
                                normal: {
                                    filter: {
                                        type: "none",
                                        value: 0
                                    }
                                },
                                hover: {
                                    filter: {
                                        type: "none",
                                        value: 0
                                    }
                                },
                                active: {
                                    allowMultipleDataPointsSelection: !1,
                                    filter: {
                                        type: "none",
                                        value: 0
                                    }
                                }
                            },
                            tooltip: {
                                style: {
                                    fontSize: "9px"
                                },
                                y: {
                                    // formatter: function (e) {
                                    //     return +e + " hours"
                                    // }
                                }
                            },
                            colors: ['#fa1302', '#ff5b03'],
                            grid: {
                                borderColor: l,
                                strokeDashArray: 4,
                                yaxis: {
                                    lines: {
                                        show: !0
                                    }
                                }
                            }
                        });

                        setTimeout((function () {
                            i.render()
                        }), 200)
                    }
                }()
            }
        };

        "undefined" != typeof module && (module.exports = KTChartsWidget3), KTUtil.onDOMContentLoaded((function () {
            KTChartsWidget3.init()
        }));
    },
});