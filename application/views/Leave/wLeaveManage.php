<?php include(APPPATH . 'views/wHeader.php') ?>

<style>
.Titlebar {
    padding: 10px;
    color: #ffffff;
}

.active {
    color: blue !important;
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

    <?php include(APPPATH. 'views/menu/wMenu.php') ?>
    <div class="container-fluid" style="margin-top:10px">
        <div class="row" style="margin-top:15px">
            <div class="col-md-12">
                <table width="100%">
                    <tr>
                        <td width="10%">แผนก
                            <div class="input-group mb-3">
                                <?php foreach($aLeaveDPMList['raItems'] as $DPM) { ?>
                                <input type="text" class="form-control" readonly
                                    value="<?php echo $aLeaveDPMList['raItems'][0]['FTDepName']; ?>"
                                    style="background-color: #f0f0f0;">
                                <?php } ?>
                            </div>
                        </td>
                        <td width="5%">ทีม
                            <div class="input-group mb-3">
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
                        </td>
                        <td width="8%">ชื่อ-สกุล
                            <div class="input-group mb-3">
                                <select class="selectpicker border rounded w-100 form-control form-select"
                                    data-live-search="true" name="ocmNameSearch" id="ocmNameSearch">
                                    <option selected="selected" value="">ทั้งหมด</option>
                                    <?php foreach ($aLeaveNameList["raItems"] as $tName) { ?>
                                    <option value="<?php echo $tName["FTDevCode"]; ?>">
                                        <?php echo $tName["FTDevName"]; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </td>

                        <td width="8%">ประเภทการลา
                            <div class="input-group mb-3">
                                <select id="ocmTypeSearch" name="ocmTypeSearch"
                                    class="selectpicker border rounded w-100 form-control form-select"
                                    data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($aLeaveTypeList["raItems"] as $key0 => $val0) { ?>
                                    <option value="<?php echo $val0["FTLvtCode"]; ?>"><?php echo $val0["FTLvtName"]; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </td>
                        <td width="5%">สถานะ
                            <div class="input-group mb-3">
                                <select id="ocmStatusSearch" name="ocmStatusSearch"
                                    class="selectpicker border rounded  w-100" data-live-search="true"
                                    style="background-color: white;">
                                    <option value="">ทั้งหมด</option>
                                    <option value="1" selected>รออนุมัติ</option>
                                    <option value="2">อนุมัติ</option>
                                    <option value="3">ยกเลิก</option>
                                    <option value="4">ไม่อนุมัติ</option>
                                </select>
                            </div>
                        </td>

                        <td width="8%"> จากวันที่ลา
                            <div class="input-group mb-3">
                                <input type="text" id="odpLeaveStartDate" class="datepicker form-control"
                                    placeholder="dd/mm/yyyy" readonly style="background-color: #ffffff;">
                                <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                            </div>
                        </td>

                        <td width="8%"> ถึงวันที่
                            <div class="input-group mb-3">
                                <input type="text" id="odpLeaveEndDate" class="datepicker form-control"
                                    placeholder="dd/mm/yyyy" readonly style="background-color: #ffffff;">
                                <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                            </div>
                        </td>

                        <td width="10%">
                            <div class="col-md-2 text-right" style="text-align:right; margin-top:5px; margin-left:3px;">
                                <button class="btn btn-primary btn-m" type="button"
                                    onclick="JSxLEVFilterDataManage()">ค้นหา</button>
                            </div>
                        </td>

                    </tr>
                </table>
            </div>
        </div>

        <div class="row" style="margin-top:10px" id="odvLeaveManageList">
        </div>

        <div>
            <input type="hidden" id="oetFilterLSMPage" value="1">
        </div>
    </div>
    <!-- Jquery  -->
    <!-- <script>
    document.getElementById("ocmStatusSearch").addEventListener("change", function() {
        JSxLEVGetLeaveManageList();
    });
    document.getElementById("ocmTypeSearch").addEventListener("change", function() {
        JSxLEVGetLeaveManageList();
    });
    document.getElementById("ocmNameSearch").addEventListener("change", function() {
        JSxLEVGetLeaveManageList();
    });
    document.getElementById("ocmTeamSearch").addEventListener("change", function() {
        JSxLEVGetLeaveManageList();
    });
    </script> -->

    <script>
    $(document).ready(function() {
        JSxLEVGetLeaveManageList();
    });

    function JSxLEVFilterDataManage() {
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
        $("#oetFilterLSMPage").val(1);
        JSxLEVGetLeaveManageList();
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
    function JSxLEVFilterDataManage() {
        var dStartDate = $("#odpLeaveStartDate").datepicker("getDate");
        var dEndDate = $("#odpLeaveEndDate").datepicker("getDate");
        if (dStartDate !== null && dEndDate !== null) {
            if (dStartDate > dEndDate) {
                alert('วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุด');
                // $("#odpLeaveStartDate, #odpLeaveEndDate").datepicker('setDate', new Date());
                //กรณีที่มีการ วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุด ทำการ Reset วันเป็นวัน ปัจจุบันทั้ง 2 ฟิลด์
                return;
            }
            if (dEndDate < dStartDate) {
                alert('วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น');
                // $("#odpLeaveStartDate, #odpLeaveEndDate").datepicker('setDate', new Date());
                //กรณีที่มีการ วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุด ทำการ Reset วันเป็นวัน ปัจจุบันทั้ง 2 ฟิลด์
                return;
            }
        }
        $("#oetFilterLSMPage").val(1);
        JSxLEVGetLeaveManageList();
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
                    var dateArray = $(this).val().split("/");
                    var formattedDate = dateArray[0].padStart(2, '0') + "/" + dateArray[1].padStart(
                        2, '0') + "/" + dateArray[2];
                    $(this).val(formattedDate);
                }
            }
        });
    });
    function JSxLEVGetLeaveManageList() {
        var nStatus = $("#ocmStatusSearch").val();
        var tType = $("#ocmTypeSearch").val();
        var tName = $("#ocmNameSearch").val();
        var tTeam = $("#ocmTeamSearch").val();
        var dStartDate = moment($("#odpLeaveStartDate").datepicker("getDate")).format("DD/MM/YYYY");
        var dEndDate = moment($("#odpLeaveEndDate").datepicker("getDate")).format("DD/MM/YYYY");
        var nPage = $("#oetFilterLSMPage").val();

        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/masLEVLeaveManageList') ?>",
            data: {
                "nStatus": nStatus,
                "tType": tType,
                "tName": tName,
                "tTeam": tTeam,
                "dStartDate": dStartDate,
                "dEndDate": dEndDate,
                "nPage": nPage

            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvLeaveManageList").html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                console.log(jqXHR);
            }
        });
    }



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
                        $('#ocmNameSearch').html(response);
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
                        $('#ocmNameSearch').html(response);
                        $('#ocmNameSearch').selectpicker('refresh');
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
