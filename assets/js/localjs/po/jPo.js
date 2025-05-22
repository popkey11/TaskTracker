$(document).ready(function () {
    JSxLoadSearchValuesFromStorage();
    JSxPOLoadSearchData();
    JStPOGetData();
    localStorage.removeItem('activeTab');     // ลบ key ชื่อ 'activeTab' ออกจาก localStorage
    sessionStorage.removeItem('activeTab');   // เช่นเดียวกันใน sessionStorage
    $('#ocbPOSelectAllPhase').click()
});

document.addEventListener('DOMContentLoaded', function () {
    const selectAllPhase = document.getElementById('ocbPOSelectAllPhase');
    const checkboxes = document.querySelectorAll('.CheckBoxPoStatus');

    // เมื่อคลิก "เลือกทั้งหมด"
    selectAllPhase.addEventListener('change', function () {
        if (this.checked) {
            // ติ๊กเฉพาะอันที่ยังไม่ถูกติ๊ก
            checkboxes.forEach(cb => {
                if (!cb.checked) cb.checked = true;
            });
        } else {
            // ถ้าอยากให้ยกเลิกทั้งหมดด้วย ให้ใส่ block นี้
            checkboxes.forEach(cb => cb.checked = false);
        }
    });
});

/**
 * Functionality : Popup confirm delete data
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : massage alert
 * Return Type : void
 */
$(document).off('click').on('click', '.xWPoDeleteData', function () {
    var tPoCode = $(this).data('tpocode');
    var bIsConfirmed = confirm('คุณต้องการลบข้อมูลใช่หรือไม่?\nข้อมูลที่ถูกลบจะไม่สามารถกู้คืนได้!');
    if (bIsConfirmed) {
        JSxPODeleteData(tPoCode);
    }
})

/**
 * Functionality : Filter data
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 */
function JSxPOFilterData() {
    // Get current search values
    var tPoSearch = $("#oetPoSearch").val();
    var nPoSearchYear = $("#ocmPoSearchYear").val();
    var nPoSearchProject = $("#ocmPoSearchProject").val();
    // var nPoSearchStatus = $('#ocmPoSearchStatus').val();
    var tPoSearchFrom = $("#ocmPoSearchFrom").val();
    var tPoSearchTo = $('#ocmPoSearchTo').val();
    var tPoSearchPm = $("#ocmPoSearchPm").val();
    var tPoSearchSa = $('#ocmPoSearchSa').val();
    var tPoSearchBD = $('#ocmPoSearchBD').val();
    var nPoSearchProgress = $('#onbPoProgress').val();

    var nPoSearchStatus = [];
    $('.CheckBoxPoStatus:checked').each(function() {
        nPoSearchStatus.push($(this).val());
    });


    // Create an object to store the search values
    var oSearchData = {
        tPoSearch: tPoSearch,
        nPoSearchYear: nPoSearchYear,
        nPoSearchProject: nPoSearchProject,
        // nPoSearchStatus: nPoSearchStatus,
        tPoSearchFrom: tPoSearchFrom,
        tPoSearchTo: tPoSearchTo,
        tPoSearchPm: tPoSearchPm,
        tPoSearchSa: tPoSearchSa,
        tPoSearchBD: tPoSearchBD,
        nPoSearchProgress: nPoSearchProgress,
    };

    // Save the search data to local storage
    localStorage.setItem('poSearchData', JSON.stringify(oSearchData));

    // Reset page number
    $("#ohdFilterPoPage").val(1);

    // Perform the search
    JStPOGetData();
}

/**
 * Functionality : Get Data from server
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : Text in HTML format of table data
 * Return Type : string
 */
