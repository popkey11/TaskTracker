$(document).ready(function () {
    let tDateFormat = 'dd/mm/yy';
    let aDayNamesMin = ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'];
    let aMonthNamesShort = [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];
    /**
     * Functionality : init Check Status and Dev Group
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    JSxPJTUpdateStatus();
    JSxPJTChangeDevGroup();

    /**
     * Functionality : Event edit text serach select release
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    $(document).on('input', '.bs-searchbox input', function () {
        const $aDropdownParent = $(this).closest('.dropdown-menu').prev('button[data-id="ocmPjtRelease"]');

        if ($aDropdownParent.length > 0) {
            const $oSelect = $('#ocmPjtRelease');
            const tInputValue = $(this).val().trim();
            const oSelectOptions = $oSelect.find('option').map(function () {
                return $(this).val();
            }).get();

            if (tInputValue && !oSelectOptions.includes(tInputValue)) {
                const $tMsgSelect = $oSelect.parent().find('.no-results');
                $tMsgSelect.html('Enter เพื่อเลือก "' + tInputValue + '"');
            }
        }
    });

    /**
     * Functionality : Add option for Project Release
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    $(document).on('keydown', '.bs-searchbox input', function (e) {
        const $aDropdownParent = $(this).closest('.dropdown-menu').prev('button[data-id="ocmPjtRelease"]');

        if ($aDropdownParent.length > 0 && e.key === 'Enter') {
            e.preventDefault();
            const tInputValue = $(this).val().trim();
            const $oSelect = $('#ocmPjtRelease');
            const oSelectOptions = $oSelect.find('option').map(function () {
                return $(this).val();
            }).get();

            if (tInputValue && !oSelectOptions.includes(tInputValue)) {
                $oSelect.append('<option value="' + tInputValue + '">' + tInputValue + '</option>');
                $oSelect.selectpicker('refresh');
                $oSelect.selectpicker('val', tInputValue);
            }
        }
    });
    
    /**
     * Functionality : datepicker for id odpPjtStartDate
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    $("#odpPjtStartDate").datepicker({
        dateFormat: tDateFormat,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: aDayNamesMin,
        monthNamesShort: aMonthNamesShort,
        onSelect: function (pdSelectedDate) {
            // ตั้งค่า minDate ของ odpPjtEndDate ตามวันที่เลือกใน odpPjtStartDate
            $("#odpPjtEndDate").datepicker("option", "minDate", pdSelectedDate);
        }
    });

    /**
     * Functionality : datepicker for id odpPjtEndDate
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    $("#odpPjtEndDate").datepicker({
        dateFormat: tDateFormat,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: aDayNamesMin,
        monthNamesShort: aMonthNamesShort,
        onClose: function () {
            // ตรวจสอบว่าค่าของ odpPjtEndDate น้อยกว่า odpPjtStartDate หรือไม่
            let dStartDate = $("#odpPjtStartDate").datepicker("getDate");
            let dEndDate = $("#odpPjtEndDate").datepicker("getDate");

            if (dEndDate && dStartDate && dEndDate < dStartDate) {
                alert("วันที่แผนเสร็จต้องไม่น้อยกว่าวันที่เริ่มแผน");
                $(this).val(''); // ล้างค่า odpPjtEndDate หากไม่ถูกต้อง
            }
        }
    });

    /**
     * Functionality : Change dev show group to input oetPjtDevGroup
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : text in HTML format of select options
     * Return Type : void
     */
    $('#ocmPjtDev').on('change', function () {
        JSxPJTChangeDevGroup();
    })

    /**
     * Functionality : Change dev show group to input oetPjtDevGroup
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : text in HTML format of select options
     * Return Type : void
     * */
    function JSxPJTChangeDevGroup() {
        if ($('#ocmPjtDev').val() != '') {
            var devGroup = $('#ocmPjtDev').find(':selected').data('pjtdevgroup');
            var depGroup = $('#ocmPjtDev').find(':selected').data('pjtdepgroup');
            $('#oetPjtDevGroup').val(devGroup);
            $('#ohdPjtDepCode').val(depGroup);
        }
    }

    /**
     * Functionality : Change status to input olaPjtIsActive
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : text in HTML
     * Return Type : void
     */
    $('#ocbPjtIsAcive').on('change', function () {
        JSxPJTUpdateStatus();
    });
    /**
     * Functionality : Change dev show group to input oetPjtDevGroup
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : text in HTML format of select options
     * Return Type : void
     */
    function JSxPJTUpdateStatus() {
        if ($('#ocbPjtIsAcive').is(':checked')) {
            $('#olaPjtIsActive').text('ใช้งาน');
            $('#ohdPjtIsAcive').val('1'); // Set hidden input value to 1
        } else {
            $('#olaPjtIsActive').text('ไม่ใช้งาน');
            $('#ohdPjtIsAcive').val('0'); // Set hidden input value to 0
        }
    }

    /**
     * Functionality : Check date format in input field odpPjtStartDate and odpPjtEndDate
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    jQuery.validator.addMethod("customDate", function (value, element) {
        // ตรวจสอบว่าเป็นค่าว่างหรือไม่ หากไม่ใช่ค่าว่างให้ตรวจสอบรูปแบบวันที่
        return this.optional(element) || /^\d{2}\/\d{2}\/\d{4}$/.test(value);
    }, "กรุณากรอกวันที่ในรูปแบบ");

    /**
     * Functionality : Submit form via AJAX
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    // Form validation and submission via AJAX
    $('#ofmPjtAddData').validate({
        rules: {
            ocmPjtCode: {
                required: true
            },
            ocmPjtRelease: {
                required: true
            },
            ocmPjtDev: {
                required: true
            },
            odpPjtStartDate: {
                required: true,
                customDate: true
            },
            odpPjtEndDate: {
                required: true,
                customDate: true
            }
        },
        messages: {
            ocmPjtCode: {
                required: "กรุณาเลือกโครงการ"
            },
            ocmPjtRelease: {
                required: "กรุณาเลือก Release"
            },
            ocmPjtDev: {
                required: "กรุณาเลือกพนักงาน"
            },
            odpPjtStartDate: {
                required: "กรุณาเลือกวันที่เริ่มต้น",
                customDate: "กรุณากรอกวันที่ให้ถูกต้อง"
            },
            odpPjtEndDate: {
                required: "กรุณาเลือกวันที่สิ้นสุด",
                customDate: "กรุณากรอกวันที่ให้ถูกต้อง"
            }
        },
        errorPlacement: function (error, element) {
            error.addClass("text-danger");
            if (element.hasClass("selectpicker")) {
                element.closest('.bootstrap-select').after(error);
            } else if (element.closest('.input-group').length) {
                element.closest('.input-group').after(error);
            } else {
                element.after(error);
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
            if ($(element).hasClass("selectpicker")) {
                $(element).closest(".bootstrap-select").addClass("is-invalid");
            }
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
            if ($(element).hasClass("selectpicker")) {
                $(element).closest(".bootstrap-select").removeClass("is-invalid");
            }
        },
        submitHandler: function (ptForm) {
            var oFormData = new FormData(ptForm);
            $.ajax({
                url: $(ptForm).attr('action'),
                type: 'POST',
                data: oFormData,
                processData: false,
                contentType: false,
                success: function (paResponse) {
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        window.location.href = tUrlMasPJTPageListView;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 400) {
                        alert('ข้อมูลซ้ำ : พนักงานอยู่ในโครงการและ Release นี้แล้ว');
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });
});