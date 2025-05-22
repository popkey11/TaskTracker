<?php include(APPPATH . 'views/wHeader.php') ?>

<style>
    .Titlebar {
        padding: 10px;
        color: #ffffff;
    }

    .active {
        color: blue !important;
    }

    .datepicker.datepicker-dropdown {
        max-width: none;
        width: auto;
        left: auto;
    }

    .ui-datepicker-trigger {
        background-image: url('/assets/Date.png');
        background-position: center right;
        background-repeat: no-repeat;
        border: 2px solid #227574;
        width: 30px;
        height: 30px;
    }

    .ui-datepicker {
        z-index: 9999 !important;
    }

    .status-box {
        padding: 3px 3px;
        border-radius: 7px;
        vertical-align: middle;
        /* จัดกึ่งกลางในแนวตั้ง */
        text-align: center;
        /* จัดกึ่งกลางในแนวนอน */
    }

    .status-yellow {
        background-color: #ffc107;
        color: #000;
    }

    .status-green {
        background-color: #28a745;
        color: #fff;
    }

    .status-red {
        background-color: #dc3545;
        color: #fff;
    }

    .Type-ocean {
        background-color: #66CC99;
        color: #fff;
    }

    .Type-crimson {
        background-color: #CC6666;
        color: #fff;
    }

    .status-unknown {
        background-color: #6c757d;
        color: #fff;
    }

    .red-text {
        color: red;
    }

    .readonly-input {
        background-color: #ffffff;
    }

    .bootstrap-select .btn {
        background-color: #ffffff;
        border-color: none;
    }

    .bootstrap-select .filter-option {
        color: #000000;
    }

    .bootstrap-select .btn:focus,
    .bootstrap-select .btn.active {
        background-color: #ffffff;
    }

    .bootstrap-select .btn.dropdown-toggle {
        color: #000000;
    }
</style>
<html>
<title>
    <?= $tTitle ?>
</title>