function JStPOGetData(pnPage = 1) {
    var tPoSearch = $("#oetPoSearch").val();
    var nPoSearchYear = $("#ocmPoSearchYear").val();
    var nPoSearchProject = $("#ocmPoSearchProject").val();
    // var nPoSearchStatus = $('#ocmPoSearchStatus').val();
    var tPoSearchFrom = $("#ocmPoSearchFrom").val();
    var tPoSearchTo = $('#ocmPoSearchTo').val();
    var tPoSearchPm = $("#ocmPoSearchPm").val();
    var tPoSearchSa = $('#ocmPoSearchSa').val();
    var tPoSearchBD = $('#ocmPoSearchBD').val();
    var nPoSearchProgress = $('#onbPoProgress').val();

    var nPoSearchStatus = [];
    $('.CheckBoxPoStatus:checked').each(function() {
        nPoSearchStatus.push($(this).val());
    });

    $.ajax({
        type: "POST",
        url: tUrlDocPOGetData,
        data: {
            "tPoSearch": tPoSearch,
            "nPoSearchYear": nPoSearchYear,
            "nPoSearchProject": nPoSearchProject,
            "nPoSearchStatus": nPoSearchStatus,
            "tPoSearchFrom": tPoSearchFrom,
            "tPoSearchTo": tPoSearchTo,
            "tPoSearchPm": tPoSearchPm,
            "tPoSearchSa": tPoSearchSa,
            "tPoSearchBD": tPoSearchBD,
            "nPoSearchProgress": nPoSearchProgress,
            "nPage": pnPage
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $("#odvPoList").html(tResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        }
    });
}

/**
 * Functionality : Delete data
 * Parameters : ptPoCode
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 * */
function JSxPODeleteData(ptPoCode) {
    $.ajax({
        type: "POST",
        url: tUrlDocPODeleteData,
        data: {
            'tPoCode': ptPoCode
        },
        success: function (paResponse) {
            let aRes = JSON.parse(paResponse);
            if (aRes.rtStatus === 'success') {
                alert(aRes.rtMessage);
                JStPOGetData()
            } else {
                alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาด: ' + errorThrown);
        }
    });
}

/**
 * Functionality : Load search data from local storage
 * Parameters : -
 * Creator : 27/11/2024 Sorawit
 * Last Modified : 27/11/2024 Sorawit
 * Return : -
 * Return Type : void
 */
function JSxPOLoadSearchData() {
    var sSearchData = localStorage.getItem('poSearchData');
    if (sSearchData) {
        var oSearchData = JSON.parse(sSearchData);

        $("#oetPoSearch").val(oSearchData.tPoSearch);
        $("#ocmPoSearchYear").val(oSearchData.nPoSearchYear).selectpicker('refresh');
        $("#ocmPoSearchProject").val(oSearchData.nPoSearchProject).selectpicker('refresh');
        // $('#ocmPoSearchStatus').val(oSearchData.nPoSearchStatus).selectpicker('refresh');
        $("#ocmPoSearchFrom").val(oSearchData.tPoSearchFrom).selectpicker('refresh');
        $('#ocmPoSearchTo').val(oSearchData.tPoSearchTo).selectpicker('refresh');
        $("#ocmPoSearchPm").val(oSearchData.tPoSearchPm).selectpicker('refresh');
        $('#ocmPoSearchSa').val(oSearchData.tPoSearchSa).selectpicker('refresh');
        $('#ocmPoSearchBD').val(oSearchData.tPoSearchBD).selectpicker('refresh');
        $('#onbPoProgress').val(oSearchData.nPoSearchProgress).selectpicker('refresh');
    }
}

/**
 * Functionality : Load value from local storage to search fields and selectpicker
 * Parameters : -
 * Creator : 27/11/2024 Sorawit
 * Last Modified : 27/11/2024 Sorawit
 * Return : -
 * Return Type : void
 */
function JSxLoadSearchValuesFromStorage() {
    var tPoSearch = localStorage.getItem('poSearch');
    var nPoSearchYear = localStorage.getItem('poSearchYear');
    var nPoSearchProject = localStorage.getItem('poSearchProject');
    // var nPoSearchStatus = localStorage.getItem('poSearchStatus');
    var tPoSearchFrom = localStorage.getItem('poSearchFrom');
    var tPoSearchTo = localStorage.getItem('poSearchTo');
    var tPoSearchPm = localStorage.getItem('poSearchFrom');
    var tPoSearchSa = localStorage.getItem('poSearchTo');
    var tPoSearchBD = localStorage.getItem('poSearchBD');
    var tPoSearchProgress = localStorage.getItem('nPoSearchProgress');

    if (tPoSearch) $("#oetPoSearch").val(tPoSearch);
    if (nPoSearchYear) $("#ocmPoSearchYear").val(nPoSearchYear);
    if (nPoSearchProject) $("#ocmPoSearchProject").val(nPoSearchProject);
    // if (nPoSearchStatus) $('#ocmPoSearchStatus').val(nPoSearchStatus);
    if (tPoSearchFrom) $("ocmPoSearchFrom").val(tPoSearchFrom);
    if (tPoSearchTo) $("ocmPoSearchTo").val(tPoSearchTo);
    if (tPoSearchPm) $("ocmPoSearchPm").val(tPoSearchPm);
    if (tPoSearchSa) $("ocmPoSearchSa").val(tPoSearchSa);
    if (tPoSearchBD) $("ocmPoSearchBD").val(tPoSearchBD);
    if (tPoSearchProgress) $("#onbPoProgress").val(tPoSearchProgress);

    // Refresh the selectpicker if you're using bootstrap-select
    $('.selectpicker').selectpicker('refresh');
}
/**
 * Functionality : Export Data for Excel
 * Parameters : -
 * Creator : 10/12/2024 Sorawit
 * Last Modified : 
 * Return : Excel file
 * Return Type : void
 */
function JSxPOExportExcel() {
    let nTotalRecord = parseInt($('#ohdTotalRecord').val());
    if (nTotalRecord <= 0) {
        alert('ไม่สามารถส่งออกได้ เนื่องจากไม่มีข้อมูลที่จะส่งออกเป็น excel');
        return;
    }
    var nPoSearchStatus = [];
    $('.CheckBoxPoStatus:checked').each(function() {
        nPoSearchStatus.push($(this).val());
    });

    $.ajax({
        url: docPOEventExportExcel,
        type: 'POST',
        data: {
            tPoSearch: $("#oetPoSearch").val(),
            nPoSearchYear: $("#ocmPoSearchYear").val(),
            nPoSearchProject: $("#ocmPoSearchProject").val(),
            nPoSearchStatus: nPoSearchStatus,
            tPoSearchFrom: $("#ocmPoSearchFrom").val(),
            tPoSearchTo: $('#ocmPoSearchTo').val(),
            tPoSearchPm: $("#ocmPoSearchPm").val(),
            tPoSearchSa: $('#ocmPoSearchSa').val(),
            tPoSearchBD: $('#ocmPoSearchBD').val(),
            nPoSearchProgress: $('#onbPoProgress').val(),
            nPoPage: $("#ohdFilterPoPage").val(),
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (paResponse, paStatus, poXhr) {
            var tFilename = "";
            var oDisposition = poXhr.getResponseHeader('Content-Disposition');
            if (oDisposition && oDisposition.indexOf('attachment') !== -1) {
                var tFilenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var aMatches = tFilenameRegex.exec(oDisposition);
                if (aMatches != null && aMatches[1]) tFilename = aMatches[1].replace(/['"]/g, '');
            }

            var tBlob = new Blob([paResponse], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var oLink = document.createElement('a');
            oLink.href = window.URL.createObjectURL(tBlob);
            oLink.download = tFilename;

            document.body.appendChild(oLink);
            oLink.click();
            document.body.removeChild(oLink);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการส่งออกข้อมูล: ' + errorThrown);
        }
    });
}