<?php include(APPPATH . 'views/wHeader.php') ?>
<style>
.Titlebar {
    padding: 10px;
    color: #ffffff;
}

.input-data {
    margin-bottom: 10px;
}

.active {
    color: blue !important;
}
</style>
<html>

<body>
    <img src="<?php echo base_url('/assets/WorkingBg.png'); ?>" style="opacity: 0.2; position: absolute;
    right: 0px;
    bottom: 0px; width: 50%; z-index:-10000">
    <?php include(APPPATH . 'views/menu/wMenu.php') ?>
    <div class="container-fluid">
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-12" style="font-size:18px;  padding-bottom:5px"><b>จัดการข้อมูล PO</b></div>
            <div class="col-md-12">
                <form id="ofmAddPo">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>Title:</b></label>
                                <input type="text" id="oetPoTitle" name="oetPoTitle" class="form-control"
                                    placeholder="title" maxlength="255">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>Status:</b></label>
                                <select class="form-control" id="ocmPoStatus" name="ocmPoStatus">
                                    <option value="">ระบุสถานะ</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Uat">Uat</option>
                                    <option value="Kickoff">Kickoff</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>%Progress:</b></label>
                                <input type="text" id="oetPoProgress" name="oetPoProgress" class="form-control"
                                    placeholder="Progress" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>PO No:</b></label>
                                <input type="text" id="oetPoNo" name="oetPoNo" class="form-control" placeholder="PO No"
                                    maxlength="255">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>PO Remark:</b></label>
                                <input type="text" id="oetPoRemark" name="oetPoRemark" class="form-control"
                                    placeholder="PO Remark" maxlength="255">
                            </div>

                        </div>
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>PO Date:</b></label>
                                <input type="text" id="oetPoDate" name="oetPoDate" class="form-control"
                                    placeholder="PO Date" maxlength="255">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>Plan Start:</b></label>
                                <input type="text" id="oetPoPlanStart" name="oetPoPlanStart" class="form-control"
                                    placeholder="Plan Start" maxlength="255">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>Plan Finish:</b></label>
                                <input type="text" id="oetPoFinish" name="oetPoFinish" class="form-control"
                                    placeholder="Plan Finish" maxlength="255">
                            </div>

                        </div>
                        <div class="col-4">
                            <div class="form-group col-md-12 input-data">
                                <label for="Project"><b>Url Refer Plan:</b></label>
                                <input type="text" id="oetPoUrlRefer" name="oetPoUrlRefer" class="form-control"
                                    placeholder="Url Refer Plan" maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">Man/Day</div>
                    <div class="row">
                        <div class="col-2">
                            <label for="Project"><b>MD Dev:</b></label>
                            <input type="text" id="oetMDDev" name="oetMDDev" class="form-control" placeholder="Man Dev"
                                maxlength="255">
                        </div>
                        <div class="col-2">
                            <label for="Project"><b>MD Tester:</b></label>
                            <input type="text" id="oetMDTester" name="oetMDTester" class="form-control"
                                placeholder="Man Tester" maxlength="255">
                        </div>
                        <div class="col-2">
                            <label for="Project"><b>MD Sa:</b></label>
                            <input type="text" id="oetMDsa" name="oetMDsa" class="form-control" placeholder="MD sa"
                                maxlength="255">
                        </div>
                        <div class="col-2">
                            <label for="Project"><b>MD PM:</b>
                            </label>
                            <input type="text" id="oetMDPm" name="oetMDPm" class="form-control" placeholder="MD Pm"
                                maxlength="255">
                        </div>
                        <div class="col-2">
                            <label for="Project"><b>Man %Interface:</b></label>
                            <input type="text" id="oetMDInterface" name="oetMDInterface" class="form-control"
                                placeholder="MD Interface" maxlength="255">
                        </div>
                        <div class="col-2">
                            <label for="Project"><b>MD Total:</b></label>
                            <input type="text" id="oetMDTotal" name="oetMDTotal" class="form-control"
                                placeholder="Man total" maxlength="255">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="Project"><b>MD PHP</b></label>
                            <input type="text" id="oetMdPHP" name="oetMDPHP" class="form-control" placeholder="MD PHP"
                                maxlength="255">
                        </div>
                        <div class="col-4">
                            <label for="Project"><b>MD C#:</b></label>
                            <input type="text" id="oetMDC" name="oetMDC" class="form-control" placeholder="MD C"
                                maxlength="255">
                        </div>
                        <div class="col-4">
                            <label for="Project"><b>MD Andriod:</b></label>
                            <input type="text" id="oetMDAndriod" name="oetMDAndriod" class="form-control"
                                placeholder="Man Dev" maxlength="255">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

                <a href="#" onclick="BackToProjectList()" style="cursor='pointer'">
                    << ย้อนกลับ </a>
            </div>
            <div class="col-md-6 text-end" style="z-index:10000">
                <button type="botton" class="btn btn-primary" onclick="SaveNewProject()">บันทึก</button>
                <!-- <a  href="#" onclick="alert('xxx')">บันทึกxx</a> -->
            </div>
        </div>
    </div>
