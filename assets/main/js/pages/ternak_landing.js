$("#loader").hide();
const idkandangperiode = $("#kandang_periode").val();
const id_kandang = $("#id_kandang").val();
const status_kandang = $("#status_kandang").val();
const useridfinal = user_idjs; //
const outputternak = $("#outputternaklanding");
const ternak_detail_top = $("#ternak_detail_top");
api_url2 = "http://sek.my.id:4001/peternak_api/";
if (outputternak) {
    const id_kandang = $("#id_kandang").val();
    $.ajax({
        method: "POST",
        dataType: 'JSON',
        data: {
            user_id: useridfinal,
            id_kandang: id_kandang,
            token: tokenfinal,
            url: base_url
        },
        // url: api_url + 'ternak/ternakviewlanding',
        url: api_url2 + 'ternak/ternakviewlanding',
        cache: false,
        success: function (response) {
            const outputraw = JSON.stringify(response);
            const dataraw = JSON.parse(outputraw);
            outputternak.html(dataraw.data);
        }
    });
}

if (ternak_detail_top) {
    $.ajax({
        method: "POST",
        dataType: "html",
        data: {
            user_id: useridfinal,
            token: tokenfinal,
            kandangperiode: idkandangperiode
        },
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
        data: {
            user_id: useridfinal,
            token: tokenfinal
        },
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

var processs = function (search) {
    var timeout = setTimeout(function () {
        var number = KTUtil.getRandomInt(1, 6);

        // Hide recently viewed
        suggestionsElement.classList.add("d-none");

        if (number === 3) {
            resultsElement.classList.add("d-none");
            emptyElement.classList.remove("d-none");
        } else {
            resultsElement.classList.remove("d-none");
            emptyElement.classList.add("d-none");
        }
        search.complete();
    }, 1500);
}

var clear = function (search) {
    suggestionsElement.classList.remove("d-none");
    resultsElement.classList.add("d-none");
    emptyElement.classList.add("d-none");
}

// Input handler
const handleInput = () => {
    getdatakandangtosearch()
    // Select input field
    const inputField = element.querySelector("[data-kt-search-element='input']");

    // Handle keyboard press event
    inputField.addEventListener("keydown", e => {
        var divs = $("#resultsearch");
        var values = divs[0].childNodes[0].innerText;
        console.log(divs[0].childNodes.length)
        if (e.key === "Enter") {
            e.preventDefault();
        }
    });
}

element = document.querySelector('#kt_docs_search_handler_basic');

if (!element) {
    // console.log('tidak ada id')
} else {
    wrapperElement = element.querySelector("[data-kt-search-element='wrapper']");
    suggestionsElement = element.querySelector("[data-kt-search-element='suggestions']");
    resultsElement = element.querySelector("[data-kt-search-element='results']");
    emptyElement = element.querySelector("[data-kt-search-element='empty']");
    searchObject = new KTSearch(element);
    searchObject.on("kt.search.process", processs);
    searchObject.on("kt.search.clear", clear);
    // Handle select
    KTUtil.on(element, "[data-kt-search-element='customer']", "click", function () {
        //modal.hide();
    });
    handleInput();
}
