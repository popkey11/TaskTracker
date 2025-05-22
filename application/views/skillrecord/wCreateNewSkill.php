<?php include(APPPATH . 'views/wHeader.php') ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/ada.titlebar.css'); ?>" />
<html>
<title>
    <?= $tTitle ?>
</title>

</html>

<body>
    <img src="<?php echo base_url('/assets/WorkingBg.png'); ?>" style="opacity: 0.2; position: absolute;
    right: 0px;
    bottom: 0px; width: 50%; z-index:-10000"></img>


	<?php include(APPPATH. 'views/menu/wMenu.php') ?>
    <div class="container-fluid" style="margin-top:10px">
        <div class="row" style="margin-top:15px">
            <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">เพิ่มทักษะ</div>
            <div class="col-md-12">
                <form id="ofmNewSkillForm">
                    <div class="form-group col-md-12 input-data">
                        <label for="message">แผนก:</label>
                        <input type="text" class="form-control" value="<?=$UsrDevName?>" disabled="true">
                        <input type="hidden" id="oetDepCode" name="oetDepCode" class="form-control" value="<?=$UsrDepCode?>">
                    </div>
                    <div class="form-group">

                        <label>*ทักษะ</label>
                        <input id="oetSkillName" name="oetSkillName" class="form-control" required maxlength="50">

                        <label>*กลุ่มทักษะ</label>
                        <select id="ocmGroupSkillName" name="ocmGroupSkillName" class="selectpicker border rounded "
                            data-live-search="true" data-width="100%" required>
                            <option value="">โปรดเลือก</option>
                            <?php foreach ($GroupSkillList["raItems"] as $key0 => $val0) { ?>
                                <option 
                                    value="<?php echo $val0["FTSkgCode"]; ?>"><?php echo $val0["FTSkgGrpName"]; ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label>*บทบาท</label>
                        <select id="ocmRoleSkill" name="ocmRoleSkill" class="selectpicker border rounded "
                            data-live-search="true" data-width="100%" required>
                            <option value="">โปรดเลือก</option>
                            <?php foreach ($RoleList["raItems"] as $key0 => $val0) { ?>
                                <option 
                                    value="<?php echo $val0["FTRolCode"]; ?>"><?php echo $val0["FTRolName"]; ?>
                                </option>
                            <?php } ?>
                            <option value="99999">All</option>
                        </select>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo base_url('index.php/tpjSKRPageSkill') ?> " style="cursor='pointer'">
                                << ย้อนกลับ</a>
                        </div>
                        <div class="col-md-6 text-end" style="z-index:10000">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    // $("#ofmNewSkillForm").on("submit")

    $("#ofmNewSkillForm").on("submit", function (event) {
        // alert("Handler for `submit` called.");
        event.preventDefault();
        JSxSKRSaveskill();
    });
    
    function JSxSKRSaveskill() {
        if ($("#oetSkillName").val() == '') {
            $("#oetSkillName").focus();
        } else if ($("#ocmGroupSkillName").val() == '') {
            $("#ocmGroupSkillName").focus();
        } else if ($("#ocmRoleSkill").val() == '') {
            $("#ocmRoleSkill").focus();
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/tpjSKREventAddSkill') ?>",
                data: {
                    "oetSkillName": $("#oetSkillName").val(),
                    "ocmGroupSkillName": $("#ocmGroupSkillName").val(),
                    "ocmRoleSkill": $("#ocmRoleSkill").val(),
                    "oetDepCode": $("#oetDepCode").val(),
                },
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    // console.log('test')
                    // console.log(tResult)
                    if (tResult == 'success') {
                        window.location.href = '<?= base_url('/index.php/tpjSKRPageSkill') ?>';
                    } else {
                        alert("เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง")
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                }
            });
        }
    }
</script>
