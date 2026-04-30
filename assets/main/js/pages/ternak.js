
$("#loader").hide();
const idkandangperiode = $("#kandang_periode").val();
const id_kandang = $("#id_kandang").val();
const status_kandang = $("#status_kandang").val();
const outputternak = $("#outputternak");
const ternak_detail_top = $("#ternak_detail_top");
const useridfinal = user_idjs; //
if (outputternak) {
    const groupingname = $("#groupingname").val();
    console.log("grouping", groupingname);
    $.ajax({
        method: "POST",
        dataType: 'JSON',
        data: { user_id: useridfinal, groupingname: groupingname, token: tokenfinal, url: base_url },
        url: api_url + 'ajax/p/ternakviewpost',
        cache: false,
        success: function (response) {
            const outputraw = JSON.stringify(response);
            const dataraw = JSON.parse(outputraw);
            if (dataraw.status == true) {
                outputternak.html(dataraw.data);
            } else {
                console.log(dataraw.data)
            }
        }
    });
}

if (ternak_detail_top) {
    $.ajax({
        method: "POST",
        dataType: "html",
        data: { user_id: useridfinal, token: tokenfinal, kandangperiode: idkandangperiode },
        url: base_url + 'ajax/ternak_detail_top',
        success: function (response) {
            ternak_detail_top.html(response);
        }
    });
}
function changeternak(mode) {
    window.location.href = base_url + "main/ternak/view/" + mode;
}

function getdatakandangtosearch() {
    const resultsearch = $("#resultsearch");
    $.ajax({
        method: "POST",
        data: { user_id: useridfinal, token: tokenfinal },
        url: base_url + 'ajax/search/kandang',
        cache: false,
        beforeSend: function () {
            $("#searchbutton").hide();
        },
        success: function (response) {
            resultsearch.html(response);
            $("#searchbutton").show();
        }
    });
}

// var processs = function (search) {
//     var timeout = setTimeout(function () {
//         var number = KTUtil.getRandomInt(1, 6);

//         // Hide recently viewed
//         suggestionsElement.classList.add("d-none");

//         if (number === 1) {
//             resultsElement.classList.add("d-none");
//             emptyElement.classList.remove("d-none");
//         } else {
//             resultsElement.classList.remove("d-none");
//             emptyElement.classList.add("d-none");
//         }
//         search.complete();
//     }, 1500);
// }

// var clear = function (search) {
//     suggestionsElement.classList.remove("d-none");
//     resultsElement.classList.add("d-none");
//     emptyElement.classList.add("d-none");
// }

// Input handler
const handleInput = () => {
    getdatakandangtosearch()
    suggestionsElement = element.querySelector("[data-kt-search-element='suggestions']");
    suggestionsElement.classList.add("d-none");
    resultsElement = element.querySelector("[data-kt-search-element='results']");
    resultsElement.classList.remove("d-none");
    // // Select input field
    // const inputField = element.querySelector("[data-kt-search-element='input']");


    // // Handle keyboard press event
    // inputField.addEventListener("keydown", e => {
    //     var divs = $("#resultsearch");
    //     var values = divs[0].childNodes[0].innerText;
    //     console.log(divs[0].childNodes.length)
    //     if (e.key === "Enter") {
    //         e.preventDefault();
    //     }
    // });
}

function elementsSearch() {
    var list = document.getElementById("elementsSearchListaktif");
    var listItem = list.getElementsByClassName('element-item');
    var input = document.getElementById('searchkandangperiode');
    var filter = input.value.toUpperCase();
    for (i = 0; i < listItem.length; i++) {
        var a = listItem[i];
        var textValue = a.textContent || a.innerText;
        if (textValue.toUpperCase().indexOf(filter) > -1) {
            listItem[i].classList.remove("d-none");
        } else {
            listItem[i].classList.add("d-none");
        }
    }
}

element = document.querySelector('#kt_docs_search_handler_basic');

if (!element) {
    // console.log('tidak ada id')
} else {
    // wrapperElement = element.querySelector("[data-kt-search-element='wrapper']");
    // suggestionsElement = element.querySelector("[data-kt-search-element='suggestions']");
    // resultsElement = element.querySelector("[data-kt-search-element='results']");
    // emptyElement = element.querySelector("[data-kt-search-element='empty']");
    // searchObject = new KTSearch(element);
    // searchObject.on("kt.search.process", processs);
    // searchObject.on("kt.search.clear", clear);
    // // Handle select
    // KTUtil.on(element, "[data-kt-search-element='customer']", "click", function () {
    //     //modal.hide();
    // });
    handleInput();
}
