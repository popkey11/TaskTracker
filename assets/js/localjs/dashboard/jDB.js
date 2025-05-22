$(document).ready(function () {
    var dateBefore = null;
    let tDateFormat = 'dd/mm/yy';
    let aDayNamesMin = ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'];
    let aMonthNamesShort = [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];

    $(".datepicker").datepicker({
        setDate: new Date(),
        dateFormat: tDateFormat,
        buttonImageOnly: true,
        dayNamesMin: aDayNamesMin,
        monthNamesShort: aMonthNamesShort,
        changeMonth: true,
        changeYear: true,
        onClose: function () {
            if ($(this).val() != "" && $(this).val() == dateBefore) {
                var arrayDate = dateBefore.split("-");
                arrayDate[2] = parseInt(arrayDate[2]) + 543;
                $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
            }
        }
    });

    var setDate = new Date();
    var setMonth = new Date();
    setMonth.setMonth(setMonth.getMonth() - 12);

    var dToDate = String(setDate.getDate()).padStart(2, '0') + '/' + String(setDate.getMonth() + 1).padStart(2, '0') + '/' + setDate.getFullYear();
    var dFromDate = String(setMonth.getDate()).padStart(2, '0') + '/' + String(setMonth.getMonth() + 1).padStart(2, '0') + '/' + setMonth.getFullYear();
    // $('#odpDBToDate').val(dToDate)
    // $('#odpDBFromDate').val(dFromDate)
    localStorage.removeItem('dbSearchData');     // ลบ key ชื่อ 'dbSearchData' ออกจาก localStorage
    sessionStorage.removeItem('dbSearchData');   // เช่นเดียวกันใน sessionStorage

    $('#ocbDBSelectAllCustomer').click()
    // $('#ocbDBSelectAllPhase').click()
    JSxDBLoadSearchData()
    JStDBGetData()
});

document.addEventListener('DOMContentLoaded', function () {
    const selectAllPhase = document.getElementById('ocbDBSelectAllPhase');
    const checkboxes = document.querySelectorAll('.checkbox');

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

document.addEventListener('DOMContentLoaded', function () {
    const selectAllCustomer = document.getElementById('ocbDBSelectAllCustomer');
    const checkboxes = document.querySelectorAll('.checkboxCustomer');

    // เมื่อคลิก "เลือกทั้งหมด"
    selectAllCustomer.addEventListener('change', function () {
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

document.addEventListener('DOMContentLoaded', function () {
    const selectAllCustomer = document.getElementById('ocbDBSelectAllTo');
    const checkboxes = document.querySelectorAll('.checkboxTo');

    // เมื่อคลิก "เลือกทั้งหมด"
    selectAllCustomer.addEventListener('change', function () {
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
 * Functionality : Filter data
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 */
function JSxDBFilterData() {
    // Get current search values
    // var nDBSearchCustomer = $("#ocmPoCustomer").val();
    var dDBSearchFromDate = $("#odpDBFromDate").val();
    var dDBSearchToDate = $('#odpDBToDate').val();
    let aDBSearchCustomer = [];
    let aDBOptionStatus = [];
    let aDBSearchTo = [];
    $('.checkboxCustomer:checked').each(function() {
        aDBSearchCustomer.push($(this).val());
    });
    $('.checkbox:checked').each(function() {
        aDBOptionStatus.push($(this).val());
    });
    $('.checkboxTo:checked').each(function() {
        aDBSearchTo.push($(this).val());
    });


    // Create an object to store the search values
    var oSearchData = {
        // nDBSearchCustomer: nDBSearchCustomer,
        dDBSearchFromDate: dDBSearchFromDate,
        dDBSearchToDate: dDBSearchToDate,
    };

    // Save the search data to local storage
    localStorage.setItem('dbSearchData', JSON.stringify(oSearchData));

    // Reset page number
    $("#ohdFilterDBPage").val(1);
    $("#ohdFilterDBPageTrack").val(1);

    // Perform the search
    JStDBGetData();
}

/**
 * Functionality : Get Data from server
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : Text in HTML format of table data
 * Return Type : string
 */
function JStDBGetData(pnPage = 1,pnPageTrack = 1) {
    // var nDBSearchCustomer = $("#ocmPoCustomer").val();
    var dDBSearchFromDate = $("#odpDBFromDate").val();
    var dDBSearchToDate = $('#odpDBToDate').val();
    let aDBSearchCustomer = [];
    let aDBOptionStatus = [];
    let aDBSearchTo = [];
    $('.checkboxCustomer:checked').each(function() {
        aDBSearchCustomer.push($(this).val());
    });
    $('.checkbox:checked').each(function() {
        aDBOptionStatus.push($(this).val());
    });
    $('.checkboxTo:checked').each(function() {
        aDBSearchTo.push($(this).val());
    });

    $.ajax({
        type: "POST",
        url: tUrlDocDBGetDataPo,
        data: {
            // "nDBSearchCustomer": nDBSearchCustomer,
            "dDBSearchFromDate": dDBSearchFromDate,
            "dDBSearchToDate": dDBSearchToDate,
            "aDBSearchCustomer": aDBSearchCustomer,
            "aDBSearchTo": aDBSearchTo,
            "aDBOptionStatus": aDBOptionStatus,
            "nPage": pnPage,
            "nPageTrack": pnPageTrack
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $("#odvDBDataList").html(tResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
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
function JSxDBLoadSearchData() {
    var sSearchData = localStorage.getItem('dbSearchData');
    if (sSearchData) {
        var oSearchData = JSON.parse(sSearchData);

        // $('#ocmPoCustomer').val(oSearchData.nDBSearchCustomer).selectpicker('refresh');
        $('#odpDBFromDate').val(oSearchData.dDBSearchFromDate);
        $('#odpDBToDate').val(oSearchData.dDBSearchToDate);
    }
}

/**
 * Functionality : Test Export File Excel
 */
function JSxDBExportExcelProjectUrgent(){
    window.location.href = tUrlDocDBExportProjectUrgent;
    
    // var dDBSearchFromDate = $("#odpDBFromDate").val();
    // var dDBSearchToDate = $('#odpDBToDate').val();
    // let aDBSearchCustomer = [];
    // let aDBOptionStatus = [];
    // let aDBSearchTo = [];
    // $('.checkboxCustomer:checked').each(function() {
    //     aDBSearchCustomer.push($(this).val());
    // });
    // $('.checkbox:checked').each(function() {
    //     aDBOptionStatus.push($(this).val());
    // });
    // $('.checkboxTo:checked').each(function() {
    //     aDBSearchTo.push($(this).val());
    // });

    // $.ajax({
    //     type: "POST",
    //     url: tUrlDocDBExportProjectUrgent,
    //     data: {
    //         "dDBSearchFromDate": dDBSearchFromDate,
    //         "dDBSearchToDate": dDBSearchToDate,
    //         "aDBSearchCustomer": aDBSearchCustomer,
    //         "aDBSearchTo": aDBSearchTo,
    //         "aDBOptionStatus": aDBOptionStatus,
    //     },
    //     cache: false,
    //     timeout: 0,
    //     success: function (tResult) {
    //         console.log(tResult);
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) {
    //         alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
    //     }
    // });
}
