<style>
.xSEmpDeleted {
    color: red !important;
}

.custom-button {
    width: 70px;
    height: 28px;
    background-color: #006666;
    color: #FFFFFF;
}

.xSEmpActive {
    color: #000000 !important;
}
</style>
<div class="col-md-12">

    <?php
function JSdLEVCalculateTotalDays($dateFrom, $dateTo) {
    $start = new DateTime($dateFrom);
    $end = new DateTime($dateTo);
    $interval = $start->diff($end);
    return $interval->days + 1; // +1 เพื่อรวมวันสุดท้าย
}
?>


    <table class="table table-sm">
        <thead>
            <tr>
                <th class="text-center">วันที่ทำรายการ</th>
                <th class="text-left">ชื่อ-สกุล</th>
                <th class="text-left">ทีม</th>
                <th class="text-left">ประเภทการลา</th>
                <th class="text-center">จากวันที่ลา</th>
                <th class="text-center">ถึงวันที่</th>
                <th class="text-center">รวมวัน</th>
                <th class="text-left">&nbspสถานะ</th>
                <th class="text-left">ดำเนินการโดย</th>
                <th class="text-left"></th>
                <th class="text-left"></th>
                <th class="text-left"></th>
                <th class="text-left"></th>

            </tr>
        </thead>
        <tbody>
            <?php
            if ($aLeaveManageList['rtCode'] == '200') {
                foreach ($aLeaveManageList["raItems"] as $key0 => $val0) {
                    $tDevCode = $val0["FTLvhDevCode"];
                    $tFTLvhCode = $val0["FTLvhCode"];
                    if ($tFTLvhCode == 'DELETE') {
                        $tDeleted = "xSLSDeleted";
                    } else {
                        $tDeleted = "xSLSActive";
                    }
            ?>
            </td>
            <td class="text-center" style="vertical-align: middle;">
                <?= date('d/m/Y', strtotime($val0['FDLvhCreateOn'])) ?>
            </td>
            <td class="text-left" style="vertical-align: middle;">
                <?= $val0["FTDevName"] ?>
            </td>
            <td class="text-left" style="vertical-align: middle;">
                <?= $val0["FTDevGrpTeam"] ?>
            </td>
            <td class="text-left" style="vertical-align: middle;"><?= $val0["FTLvtName"] ?></td>
            <td class="text-center" style="vertical-align: middle;">
                <?= date('d/m/Y', strtotime($val0['FDLvhDateFrom'])) ?>
            </td>
            <td class="text-center" style="vertical-align: middle;">
                <?= date('d/m/Y', strtotime($val0['FDLvhDateTo'])) ?>
            </td>

            <!-- <td class="text-right" style="vertical-align: middle;">
                <?= JSdLEVCalculateTotalDays($val0['FDLvhDateFrom'], $val0['FDLvhDateTo']) ?> วัน
            </td> -->
            <td class="text-left" style="vertical-align: middle; text-align: center;"><?= $val0["FCLvhDayQty"] ?></td>
            </td>
            <td class="text-left" style="vertical-align: middle; text-align: left;">
                <?php 
        if ($val0["FTLvhStaApv"] == 1) {
            echo '<span class="badge text-warning" style="font-size: 14px; margin-top: 5px;">รออนุมัติ</span>';
        } elseif ($val0["FTLvhStaApv"] == 2) {
            echo '<span class="badge text-success" style="font-size: 14px; margin-top: 5px;">อนุมัติ</span>';
        } elseif ($val0["FTLvhStaApv"] == 3) {
            echo '<span class="badge text-danger" style="font-size: 14px; margin-top: 5px;">ยกเลิก</span>';
        } elseif ($val0["FTLvhStaApv"] == 4) {
            echo '<span class="badge text-danger" style="font-size: 14px; margin-top: 5px;">ไม่อนุมัติ</span>';
        }
        else {
            echo '<span class="badge text-secondary" style="font-size: 14px; margin-top: 5px;">สถานะไม่ทราบ</span>';
        }
    ?>
            </td>

            <td class="text-left" style="vertical-align: middle;">
                <?= $val0["FTLvhApvByName"] ?>
            </td>


            <td></td>
            <td></td>
            <td class="text-center" style="vertical-align: middle;">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#odvApproveModal<?= $key0 ?>" style="font-size: 0.9em;">
                    <span style="font-size: 0.9em;">รายละเอียด</span>
                </button>
            </td>

            <td></td>
            </tr>
            <?php
                }
            } else {
            ?>
            <tr>
                <td colspan="8">ไม่พบข้อมูลการลา</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>






<?php
if (!empty($aLeaveManageList['raItems'])) {
    foreach ($aLeaveManageList['raItems'] as $key0 => $val0) {
?>
<div class="modal fade" id="odvApproveModal<?= $key0 ?>" tabindex="-1" aria-labelledby="olaApproveModal"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="olaApproveModal">
                    รายละเอียดการลา
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mt-3 mb-3">
                    <div class="col-md-12 ml-auto "><b>วันที่ทำรายการ :
                        </b><span
                            id="odvCreateOn<?= $key0 ?>"><?php echo  date('d/m/Y', strtotime($val0["FDLvhCreateOn"])); ?></span>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-md-7 ml-auto"><b>ชื่อ-สกุล :
                        </b><span id="odvDevName<?= $key0 ?>"><?php echo $val0["FTDevName"]; ?></span></div>
                    <div class="col-md-5 ml-auto"><b>ทีม :
                        </b><span id="otaDevGrpTeam<?= $key0 ?>"><?php echo $val0["FTDevGrpTeam"]; ?></span></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-md-7 ml-auto"><b>ประเภทการลา :
                        </b><span id="odvTypeName<?= $key0 ?>"><?php echo $val0["FTLvtName"]; ?></span></div>
                    <div class="col-md-5 ml-auto"><b>สถานะ : </b>
                        <?php 
                if ($val0["FTLvhStaApv"] == 1) {
                    echo '<span class="badge text-warning" style="font-size: 14px;">รออนุมัติ</span>';
                } elseif ($val0["FTLvhStaApv"] == 2) {
                    echo '<span class="badge text-success" style="font-size: 14px;">อนุมัติ</span>';
                } elseif ($val0["FTLvhStaApv"] == 3) {
                    echo '<span class="badge text-danger" style="font-size: 14px;">ยกเลิก</span>';
                } elseif ($val0["FTLvhStaApv"] == 4) {
                    echo '<span class="badge text-danger" style="font-size: 14px;">ไม่อนุมัติ</span>';
                } else {
                    echo '<span class="badge text-secondary" style="font-size: 14px;">สถานะไม่ทราบ</span>';
                }
                    ?>
                    </div>
                    <div class="row mt-3 mb-1">
                        <div class="col-md-7 ml-auto">
                            <div class="leave-date">
                                <b>วันที่ลา :</b>
                                <span
                                    id="odvDateFrom<?= $key0 ?>"><?php echo date('d/m/Y', strtotime($val0["FDLvhDateFrom"])); ?></span>
                                -
                                <span
                                    id="odvDateTo<?= $key0 ?>"><?php echo date('d/m/Y', strtotime($val0["FDLvhDateTo"])); ?></span>
                            </div>
                        </div>
                        <div class="col-md-5 ml-auto">
                            <b>&nbsp; &nbsp;จำนวน :</b>
                            <span id="otaAmount<?= $key0 ?>"><?php echo $val0["FCLvhDayQty"]; ?></span>&nbsp;วัน
                        </div>
                    </div>
                    <div class="row mt-3 mb-1">
                        <div class="col-md-7 ml-auto"><b>จังหวัด :
                            </b><span id="odvProvinceName<?= $key0 ?>"><?php echo $val0["FTPvnName"]; ?></span></div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-md-7 ml-auto"><b>ระบุเหตุผล :
                            </b><span id="otaRemark<?= $key0 ?>"><?php echo $val0["FTLvhRemark"]; ?></span></div>
                    </div>

                    <!-- <div class="row mt-3 mb-3"> -->
                    <div class=" mt-3-col-md-7">
                        <b>ไฟล์แนบ : </b>
                        <?php
                                if ($val0["FTLvhAttachFile"] != null) {
                                $fileName = basename($val0["FTLvhAttachFile"]);
                                $fileUrl = base_url() . $val0["FTLvhAttachFile"];
                                echo '<a href="' . $fileUrl . '" target="_blank">' . $fileName . '</a>';
                        } else {
                                echo '<span style="color: red;">ยังไม่ได้แนบไฟล์</span>';
                        }
                            ?>
                    </div>
                    <!-- <div class="col-md-5">
                        <b>สถานะ : </b>
                        <?php 
                if ($val0["FTLvhStaApv"] == 1) {
                    echo '<span class="badge text-warning" style="font-size: 14px;">รออนุมัติ</span>';
                } elseif ($val0["FTLvhStaApv"] == 2) {
                    echo '<span class="badge text-success" style="font-size: 14px;">อนุมัติ</span>';
                } elseif ($val0["FTLvhStaApv"] == 3) {
                    echo '<span class="badge text-danger" style="font-size: 14px;">ยกเลิก</span>';
                } elseif ($val0["FTLvhStaApv"] == 4) {
                    echo '<span class="badge text-danger" style="font-size: 14px;">ไม่อนุมัติ</span>';
                } else {
                    echo '<span class="badge text-secondary" style="font-size: 14px;">สถานะไม่ทราบ</span>';
                }
                    ?>
                    </div> -->
                </div>
                <hr>
                <div class="row">
                    <?php if ($val0["FTLvhStaApv"] != 1) { ?>
                    <p><b>ดำเนินการโดย : </b><?php echo $val0["FTLvhApvByName"]; ?></p>
                    <?php } ?>
                </div>
                <div class="col-lg-12 nopadding mb-2">
                    <label for="otaComment<?= $key0 ?>" class="form-label"><b>ความคิดเห็นหัวหน้างาน</b></label>
                    <textarea id="otaComment<?= $key0 ?>" placeholder="โปรดระบุความคิดเห็น"
                        name="otaComment<?= $key0 ?>"
                        <?php if ($val0["FTLvhStaApv"] == 2 || $val0["FTLvhStaApv"] == 3) echo 'readonly'; ?>
                        class="form-control" style="width: 100%;"><?php echo $val0["FTLvhComment"]; ?></textarea>
                </div>
                </hr>
            </div>

            <div class="modal-footer">
                <div class="d-flex justify-content-end align-items-center w-100">
                    <?php if ($val0["FTLvhStaApv"] == 1) { ?>
                    <div>
                        <button type="button" class="btn btn-danger"
                            onclick="JSxLEVDenyLeave('<?= $val0['FTLvhCode'] ?>', '<?= $key0 ?>')">
                            <i class="fas fa-times"></i> ไม่อนุมัติ
                        </button>
                        <button type="button" class="btn btn-success"
                            onclick="JSxLEVApproveLeave('<?= $val0['FTLvhCode'] ?>', '<?= $key0 ?>')">
                            <i class="fas fa-check"></i> อนุมัติ
                        </button>
                    </div>
                    <?php } else if ($val0["FTLvhStaApv"] == 2 || $val0["FTLvhStaApv"] == 4) { ?>
                    <div>
                        <button type="button" class="btn btn-warning text-white"
                            onclick="JSxLEVRollbackLeave('<?= $val0['FTLvhCode'] ?>')">
                            <i class="fas fa-ban"></i> ยกเลิกสถานะ
                        </button>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div> 
    </div>
</div>
</div>
</div>
<?php
    } 
} 
?>
<!-- การแบ่งหน้า -->
<div class="col-md-6 ">
    พบข้อมูล <?php echo $aLeaveManageList["total_record"]; ?> รายการ
    แสดงหน้า <?php echo $aLeaveManageList["current_page"]; ?>/
    <label><?php echo $aLeaveManageList["total_pages"]; ?></label>
    <input type="hidden" id="oetTotalPage" value="<?php echo $aLeaveManageList['total_pages']; ?>">
</div>
<div class="col-md-6 ">
    <nav>
        <ul class="pagination justify-content-end">
            <?php if ($aLeaveManageList["current_page"] == 0 or $aLeaveManageList["current_page"] == 1) { ?>
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php } else { ?>
            <li class="page-item">
                <a class="page-link" href="#" onclick="PreviousPage()" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php } ?>
            <?php
            $cPage = $aLeaveManageList["current_page"];
            $tPage = $aLeaveManageList["total_pages"];

            if ($tPage > 2 and $cPage == $tPage) {

                $ldPage = $tPage;
                $fdPage =  $tPage - 3;
            } else {
                $fdPage =  $cPage - 2;
                $ldPage = $cPage  + 2;
            }

            for ($n = 1; $n <= $aLeaveManageList["total_pages"]; $n++) {
                if ($n >= $fdPage and $n <= $ldPage) {
                    if ($aLeaveManageList["current_page"] == $n) { ?>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#" onclick="SelectPage('<?= $n ?>')"><?= $n ?></a>
            </li>
            <?php } else { ?>
            <li class="page-item" aria-current="page">
                <a class="page-link" href="#" onclick="SelectPage('<?= $n ?>')"><?= $n ?></a>
            </li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <li class="page-item">
                <a class="page-link" href="#" onclick="NextPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>




<script>
function SelectPage(nPage) {
    $("#oetFilterLSMPage").val(nPage);
    JSxLEVGetLeaveManageList();
}

function PreviousPage() {
    var cPage = $("#oetFilterLSMPage").val()
    var nPage = 0;
    if (cPage > 1) {
        nPage = cPage - 1;
        $("#oetFilterLSMPage").val(nPage)
        JSxLEVGetLeaveManageList();
    }
}

function NextPage() {
    var cPage = $("#oetFilterLSMPage").val()
    var tPage = $("#oetTotalPage").val()
    var nPage = 0;
    if (cPage < tPage) {
        nPage = parseInt(cPage) + 1;
        $("#oetFilterLSMPage").val(nPage)
        JSxLEVGetLeaveManageList();
    }
}





function JSxLEVApproveLeave(FTLvhCode, key0) {
    var otaComment = $("#otaComment" + key0).val();
    var dCreateOn = $("#odvCreateOn" + key0).text();
    var tDevName = $("#odvDevName" + key0).text();
    var dDateFrom = $("#odvDateFrom" + key0).text();
    var dDateTo = $("#odvDateTo" + key0).text();
    var tPvnName = $("#odvProvinceName" + key0).text();
    var tDevGrpTeam = $("#otaDevGrpTeam" + key0).text();
    var tRemark = $("#otaRemark" + key0).text();
    var nStatus = $("#otaStaApv" + key0).text();
    var tComment = $("#otaComment" + key0).text();
    var tApproveByName = $("#otaApproveName" + key0).text();
    var nAmount = $("#otaAmount" + key0).text();
    var tTypeName = $("#odvTypeName" + key0).text();
    var aDataToSend = {
        "CreateOn": dCreateOn,
        "DevName": tDevName,
        "DateFrom": dDateFrom,
        "DateTo": dDateTo,
        "Amout": nAmount,
        "Team": tDevGrpTeam,
        "Type": tTypeName,
        "Province": tPvnName,
        "ApproveStatus": "Approved",
        "ApproveBy": tApproveByName,
        "Remark": tRemark
    };
    if (confirm("อนุมัติการลางานใช่หรือไม่?")) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/masLEVEventLeaveManagerApprove') ?>",
            data: {
                "FTLvhCode": FTLvhCode,
                "otaComment": otaComment,
                "dCreateOn": dCreateOn,
                "tDevName": tDevName,
                "dDateFrom": dDateFrom,
                "dDateTo": dDateTo,
                "Amout": nAmount,
                "tPvnName": tPvnName,
                "tRemark": tRemark,
                "nStatus": nStatus,
            },
            success: function(response) {
                if (response === 'success') {
                //    alert('อนุมัติการลาเรียบร้อยแล้ว');
                    $("#odvApproveModal" + key0).modal('hide');
                    $(".modal-backdrop").remove();
                    JSxLEVGetLeaveManageList();

                } else {
                    $(".modal-backdrop").remove();
                    JSxLEVGetLeaveManageList();
                }
            },
        });
    }
}
function JSxLEVDenyLeave(FTLvhCode, key0) {
    var otaComment = $("#otaComment" + key0).val();
    if (otaComment == '') {
        alert("กรุณาระบุความคิดเห็นก่อนทำรายการ");
        return;
    } else if (confirm("ไม่อนุมัติการลางานที่เลือกใช่หรือไม่?")) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/masLEVEventLeaveManagerDeny') ?>",
            data: {
                "FTLvhCode": FTLvhCode,
                "otaComment": otaComment,
            },
            success: function(response) {
                if (response === 'success') {
                    alert('ทำรายการเรียบร้อยแล้ว');
                    $("#odvApproveModal" + key0).modal('hide');
                    $(".modal-backdrop").remove();
                    JSxLEVGetLeaveManageList();
                } else {
                    $(".modal-backdrop").remove();
                    JSxLEVGetLeaveManageList();
                }
            },
        });
    }
}
function JSxLEVRollbackLeave(FTLvhCode) {

    if (confirm("ต้องการยกเลิกสถานะการลางานที่เลือกใช่หรือไม่?")) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/masLEVEventRollback') ?>",
            data: {
                "FTLvhCode": FTLvhCode,
            },
            success: function(response) {
                if (response === 'success') {
                    $("#odvApproveModal").modal('hide');
                    $(".modal-backdrop").remove();
                    JSxLEVGetLeaveManageList();
                } else {
                    $(".modal-backdrop").remove();
                    JSxLEVGetLeaveManageList();
                }
            },
        });
    }
}
</script>