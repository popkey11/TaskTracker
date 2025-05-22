// เมื่อผู้ใช้เปลี่ยนแท็บ
$('button[data-bs-toggle="pill"]').off('shown.bs.tab').on('shown.bs.tab', function (e) {
    const tabId = $(e.target).attr('data-bs-target');
    localStorage.setItem('activeTab', tabId);
});

$(document).ready(function () {
    var dateBefore = null;
    let tDateFormat = 'dd/mm/yy';
    let aDayNamesMin = ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'];
    let aMonthNamesShort = [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];

    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('button[data-bs-target="' + activeTab + '"]').tab('show');
    }

    /**
     * Functionality : datepicker for class datepicker
     * Parameters : -
     * Creator : 15/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
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
    /**
     * Functionality : datepicker for id odpPoStartDate
     * Parameters : -
     * Creator : 15/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    $("#odpPoStartDate").datepicker({
        dateFormat: tDateFormat,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: aDayNamesMin,
        monthNamesShort: aMonthNamesShort,
        onSelect: function (pdSelectedDate) {
            // ตั้งค่า minDate ของ odpPoEndDate ตามวันที่เลือกใน odpPoStartDate
            $("#odpPoEndDate").datepicker("option", "minDate", pdSelectedDate);
        }
    });

    /**
    * Functionality : datepicker for id odpPoEndDate
    * Parameters : -
    * Creator : 15/11/2024 Sorawit
    * Last Modified :
    * Return : -
    * Return Type : void
    */
    $("#odpPoEndDate").datepicker({
        dateFormat: tDateFormat,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: aDayNamesMin,
        monthNamesShort: aMonthNamesShort,
        onClose: function () {
            // ตรวจสอบว่าค่าของ odpPoEndDate น้อยกว่า odpPoStartDate หรือไม่
            let dStartDate = $("#odpPoStartDate").datepicker("getDate");
            let dEndDate = $("#odpPoEndDate").datepicker("getDate");

            if (dEndDate && dStartDate && dEndDate < dStartDate) {
                alert("วันที่แผนเสร็จต้องไม่น้อยกว่าวันที่เริ่มแผน");
                $(this).val(''); // ล้างค่า odpPoEndDate หากไม่ถูกต้อง
            }
        }
    });

    /**
    * Functionality : check format date for validate form
    * Parameters : -
    * Creator : 15/11/2024 Sorawit
    * Last Modified :
    * Return : -
    * Return Type : text
    */
    jQuery.validator.addMethod("customDate", function (value, element) {
        // ตรวจสอบว่าเป็นค่าว่างหรือไม่ หากไม่ใช่ค่าว่างให้ตรวจสอบรูปแบบวันที่
        return this.optional(element) || /^\d{2}\/\d{2}\/\d{4}$/.test(value);
    }, "กรุณากรอกวันที่ในรูปแบบ");

    /**
     * Functionality : datepicker for class datepicker
     * Parameters : -
     * Creator : 15/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    $("#oetPayPoDueDateEdit").datepicker({
        dateFormat: tDateFormat,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: aDayNamesMin,
        monthNamesShort: aMonthNamesShort,
    });

    /**
     * Functionality : datepicker for class datepicker
     * Parameters : -
     * Creator : 15/11/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    $("#oetPatDateEdit").datepicker({
        dateFormat: tDateFormat,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: aDayNamesMin,
        monthNamesShort: aMonthNamesShort,
    });

    /**
    * Functionality : validation form odpPo and submit form
    * Parameters : -
    * Creator : 15/11/2024 Sorawit
    * Last Modified :
    * Return : -
    * Return Type : void
    */
    $('#ofmPo').validate({
        rules: {
            ocmPoProject: {
                required: true
            },
            oetPoRelease: {
                required: true
            },
            oetPoDocNo: {
                required: true
            },
            odpPoDate: {
                required: true,
                customDate: true
            },
            onbPoValue: {
                required: true,
                number: true,
                min: 0 // เพิ่มกฎการตรวจสอบขั้นต่ำ
            },
            odpPoStartDate: {
                required: true,
                customDate: true
            },
            odpPoEndDate: {
                required: true,
                customDate: true
            },
            odpPoQttDate: {
                required: false,
                customDate: true
            },
            ocmPoPayType: {
                required: true
            },
            ocmPoPayStatus: {
                required: true
            },
        },
        messages: {
            ocmPoProject: {
                required: "กรุณาเลือกโครงการ"
            },
            oetPoRelease: {
                required: "กรุณากรอก Phase"
            },
            oetPoDocNo: {
                required: "กรุณากรอกเลขที่ใบสั่งซื้อ"
            },
            odpPoDate: {
                required: "กรุณาเลือกวันที่ใบสั่งซื้อ",
                customDate: "กรุณากรอกวันที่ให้ถูกต้อง"
            },
            onbPoValue: {
                required: "กรุณากรอกมูลค่าใบสั่งซื้อ",
                number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
                min: "กรุณากรอกมูลค่าตั้งแต่ 0 ขึ้นไป" // ข้อความที่จะแสดงเมื่อกรอกค่าต่ำกว่า 0
            },
            odpPoStartDate: {
                required: "กรุณาเลือกวันที่เริ่มแผน",
                customDate: "กรุณากรอกวันที่ให้ถูกต้อง"
            },
            odpPoEndDate: {
                required: "กรุณาเลือกวันที่แผนเสร็จ",
                customDate: "กรุณากรอกวันที่ให้ถูกต้อง"
            },
            onbPoProgress: {
                number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
                min: "กรุณากรอกความคืบหน้าระหว่าง 0-100",
                max: "กรุณากรอกความคืบหน้าระหว่าง 0-100"
            },
            odpPoQttDate: {
                customDate: "กรุณากรอกวันที่ให้ถูกต้อง"
            },
            ocmPoPayType: {
                required: "กรุณาเลือกการแบ่งชำระ"
            },
            ocmPoPayStatus: {
                required: "กรุณาเลือกสถานะการชำระ"
            },
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
                    let tEvent = $('#ohdPoEvent').val();
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        if(tEvent == 'addPo'){
                            window.location.href = tUrlDocPOPageListView;
                        }else{
                            location.reload();
                        }
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let aRes = JSON.parse(jqXHR.responseText);
                    if (aRes.rtStatus == 'error') {
                        alert(aRes.rtMessage);
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });

    /**
 * Functionality : Event edit text search select Po From, To
 * Parameters : -
 * Creator : 02/12/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 */
    $(document).on('input', '.bs-searchbox input', function () {
        const $aDropdownParent = $(this).closest('.dropdown-menu').prev('button[data-id]'); // ตรวจสอบปุ่มที่มี data-id

        if ($aDropdownParent.length > 0) {
            const tSelectId = $aDropdownParent.data('id'); // อ่านค่า data-id
            if (tSelectId === 'ocmPoFrom' || tSelectId === 'ocmPoTo') { // ตรวจสอบเฉพาะ id ที่ต้องการ
                const $oSelect = $('#' + tSelectId); // ค้นหา select element ตาม data-id
                const tInputValue = $(this).val().trim();
                const oSelectOptions = $oSelect.find('option').map(function () {
                    return $(this).val();
                }).get();

                if (tInputValue && !oSelectOptions.includes(tInputValue)) {
                    const $tMsgSelect = $oSelect.parent().find('.no-results');
                    $tMsgSelect.html('Enter เพื่อเลือก "' + tInputValue + '"');
                }
            }
        }
    });

    /**
     * Functionality : Add option for Po From, To
     * Parameters : -
     * Creator : 02/12/2024 Sorawit
     * Last Modified :
     * Return : -
     * Return Type : void
     */
    $(document).on('keydown', '.bs-searchbox input', function (e) {
        const $aDropdownParent = $(this).closest('.dropdown-menu').prev('button[data-id]'); // ตรวจสอบปุ่มที่มี data-id

        if ($aDropdownParent.length > 0 && e.key === 'Enter') {
            e.preventDefault();
            const tSelectId = $aDropdownParent.data('id'); // อ่านค่า data-id
            if (tSelectId === 'ocmPoFrom' || tSelectId === 'ocmPoTo') { // ตรวจสอบเฉพาะ id ที่ต้องการ
                const $oSelect = $('#' + tSelectId); // ค้นหา select element ตาม data-id
                const tInputValue = $(this).val().trim();
                const oSelectOptions = $oSelect.find('option').map(function () {
                    return $(this).val();
                }).get();

                if (tInputValue && !oSelectOptions.includes(tInputValue)) {
                    $oSelect.append('<option value="' + tInputValue + '">' + tInputValue + '</option>');
                    $oSelect.selectpicker('refresh');
                    $oSelect.selectpicker('val', tInputValue);
                }
            }
        }
    });

    $('#ofmPayPoAdd').validate({
        rules: {
            onbPayPoNo: {
                required: true
            },
            oetPayName: {
                required: true
            },
            ocmPayPoStatus: {
                required: true
            },
            onbPayPoAmount: {
                required: true
            },
            oetPayPoDueDate: {
                required: true
            },
            otaPayPoDesc: {
                required: true
            },
        },
        messages: {
            onbPayPoNo: {
                required: "กรุณากรอกเลขงวด"
            },
            oetPayName: {
                required: "กรุณากรอกชื่องวด"
            },
            ocmPayPoStatus: {
                required: "กรุณาเลือกสถานะ"
            },
            onbPayPoAmount: {
                number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
                min: "กรุณากรอกจำนวนเงินไม่น้อยกว่า 0",
                max: "กรุณากรอกจำนวนเงินไม่เกินที่กำหนด"
            },
            oetPayPoDueDate: {
                required: "กรุณาเลือกวันที่กำหนดชำระ"
            },
            otaPayPoDesc: {
                required: "กรุณากรอกรายละเอียดงวด"
            },
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
        submitHandler: function (ptPayFormAdd) {
            var oFormPayDataAdd = new FormData(ptPayFormAdd);
            $.ajax({
                url: $(ptPayFormAdd).attr('action'),
                type: 'POST',
                data: oFormPayDataAdd,
                processData: false,
                contentType: false,
                success: function (paResponse) {
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        location.reload();
                        // window.location.href = tUrlDocPOPageListView;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let aRes = JSON.parse(jqXHR.responseText);
                    if (aRes.rtStatus == 'error') {
                        alert(aRes.rtMessage);
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });

    $('#ofmPayPoEdit').validate({
        rules: {
            onbPayPoNoEdit: {
                required: true
            },
            oetPayNameEdit: {
                required: true
            },
            ocmPayPoStatusEdit: {
                required: true
            },
            onbPayPoAmountEdit: {
                required: true
            },
            oetPayPoDueDateEdit: {
                required: true
            },
            otaPayPoDescEdit: {
                required: true
            },
        },
        messages: {
            onbPayPoNoEdit: {
                required: "กรุณากรอกเลขงวด"
            },
            oetPayNameEdit: {
                required: "กรุณากรอกชื่องวด"
            },
            ocmPayPoStatusEdit: {
                required: "กรุณาเลือกสถานะ"
            },
            onbPayPoAmountEdit: {
                number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
                min: "กรุณากรอกจำนวนเงินไม่น้อยกว่า 0",
                max: "กรุณากรอกจำนวนเงินไม่เกินที่กำหนด"
            },
            oetPayPoDueDateEdit: {
                required: "กรุณาเลือกวันที่กำหนดชำระ"
            },
            otaPayPoDescEdit: {
                required: "กรุณากรอกรายละเอียดงวด"
            },
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
        submitHandler: function (ptPayFormEdit) {
            var oFormPayDataEdit = new FormData(ptPayFormEdit);
            $.ajax({
                url: $(ptPayFormEdit).attr('action'),
                type: 'POST',
                data: oFormPayDataEdit,
                processData: false,
                contentType: false,
                success: function (paResponse) {
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        location.reload();
                        // window.location.href = tUrlDocPOPageListView;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let aRes = JSON.parse(jqXHR.responseText);
                    if (aRes.rtStatus == 'error') {
                        alert(aRes.rtMessage);
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });

    $('#ofmPatAdd').validate({
        rules: {
            oetPatDate: {
                required: true
            },
            onbPatAmount: {
                required: true
            },
            ocmPatPyMethod: {
                required: true
            },
        },
        messages: {
            oetPatDate: {
                required: "กรุณาเลือกวันที่ชำระเงิน"
            },
            onbPatAmount: {
                number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
                min: "กรุณากรอกจำนวนเงินไม่น้อยกว่า 0",
                max: "กรุณากรอกจำนวนเงินไม่เกินที่กำหนด"
            },
            ocmPatPyMethod: {
                required: "กรุณาเลือกวิธีการชำระเงิน"
            },
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
        submitHandler: function (ptPatFormAdd) {
            var oFormPatDataAdd = new FormData(ptPatFormAdd);
            $.ajax({
                url: $(ptPatFormAdd).attr('action'),
                type: 'POST',
                data: oFormPatDataAdd,
                processData: false,
                contentType: false,
                success: function (paResponse) {
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        location.reload();
                        // window.location.href = tUrlDocPOPageListView;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let aRes = JSON.parse(jqXHR.responseText);
                    if (aRes.rtStatus == 'error') {
                        alert(aRes.rtMessage);
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });

    $('#ofmPoManday').validate({
        rules: {

        },
        messages: {
            
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
        submitHandler: function (ptPoFormEditManday) {
            var oFormPoDataManday = new FormData(ptPoFormEditManday);
            $.ajax({
                url: $(ptPoFormEditManday).attr('action'),
                type: 'POST',
                data: oFormPoDataManday,
                processData: false,
                contentType: false,
                success: function (paResponse) {
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        location.reload();
                        // window.location.href = tUrlDocPOPageListView;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let aRes = JSON.parse(jqXHR.responseText);
                    if (aRes.rtStatus == 'error') {
                        alert(aRes.rtMessage);
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });

    $('#ofmPoAddDoc').validate({
        rules: {
            ocmPoDocType: {
                required: true
            },
            oflPoDocFile: {
                required: true
            }
        },
        messages: {
            ocmPoDocType: {
                required: "กรุณาเลือกประเภทเอกสาร"
            },
            oflPoDocFile: {
                required: "กรุณาเลือกไฟล์"
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
        submitHandler: function (ptPoFormAddDoc) {
            var oFormPoDocData = new FormData(ptPoFormAddDoc);
            $.ajax({
                url: $(ptPoFormAddDoc).attr('action'),
                type: 'POST',
                data: oFormPoDocData,
                processData: false,
                contentType: false,
                success: function (paResponse) {
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        location.reload();
                        // window.location.href = tUrlDocPOPageListView;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let aRes = JSON.parse(jqXHR.responseText);
                    if (aRes.rtStatus == 'error') {
                        alert(aRes.rtMessage);
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });

    $('#ofmPoAddUrl').validate({
        rules: {
            oetPoUrlAddress: {
                required: true
            }
        },
        messages: {
            oetPoUrlAddress: {
                required: "กรุณากรอกที่อยู่ URL"
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
        submitHandler: function (ptPoFormAddUrl) {
            var oFormPoUrlData = new FormData(ptPoFormAddUrl);
            $.ajax({
                url: $(ptPoFormAddUrl).attr('action'),
                type: 'POST',
                data: oFormPoUrlData,
                processData: false,
                contentType: false,
                success: function (paResponse) {
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        location.reload();
                        // window.location.href = tUrlDocPOPageListView;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let aRes = JSON.parse(jqXHR.responseText);
                    if (aRes.rtStatus == 'error') {
                        alert(aRes.rtMessage);
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });

    $('#ofmPatEdit').validate({
        rules: {
            oetPatDateEdit: {
                required: true
            },
            onbPatAmountEdit: {
                required: true
            },
            ocmPatPyMethodEdit: {
                required: true
            },
        },
        messages: {
            oetPatDateEdit: {
                required: "กรุณาเลือกวันที่ชำระเงิน"
            },
            onbPatAmountEdit: {
                number: "กรุณากรอกเฉพาะตัวเลขเท่านั้น",
                min: "กรุณากรอกจำนวนเงินไม่น้อยกว่า 0",
                max: "กรุณากรอกจำนวนเงินไม่เกินที่กำหนด"
            },
            ocmPatPyMethodEdit: {
                required: "กรุณาเลือกวิธีการชำระเงิน"
            },
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
        submitHandler: function (ptPatFormEdit) {
            var oFormPatDataEdit = new FormData(ptPatFormEdit);
            $.ajax({
                url: $(ptPatFormEdit).attr('action'),
                type: 'POST',
                data: oFormPatDataEdit,
                processData: false,
                contentType: false,
                success: function (paResponse) {
                    let aRes = JSON.parse(paResponse);
                    if (aRes.rtStatus === 'success') {
                        alert('บันทึกข้อมูลสำเร็จ');
                        location.reload();
                        // window.location.href = tUrlDocPOPageListView;
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    let aRes = JSON.parse(jqXHR.responseText);
                    if (aRes.rtStatus == 'error') {
                        alert(aRes.rtMessage);
                    } else {
                        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + errorThrown);
                    }
                }
            });
        }
    });
    JStPOGetDataPay();
});

/**
 * Functionality : Popup confirm delete data
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : massage alert
 * Return Type : void
 */
$(document).on('click', '#obtPoDelDataDoc', function () {
    var nDocID = $(this).data('ndocid');
    var bIsConfirmed = confirm('คุณต้องการลบข้อมูลใช่หรือไม่?\nข้อมูลที่ถูกลบจะไม่สามารถกู้คืนได้!');
    if (bIsConfirmed) {
        JSxPODeleteDataDoc(nDocID);
    }
})

/**
 * Functionality : Popup confirm delete data
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : massage alert
 * Return Type : void
 */
$(document).on('click', '#obtPoDelDataUrl', function () {
    var nUrlID = $(this).data('nurlid');
    var bIsConfirmed = confirm('คุณต้องการลบข้อมูลใช่หรือไม่?\nข้อมูลที่ถูกลบจะไม่สามารถกู้คืนได้!');
    if (bIsConfirmed) {
        JSxPODeleteDataUrl(nUrlID);
    }
})

/**
 * Functionality : Popup confirm delete data
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : massage alert
 * Return Type : void
 */
$(document).on('click', '#obtDeletePay', function () {
    var tPayCode = $('#ohdPayCodeEdit').val()
    var bIsConfirmed = confirm('คุณต้องการลบข้อมูลใช่หรือไม่?\nข้อมูลที่ถูกลบจะไม่สามารถกู้คืนได้!');
    if (bIsConfirmed) {
        JSxPODeleteDataPay(tPayCode);
    }
})

/**
 * Functionality : Popup confirm delete data
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : massage alert
 * Return Type : void
 */
$(document).on('show.bs.tab', '#obtPoInfoTab, #obtPoMandayTab, #obtPoAttachDocTab, #oahBtnBack', function (e) {
    let nPoValue = Number($('#ohdPoValue').val());
    let nPayAmount = Number($('#ohdPayAmount').val());

    let nFormatPoValue = nPoValue.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    let nFormatPayAmount = nPayAmount.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    let activeTab = localStorage.getItem('activeTab');

    if(nPoValue != nPayAmount && activeTab == '#odvPoPaymentPanel'){
        // บล็อกไม่ให้เปลี่ยน tab จริง ๆ
        e.preventDefault();
        alert('มูลค่ารวมงวดชำระเงิน('+nFormatPayAmount+') ยังไม่ตรงมูลค่าPO('+nFormatPoValue+')');
    }
})

/**
 * Functionality : Popup confirm delete data
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : massage alert
 * Return Type : void
 */
$(document).on('click', '#oahBtnBack', function (e) {
    let nPoValue = Number($('#ohdPoValue').val());
    let nPayAmount = Number($('#ohdPayAmount').val());

    let nFormatPoValue = nPoValue.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    let nFormatPayAmount = nPayAmount.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    let activeTab = localStorage.getItem('activeTab');

    if(nPoValue != nPayAmount && activeTab == '#odvPoPaymentPanel'){
        // บล็อกไม่ให้เปลี่ยน tab จริง ๆ
        alert('มูลค่ารวมงวดชำระเงิน('+nFormatPayAmount+') ยังไม่ตรงมูลค่าPO('+nFormatPoValue+')');
    }else if(nPoValue == nPayAmount){
        window.location.href = tUrlDocPOPageListView;
    }
})

/**
 * Functionality : Check file size before upload
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : alert message
 * Return Type : void
 */
function JSxPOCheckFileSize() {
    const oFileInput = document.getElementById("oflPoFile");
    const nFileSize = oFileInput.files[0].size / 1024 / 1024; // แปลงหน่วยจาก Bytes เป็น MB
    if (nFileSize > 5) {
        alert("ขนาดไฟล์ต้องไม่เกิน 5 MB");
        oFileInput.value = ""; // เคลียร์ค่าออกจาก input
    }
}

/**
 * Functionality : Remove file from UI and create hidden input for server
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 */
function JSxPORemoveFile() {
    // ลบไฟล์ที่แสดงในหน้า UI
    const oFilePreview = document.getElementById("odvPoFilePreview");
    if (oFilePreview) {
        oFilePreview.remove();
    }

    // สร้าง hidden input เพื่อแจ้งให้ server รู้ว่าต้องการลบไฟล์
    const deleteFileInput = document.createElement("input");
    deleteFileInput.type = "hidden";
    deleteFileInput.name = "ohdPoDeleteFile";
    deleteFileInput.value = "1";
    document.getElementById("oflPoFile").closest("form").appendChild(deleteFileInput);
}

/**
 * Functionality : Remove file from UI and create hidden input for server
 * Parameters : -
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 */
const inputs = document.querySelectorAll('.form-input');
    inputs.forEach((input, index) => {
        input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // ป้องกัน Enter ส่งฟอร์มก่อนเวลา
            if (index + 1 < inputs.length) {
                inputs[index + 1].focus(); // ไปที่ input ถัดไป
            } else {
                $('#obtMDSubmit').click() // ส่งฟอร์มเมื่อถึง input สุดท้าย
            }
        }
        });
    });

/**
 * Functionality : Get Data Pay from server
 * Parameters : -
 * Creator : 09/04/2025 Wuttichai
 * Last Modified :
 * Return : Text in HTML format of table data
 * Return Type : string
 */
function JStPOGetDataPay() {
    var tPayPoCode = $('#ohdPoCode').val();
    $.ajax({
        type: "POST",
        url: tUrlDocPOGetDataPay,
        data: {
            tPayPoCode: tPayPoCode
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $("#odvPoPayList").html(tResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        }
    });
}

function JStPOModalEditPay(tPayCode){
    $('#odvModalEditPay').modal('show')
    $.ajax({
        type: "POST",
        url: tUrlDocPOGetDataPayEdit,
        data: {
            tPayCode: tPayCode
        },
        cache: false,
        timeout: 0,
        dataType: 'json',
        success: function (res){ //STD Type data res nPatDataCount
            let nAmount = parseFloat(res.nSumPoAmount - res.nSumPayAmount)
            let nFormatAmount = nAmount.toLocaleString('en-US',{
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })
            
            $('#obpLimitAmountEdit').text('จำนวนเงินสูงสุดที่กรอกได้ ' + nFormatAmount)
            $('#onbPayPoAmountEdit').prop('max', nAmount);

            if(res.nPatDataCount > 0){
                $('#obtDeletePay').hide();
            }
            let aRes = res.aPayData;
            
            let dPayDueDate = new Date(aRes.FDPayDueDate);
            let tDay = String(dPayDueDate.getDate()).padStart(2, '0');
            let tMonth = String(dPayDueDate.getMonth() + 1).padStart(2, '0');
            let tYear = dPayDueDate.getFullYear();
            let dformatDate = `${tDay}/${tMonth}/${tYear}`;

            $('#ohdPayCodeEdit').val(aRes.FTPayCode);
            $('#oetPayNameEdit').val(aRes.FTPayName);
            $('#onbPayPoNoEdit').val(aRes.FNPayNo);
            $('#otaPayPoDescEdit').val(aRes.FTPayDesc);
            $('#onbPayPoAmountEdit').val(aRes.FCPayAmount);
            $('#oetPayPoDueDateEdit').val(dformatDate);
            $('#ocmPayPoStatusEdit').val(aRes.FTPayStatus);
            
            JStPOGetDataPat(tPayCode)
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        }
    });
}

/**
 * Functionality : Get Data Pay from server
 * Parameters : -
 * Creator : 09/04/2025 Wuttichai
 * Last Modified :
 * Return : Text in HTML format of table data
 * Return Type : string
 */
function JStPOGetDataPat(tPayCode) {
    $.ajax({
        type: "POST",
        url: tUrlDocPOGetDataPat,
        data: {
            tPayCode: tPayCode
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $("#odvPoPatInfo").html(tResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        }
    });
}

function JSxPOModalAddPat(tPayCode,nPayNo,tPayName,cPayAmount,dPayDueDate){
    $('#odvModalAddPat').modal('show');
    $('#ohdPatPayCode').val(tPayCode)
    $('#obhPoTitleModalAddPat').html('บันทึกการชำระเงิน - งวดที่ '+nPayNo)
    $('#ospPoPeriodNo').html(nPayNo+' - '+tPayName)
    let cformatAmount = cPayAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    $('#ospPoPeriodAmount').html(cformatAmount+' บาท')

    let dDate = new Date(dPayDueDate);
    let tDay = String(dDate.getDate()).padStart(2, '0');
    let tMonth = String(dDate.getMonth() + 1).padStart(2, '0');
    let tYear = dDate.getFullYear();
    let dformatDate = `${tDay}/${tMonth}/${tYear}`;

    $('#ospPoPeriodDueDate').html(dformatDate)
    $('#onbPatAmount').prop('max', cPayAmount);
    $('#obpLimitPatAmount').text('จำนวนเงินสูงสุดที่กรอกได้ ' + cformatAmount)
}

function JSxPOModalEditPat(tPatCode,nPayNo,tPayName,cPayAmount,dPayDueDate){
    $('#odvModalEditPat').modal('show');
    $('#ohdPatCodeEdit').val(tPatCode)
    $('#obhPoTitleModalEditPat').html('บันทึกการชำระเงิน - งวดที่ '+nPayNo)
    $('#ospPoPeriodNoEdit').html(nPayNo+' - '+tPayName)
    let cformatAmount = cPayAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    $('#ospPoPeriodAmountEdit').html(cformatAmount+' บาท')

    let dDate = new Date(dPayDueDate);
    let tDay = String(dDate.getDate()).padStart(2, '0');
    let tMonth = String(dDate.getMonth() + 1).padStart(2, '0');
    let tYear = dDate.getFullYear();
    let dformatDate = `${tDay}/${tMonth}/${tYear}`;

    $('#ospPoPeriodDueDateEdit').html(dformatDate)
    $('#onbPatAmountEdit').prop('max', cPayAmount);

    $.ajax({
        type: "POST",
        url: tUrlDocPOGetDataPatEdit,
        data: {
            tPatCode: tPatCode
        },
        cache: false,
        timeout: 0,
        dataType: 'json',
        success: function (res){
            // console.log(res)
            let aRes = res.aPatData;

            let dPatDate = new Date(aRes.FDPatDate);
            let tDay = String(dPatDate.getDate()).padStart(2, '0');
            let tMonth = String(dPatDate.getMonth() + 1).padStart(2, '0');
            let tYear = dPatDate.getFullYear();
            let dformatDate = `${tDay}/${tMonth}/${tYear}`;

            $('#oetPatDateEdit').val(dformatDate)
            $('#onbPatAmountEdit').val(aRes.FCPatAmount)
            $('#ocmPatPyMethodEdit').val(aRes.FTPatPaymethod)
            $('#oetPatRefNoEdit').val(aRes.FTPatRefNo)
            $('#otaPatDescEdit').val(aRes.FTPatDesc)
            if(aRes.FTPatFile){
                $('#obpPoPatFilePreview').html('ไฟล์ที่แนบอยู่: '+res.link)
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        }
    });
}

function JSxPOCalTotalManday(){
    let nMDDev = Number($('#onbPoMDDev').val());//float
    let nMDTester = Number($('#onbPoMDTester').val());
    let nMDSA = Number($('#onbPoMDSA').val());
    let nMDPM = Number($('#onbPoMDPM').val());
    let nMDInterface = Number($('#onbPoMDInterface').val());
    let nMDTotal = nMDDev + nMDTester + nMDSA + nMDPM + nMDInterface;

    $('#onbPoMDTotal').val(nMDTotal)
}

/**
 * Functionality : Delete data
 * Parameters : ptPoCode
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 * */
function JSxPODeleteDataDoc(ptDocID) {
    $.ajax({
        type: "POST",
        url: tUrlPODeleteDataDocID,
        data: {
            'tDocID': ptDocID
        },
        success: function (paResponse) {
            let aRes = JSON.parse(paResponse);
            if (aRes.rtStatus === 'success') {
                alert(aRes.rtMessage);
                location.reload();
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
 * Functionality : Delete data
 * Parameters : ptPoCode
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 * */
function JSxPODeleteDataUrl(ptUrlID) {
    $.ajax({
        type: "POST",
        url: tUrlPODeleteDataUrlID,
        data: {
            'tUrlID': ptUrlID
        },
        success: function (paResponse) {
            let aRes = JSON.parse(paResponse);
            if (aRes.rtStatus === 'success') {
                alert(aRes.rtMessage);
                location.reload();
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
 * Functionality : Delete data Pay
 * Parameters : ptPayCode
 * Creator : 15/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 * */
function JSxPODeleteDataPay(ptPayCode) {
    $.ajax({
        type: "POST",
        url: tUrlPODeleteDataPay,
        data: {
            'tPayCode': ptPayCode
        },
        success: function (paResponse) {
            let aRes = JSON.parse(paResponse);
            if (aRes.rtStatus === 'success') {
                alert(aRes.rtMessage);
                location.reload();
            } else {
                alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาด: ' + errorThrown);
        }
    });
}

function JSxPOLastNoRunningPay(nPoValue){
    let tPoCode = $('#ohdPoCode').val()
    $.ajax({
        type: "POST",
        url: tUrlPOLastPayNo,
        data: {
            tPoCode: tPoCode
        },
        success: function (paResponse) {
            let aRes = JSON.parse(paResponse);
            let nAmount = parseFloat(nPoValue - aRes.nSumPayAmount)
            let nFormatAmount = nAmount.toLocaleString('en-US',{
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })
            
            $('#obpLimitAmount').text('จำนวนเงินสูงสุดที่กรอกได้ ' + nFormatAmount)
            $('#onbPayPoAmount').prop('max', nAmount);
            $('#onbPayPoNo').val(aRes.aPayNo);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาด: ' + errorThrown);
        }
    });
}