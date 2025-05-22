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
            <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">สร้างโปรเจ็คใหม่</div>
            <div class="col-md-12">
                <form id="ofmProject">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="ockAutoPrjCode" checked>
                        <label class="form-check-label" for="ockAutoPrjCode">สร้างรหัสอัตโนมัติ</label>
                    </div>
                    <div class="form-group col-md-12 input-data">
                        <label for="name">รหัสโปรเจ็ค:</label>
                        <input type="hidden" id="ohdPrjCode" name="ohdPrjCode" class="form-control" id="name"
                            placeholder="รหัสโปรเจ็คอัตโนมัติ" value="<?= $PrjCode ?>">
                        <input type="text" id="oetPrjCode" name="oetPrjCode" class="form-control disabled" id="name"
                            placeholder="รหัสโปรเจ็ค" value="" disabled>
                    </div>
                    <div class="form-group col-md-12 input-data">
                        <label for="Project">ชื่อโปรเจ็ค:</label>
                        <input type="text" id="oetPrjName" name="oetPrjName" class="form-control"
                            placeholder="ชื่อโปรเจ็ค" maxlength="255">
                    </div>
                    <div class="form-group col-md-12 input-data">
                        <label for="message">แผนก:</label>

                        <input type="text" class="form-control" value="<?= $UsrDevName ?>" disabled="true">
                        <input type="hidden" id="oetDepCode" name="oetDepCode" class="form-control" value="<?= $UsrDepCode ?>">
                        <!-- <select id="oetDepCode" name="oetDepCode" class="form-control">
                            <option value="">เลือกแผนก</Option>
                            <?php foreach ($DepartmentList["raItems"] as $key0 => $val0) { ?>
                            <option value="<?php echo $val0["FTDepCode"]; ?>"><?php echo $val0["FTDepName"]; ?></Option>
                            <?php } ?>
                        </select> -->
                    </div>
                    <div class="form-group col-md-12 input-data">
                        <input type="checkbox" name="ocmPrjStaUse" id="ocmPrjStaUse" checked> ใช้งาน
                    </div>
                    <div class="form-group col-md-12 input-data">
                        <input type="checkbox" name="ocmPrjPoForce" id="ocmPrjPoForce" checked> บังคับกรอก PO
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

                <a href="#" onclick="BackToProjectList()" style="cursor:'pointer'">
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


        if ($("#ockAutoPrjCode").is(":checked") == false && $("#oetPrjCode").val() == '') {
            alert("กรุณากรอกหัสโปรเจ็ค");
        } else if ($("#oetPrjName").val() == '') {
            alert("กรุณากรอกชื่อโปรเจ็ค");
        } else if ($("#oetDepCode").val() == '') {
            alert("กรุณาเลือกแผนก");
        } else {
            var formData = $("#ofmProject").serialize();
            $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/SaveNewProject') ?>",
                data: formData,
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    switch (tResult) {
                        case "Duplicate":
                            alert("ไม่สามารถสร้างโปรเจ็คได้เนื่องจาก รหัสโปรเจ็คนี้มีอยู่แล้วในระบบ");
                            break;
                        case "error":
                            alert("เกิดข้อผิดพลาดไม่สามารถสร้างโปรเจ็คได้ กรุณาลองใหม่อีกครั้ง");
                            break;
                        case "success":
                            window.location.href = 'ProjectList';
                            break;
                        default:
                            window.location.href = 'ProjectList';
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาดในการบันทึกข้อมูลโปรเจ็ค กรุณาลองอีกครั้ง');
                }
            });
        }



    }
</script>

</html>