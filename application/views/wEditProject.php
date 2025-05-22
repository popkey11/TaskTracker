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
    bottom: 0px; width: 50%; z-index:-10000"></img>

    <?php include(APPPATH . 'views/menu/wMenu.php') ?>

    <div class="container-fluid">
        <?php
        $tPrjCode = $aProjects['raItems'][0]["FTPrjCode"];
        $tPrjName = $aProjects['raItems'][0]["FTPrjName"];
        $tDevCode = $aProjects['raItems'][0]["FTDepCode"];
        $tDevName = $aProjects['raItems'][0]["FTDepName"];
        $tActive = $aProjects['raItems'][0]["FTPrjStaUse"];
        $tActivePo = $aProjects['raItems'][0]["FBPrjPoForce"];

        ?>
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">แก้ไขข้อมูลโปรเจ็ค</div>
            <div class="col-md-12">
                <form id="ofmProject">
                    <div class="form-group col-md-12 input-data">
                        <label for="name">รหัสโปรเจ็ค:</label>
                        <input type="text" value="<?= $tPrjCode ?>" class="form-control disabled" disabled>
                        <input type="hidden" id="oetPrjCode" name="oetPrjCode" class="form-control" id="name"
                            placeholder="รหัสโปรเจ็ค" value="<?= $tPrjCode ?>">
                    </div>
                    <div class="form-group col-md-12 input-data">
                        <label for="Project">ชื่อโปรเจ็ค:</label>
                        <input type="text" id="oetPrjName" name="oetPrjName" class="form-control"
                            placeholder="ชื่อโปรเจ็ค" value="<?= $tPrjName ?>" maxlength="255">
                    </div>
                    <div class="form-group col-md-12 input-data">
                        <label for="message">แผนก:</label>
                        <select id="oetDepCode" name="oetDepCode" class="form-control" disabled="true">
                            <option value="">เลือกแผนก</Option>
                            <?php foreach ($DepartmentList["raItems"] as $key0 => $val0) { ?>
                                <?php if ($val0["FTDepCode"] == $tDevCode) { ?>
                                    <option value="<?php echo $val0["FTDepCode"]; ?>" selected><?php echo $val0["FTDepName"]; ?>
                                    </Option>
                                <?php } ?>
                                <option value="<?php echo $val0["FTDepCode"]; ?>"><?php echo $val0["FTDepName"]; ?></Option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12 input-data">
                        <?php if ($tActive == '1') {
                            $tCheck = "checked";
                        } else {
                            $tCheck = "";
                        }; ?>
                        <input type="checkbox" name="ocmPrjStaUse" <?php echo $tCheck; ?>> ใช้งาน

                    </div>

                    <div class="form-group col-md-12 input-data">
                        <?php if ($tActivePo == true) {
                            $tCheckPo = "checked";
                        } else {
                            $tCheckPo = "";
                        }; ?>
                        <input type="checkbox" name="ocbPrjPoForce" <?php echo $tCheckPo; ?>> บังคับกรอก PO
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
                <button type="botton" class="btn btn-primary" onclick="UpdateProject()">บันทึก</button>
                <!-- <a  href="#" onclick="alert('xxx')">บันทึกxx</a> -->
            </div>
        </div>




    </div>
</body>

<script>
    //ย้อนกลับ
    function BackToProjectList() {
        window.location.href = "<?= base_url('/index.php/ProjectList') ?>";
    }

    //Update Project
    function UpdateProject() {

        if ($("#oetPrjCode").val() == '') {
            alert("กรุณากรอกหัสโปรเจ็ค");
        } else if ($("#oetPrjName").val() == '') {
            alert("กรุณากรอกชื่อโปรเจ็ค");
        } else if ($("#oetDepCode").val() == '') {
            alert("กรุณาเลือกแผนก");
        } else {
            var formData = $("#ofmProject").serialize();
            $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/UpdateProject') ?>",
                data: formData,
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    switch (tResult) {
                        case "error":
                            alert("เกิดข้อผิดพลาดไม่สามารถแก้ไขโปรเจ็คได้ กรุณาลองใหม่อีกครั้ง");
                            break;
                        case "success":
                            window.location.href = '<?= base_url('/index.php/ProjectList') ?>';
                            break;
                        default:
                            window.location.href = '<?= base_url('/index.php/ProjectList') ?>';
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาดในแก้ไขข้อมูลโปรเจ็ค กรุณาลองอีกครั้ง');
                }
            });
        }
    }
</script>

</html>