</body>

<script>
//ย้อนกลับ
function BackToProjectList() {
    window.location.href = 'ProjectList';
}

$('#ockAutoPrjCode').change(function() {
    if ($("#ockAutoPrjCode").is(":checked") == true) {
        var active = 1;
        $('#oetPrjCode').attr("disabled", true)
    } else {
        var active = 2;
        $('#oetPrjCode').attr("disabled", false)
    }
});

// บันทึกข้อมูลโปรเจ็ค
function SaveNewProject() {

    if ($('#oetPoTitle').val() == "") {
        alert("กรุณากรอกTitle");
        $('#oetPoTitle').focus();
        return false;
    } else if ($('#ocmPoStatus').val() == "") {
        alert("กรุณาระบุ Status");
        $('#ocmPoStatus').focus();
        return false;
    } else if ($('#oetPoProgress').val() == "") {
        alert("กรุณากรอก Progress");
        $('#oetPoProgress').focus();
        return false;
    } else if ($('#oetPoNo').val() == "") {
        alert("กรุณากรอก Po No");
        $('#oetPoNo').focus();
        return false;
    } else if ($('#oetPoRemark').val() == "") {
        alert("กรุณากรอก Remark");
        $('#oetPoRemark').focus();
        return false;

    } else if ($('#oetPoDate').val() == "") {
        alert("กรุณากรอก Po Date");
        $('#oetPoDate').focus();
        return false;
    } else if ($('#oetPoPlanStart').val() == "") {
        alert("กรุณากรอก Plan Start ");
        $('#oetPoPlanStart').focus();
        return false;
    } else if ($('#oetPoFinish').val() == "") {
        alert("กรุณากรอก Plan Finish ");
        $('#oetPoFinish').focus();
        return false;

    } else if ($('#oetPoUrlRefer').val() == "") {
        alert("กรุณากรอก Plan URl Refer ");
        $('#oetPoUrlRefer').focus();
        return false;


    }
    // if ($("#ockAutoPrjCode").is(":checked") == false && $("#oetPrjCode").val() == '') {
    //     alert("กรุณากรอกหัสโปรเจ็ค");
    // } else if ($("#oetPrjName").val() == '') {
    //     alert("กรุณากรอกชื่อโปรเจ็ค");
    // } else if ($("#oetDepCode").val() == '') {
    //     alert("กรุณาเลือกแผนก");
    // } else {
    var formData = $("#ofmAddPo").serialize();
    $.ajax({
        type: "POST",
        url: "<?= base_url('/index.php/docPOEventAdd') ?>",
        data: formData,
        cache: false,
        timeout: 0,
        success: function(tResult) {

            console.log(tResult);
            alert('บันทึกสำเร็จ');
            // switch (tResult) {
            //     case "Duplicate":
            //         alert("ไม่สามารถสร้างโปรเจ็คได้เนื่องจาก รหัสโปรเจ็คนี้มีอยู่แล้วในระบบ");
            //         break;
            //     case "error":
            //         alert("เกิดข้อผิดพลาดไม่สามารถสร้างโปรเจ็คได้ กรุณาลองใหม่อีกครั้ง");
            //         break;
            //     case "success":
            //         window.location.href = 'ProjectList';
            //         break;
            //     default:
            window.location.href = 'docPOPageListView';
            // }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการบันทึกข้อมูลโปรเจ็ค กรุณาลองอีกครั้ง');
        }
    });
    // }
}
</script>

</html>