<body>
    <img src="<?php echo base_url('/assets/WorkingBg.png'); ?>" style="opacity: 0.2; position: absolute;
    right: 0px;
    bottom: 0px; width: 50%; z-index:-10000"></img>


    <?php include(APPPATH . 'views/menu/wMenu.php') ?>

    <div class="container-fluid" style="margin-top:10px">
        <div class="row" style="margin-top:15px">
            <div class="col-md-10">
                <table>
                    <tr>

                        <td width="13%">แผนก
                            <div class="input-group mb-3">
                                <?php foreach ($aLeaveDPMList['raItems'] as $DPM) { ?>
                                    <input type="text" class="form-control" readonly
                                        value="<?php echo $aLeaveDPMList['raItems'][0]['FTDepName']; ?>"
                                        style="background-color: #f0f0f0;">
                                <?php } ?>
                            </div>
                        </td>
                        <td width="8%">ประเภทการลา
                            <div class="input-group mb-3">
                                <select id="ocmTypeSearch" name="ocmTypeSearch"
                                    class="selectpicker border rounded w-100" data-live-search="true" required>
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($aLeaveTypeList["raItems"] as $tType) { ?>
                                        <option value="<?php echo $tType["FTLvtCode"]; ?>">
                                            <?php echo $tType["FTLvtName"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </td>
                        <td width="8%">สถานะ
                            <div class="input-group mb-3">
                                <select id="ocmStatusSearch" name="ocmStatusSearch"
                                    class="selectpicker border rounded w-100" data-live-search="true" required>
                                    <option value="">ทั้งหมด</option>
                                    <option value="1">รออนุมัติ</option>
                                    <option value="2">อนุมัติ</option>
                                    <option value="3">ยกเลิก</option>
                                    <option value="4">ไม่อนุมัติ</option>
                                </select>
                            </div>
                        </td>

                        <td width="12%"> จากวันที่ลา
                            <div class="input-group mb-3">
                                <input type="text" id="odpLeaveStartDate" class="datepicker form-control"
                                    placeholder="dd/mm/yyyy" readonly style="background-color: #ffffff;">
                                <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                            </div>
                        </td>
                        <td width="12%"> ถึงวันที่
                            <div class="input-group mb-3">
                                <input type="text" id="odpLeaveEndDate" class="datepicker form-control"
                                    placeholder="dd/mm/yyyy" readonly style="background-color: #ffffff;">
                                <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                            </div>
                        </td>
                        <td width="20%">
                            <div class="col-md-2 text-right" style="text-align:right; margin-top:5px; margin-left:3px;">
                                <button class="btn btn-primary btn-m" type="button"
                                    onclick="JSxLEVFilterData()">ค้นหา</button>
                            </div>
                        </td>
                        <td width="3%" style="">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-2 text-right" style="text-align:right; margin-top:20px;">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#odvAddModal"
                    id="obtAddLeave" onclick="JSxLEVResetAddModal()"><b>+ เพิ่มการลา</b></button>

            </div>
        </div>
        <div class="row" style="margin-top:10px" id="odvLeaveList">
        </div>
        <div>
            <input type="hidden" id="oetFilterLSPage" value="1">
        </div>
    </div>
    <div class="modal fade" id="odvAddModal" tabindex="-1" aria-labelledby="olaAddModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="olaAddModal">เพิ่มการลา</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="ofmFormCreateLeave" enctype="multipart/form-data">
                        <?php if ($tUsrAdminCheck): ?>
                            <label for="ocmLSAddType" class="form-label"><span class="red-text">*</span>&nbsp;สำหรับฝ่ายบุคคล</label>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="ocmLSAddProvince" class="form-label"><span
                                                    class="red-text"></span>&nbsp;ทีม</label>
                                            <select name="ocmTeamSearch" id="ocmTeamSearch"
                                                class="selectpicker border rounded w-100 form-control form-select"
                                                data-live-search="true">
                                                <option value="">ทั้งหมด</option>
                                                <?php foreach ($aLeaveTeamList["raItems"] as $tTeam) { ?>
                                                    <option value="<?php echo $tTeam["FTDevGrpTeam"]; ?>">
                                                        <?php echo $tTeam["FTDevGrpTeam"]; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="oetLSAddDayQty" class="form-label"><span
                                                    class="red-text"></span>&nbsp;ชื่อ-สกุล</label>
                                            <select class="selectpicker border rounded w-100 form-control form-select"
                                                data-live-search="true" name="ocmAddNameHr" id="ocmAddNameHr">
                                                <option selected="selected" value="">ทั้งหมด</option>
                                                <?php foreach ($aLeaveNameList["raItems"] as $tName) { ?>
                                                    <option value="<?php echo $tName["FTDevCode"]; ?>">
                                                        <?php echo $tName["FTDevName"]; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-2">
                            <label for="ocmLSAddType" class="form-label"><span
                                    class="red-text">*</span>&nbsp;ประเภทการลา</label>
                            <select class="form-control" id="ocmLSAddType" name="ocmLSAddType" data-live-search="true"
                                required>
                                <option value="">กรุณาเลือกประเภทลา</option>
                                <?php foreach ($aLeaveTypeList['raItems'] as $aType) { ?>
                                    <option value="<?php echo $aType['FTLvtCode']; ?>"><?php echo $aType['FTLvtName']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="odpLSAddDateFrom" class="form-label"><span
                                            class="red-text">*</span>&nbsp;วันที่เริ่มต้น</label>
                                    <div class="input-group">
                                        <input type="hidden" id="odpLSAddDateFromHidden" name="odpLSAddDateFromHidden">
                                        <input type="text" id="odpLSAddDateFrom" class="datepicker form-control"
                                            placeholder="dd/mm/yyyy" readonly style="background-color: #ffffff;">
                                        <span class="input-group-text bg-light"><i
                                                class="fa-regular fa-calendar-days"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="odpLSAddDateTo" class="form-label"><span
                                            class="red-text">*</span>&nbsp;วันที่สิ้นสุด</label>
                                    <div class="input-group">
                                        <input type="hidden" id="odpLSAddDateToHidden" name="odpLSAddDateToHidden">
                                        <input type="text" id="odpLSAddDateTo" class="datepicker form-control"
                                            placeholder="dd/mm/yyyy" readonly style="background-color: #ffffff;">
                                        <span class="input-group-text bg-light"><i
                                                class="fa-regular fa-calendar-days"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="ocmLSAddProvince" class="form-label"><span
                                            class="red-text">*</span>&nbsp;จังหวัด</label>
                                    <select class="selectpicker border rounded w-100" id="ocmLSAddProvince"
                                        name="ocmLSAddProvince" data-live-search="true" required>
                                        <option value="">กรุณาเลือกจังหวัด</option>
                                        <?php foreach ($aLeavePvnList['raItems'] as $aProvince) { ?>
                                            <option value="<?php echo $aProvince['FTPvnCode']; ?>">
                                                <?php echo $aProvince['FTPvnName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="oetLSAddDayQty" class="form-label"><span
                                            class="red-text">*</span>&nbsp;ระบุจำนวนวัน</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="" id="oetLSAddDayQty"
                                            name="oetLSAddDayQty">
                                        <span class="input-group-text">วัน</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="otaLSAddRemark" class="col-form-label"><span
                                    class="red-text">*</span>&nbsp;ระบุเหตุผล</label>
                            <textarea class="form-control" id="otaLSAddRemark" name="otaLSAddRemark"
                                placeholder="กรุณาระบุเหตุผล" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="oflAttachment" class="form-label">ไฟล์แนบ</label>
                            <input class="form-control" type="file" id="oflAttachment" name="oflAttachment"
                                accept=".gif, .jpg, .jpeg, .png, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf">
                        </div>
                        <div class="mb-3"></div>
                        <br>
                        <br>
                        <div class="d-flex justify-content-end">
                            <div>
                                <button type="button" class="btn btn-outline-dark"
                                    onclick="JSxLEVResetAddModal()">ล้างข้อมูล</button>
                                <button type="submit" class="btn btn-primary">บันทึกการลา</button>
                            </div>
                        </div>


                </div>
                </form>

            </div>
        </div>
    </div>
    </div>


    <!-- <script>
    document.getElementById("ocmStatusSearch").addEventListener("change", function() {
        JSxLEVGetLeaveList();
    });
    document.getElementById("ocmTypeSearch").addEventListener("change", function() {
        JSxLEVGetLeaveList();
    });
    </script> -->

    <script>
        $(document).ready(function() {
            JSxLEVGetLeaveList();
        });

        function JSxLEVFilterData() {
            var dStartDate = $("#odpLeaveStartDate").datepicker("getDate");
            var dEndDate = $("#odpLeaveEndDate").datepicker("getDate");

            if (dStartDate !== null && dEndDate !== null) {
                if (dStartDate > dEndDate) {
                    alert('วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุด');
                    return;
                }
                if (dEndDate < dStartDate) {
                    alert('วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น');
                    return;
                }
            }

            $("#oetFilterLSPage").val(1);
            JSxLEVGetLeaveList();
        }

        $(function() {
            var dateBefore = null;
            $(".datepicker").datepicker({
                setDate: new Date(),
                dateFormat: 'dd/mm/yy',
                buttonImageOnly: true,
                dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
                monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                ],
                changeMonth: true,
                changeYear: true,
                onClose: function() {
                    if ($(this).val() != "" && $(this).val() == dateBefore) {
                        var arrayDate = dateBefore.split("-");
                        arrayDate[2] = parseInt(arrayDate[2]) + 543;
                        $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
                    }
                }
            });

        });


        function JSxLEVGetLeaveList() {
            var nStatus = $("#ocmStatusSearch").val();
            var tType = $("#ocmTypeSearch").val();
            var dStartDate = $("#odpLeaveStartDate").datepicker("getDate");
            var dEndDate = $("#odpLeaveEndDate").datepicker("getDate");
            var nPage = $("#oetFilterLSPage").val();

            $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/masLEVLeaveList') ?>",
                data: {
                    "nStatus": nStatus,
                    "tType": tType,
                    "dStartDate": dStartDate,
                    "dEndDate": dEndDate,
                    "nPage": nPage
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $("#odvLeaveList").html(tResult);


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');

                }

            });
        }

        function JSxLEVCancleLeave(FTLvhCode, FTDevCode) {
            if (confirm("ยืนยันยกเลิกการลางานที่เลือกใช่หรือไม่?")) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('index.php/masLEVEventLeaveEmployeeCancle') ?>",
                    data: {
                        "FTLvhCode": FTLvhCode,
                        "FTDevCode": FTDevCode
                    },

                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        JSxLEVGetLeaveList();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                });
            }
        }

        function JSxLEVResetAddModal() {
            document.getElementById("ofmFormCreateLeave").reset();
            $("#odpLSAddDateFrom, #odpLSAddDateTo").datepicker('setDate', new Date());
            $('#odpLSAddDateFromHidden').val($('#odpLSAddDateFrom').val());
            $('#odpLSAddDateToHidden').val($('#odpLSAddDateTo').val());
            $('#ocmLSAddProvince').selectpicker('refresh');
        }
    </script>

    <script>
        $(document).ready(function() {
            var oAddStartDateFrom;
            var oAddEndDateTo;
            $('#odpLSAddDateFrom').change(function() {
                $('#odpLSAddDateFromHidden').val($(this).val());
                calculateDays();
            });
            $('#odpLSAddDateTo').change(function() {
                $('#odpLSAddDateToHidden').val($(this).val());
                calculateDays();
            });
            let aHolidays = localStorage.getItem('aHoliday');
            if (aHolidays === null) {
                fetch('<?= base_url('index.php/eventGetHoliday') ?>')
                    .then(response => response.json())
                    .then(data => {
                        localStorage.setItem('aHoliday', JSON.stringify(data['raItems']));
                        aHolidays = localStorage.getItem('aHoliday');
                    });
            }
            $('#odpLSAddDateFrom').change(function() {
                var startDate = new Date($(this).val());
                var endDate = new Date($('#odpLSAddDateTo').val());
                if (startDate > endDate) {
                    alert('วันที่เริ่มต้นต้องไม่น้อยกว่าวันที่สิ้นสุด');
                    $(this).val('');
                }
            });
            $('#odpLSAddDateTo').change(function() {
                var startDate = new Date($('#odpLSAddDateFrom').val());
                var endDate = new Date($(this).val());
                if (startDate > endDate) {
                    alert('วันที่เริ่มต้นต้องไม่น้อยกว่าวันที่สิ้นสุด');
                    $(this).val('');
                }
            });

            function calculateDays() {
                var startDateString = $('#odpLSAddDateFrom').val();
                var endDateString = $('#odpLSAddDateTo').val();
                var startDate = moment(startDateString, 'DD/MM/YYYY');
                var endDate = moment(endDateString, 'DD/MM/YYYY');
                let days = 0;
                while (startDate <= endDate) {
                    if (startDate.day() !== 0 && startDate.day() !== 6 && !aHolidays.includes(startDate.format('YYYY-MM-DD'))) {
                        // not Sunday or Saturday
                        days++;
                    }
                    startDate = startDate.clone().add(1, 'd');
                }


                var diffInDays = days;
                $('#oetLSAddDayQty').val(diffInDays);
                if (diffInDays < 0.5) {
                    $('#oetLSAddDayQty').val(1);
                }
                oAddStartDateFrom = $('#odpLSAddDateFromHidden').val();
                oAddEndDateTo = $('#odpLSAddDateToHidden').val();
            }
            $('#odvAddModal').on('shown.bs.modal', function() {
                calculateDays();
            });
            $('#ofmFormCreateLeave').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                const oAddStartDateFrom = moment($('#odpLSUpdateDateFrom').val(), 'DD/MM/YYYY');
                const oAddEndDateTo = moment($('#odpLSUpdateDateTo').val(), 'DD/MM/YYYY');
                if (oAddStartDateFrom.isValid() && oAddEndDateTo.isValid()) {
                    if (oAddStartDateFrom.isAfter(oAddEndDateTo)) {
                        alert('กรุณาระบุวันลาใหม่ โดยวันที่เริ่มต้นห้ามมากกว่าวันที่สิ้นสุด');
                    } else if (oAddStartDateFrom <= oAddEndDateTo) {
                        if (confirm("ต้องการบันทึกการลางานใช่หรือไม่ ?")) {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url('/index.php/masLEVEventLeaveAdd'); ?>",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    var jsonData = JSON.parse(data);
                                    if (jsonData['rtCode'] == 800) {
                                        alert(jsonData['rtDesc']);
                                    } else {
                                        $("#odvAddModal").modal('hide');
                                        $(".modal-backdrop").remove();
                                        JSxLEVGetLeaveList();
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    alert(jqXHR.responseText);
                                }
                            });
                        }
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#ocmTeamSearch').change(function() {
                var selectedTeam = $(this).val();
                console.log(selectedTeam);
                if (selectedTeam !== '') {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('/index.php/masLEVEventGetEmployeeByTeam') ?>",
                        data: {
                            "selectedTeam": selectedTeam
                        },
                        success: function(response) {
                            console.log(response);
                            $('#ocmAddNameHr').html(response);
                            $('.selectpicker').selectpicker('refresh');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('เกิดข้อผิดพลาดในการดึงข้อมูลพนักงาน');
                            console.log(jqXHR);
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('/index.php/masLEVEventGetAllEmployee') ?>",
                        success: function(response) {
                            $('#ocmAddNameHr').html(response);
                            $('#ocmAddNameHr').selectpicker('refresh');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('เกิดข้อผิดพลาดในการดึงข้อมูลพนักงาน');
                            console.log(jqXHR);
                        }
                    });
                }
            });
        });
    </script>






</body>

</html>