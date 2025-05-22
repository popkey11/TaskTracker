<?php
$tSkillcode         = $aSkillStart['raItems'][0]["FTSkrCode"];
$tSkillname         = $aSkillStart['raItems'][0]["FTSkrSkillName"];
$tGrpskillcode      = $aSkillStart['raItems'][0]["FTSkgCode"];
$tRoleskill         = $aSkillStart['raItems'][0]["FTRolCode"];
$tSkillStatus       = $aSkillStart['raItems'][0]["FNSkrStaUse"];
?>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">แก้ไขทักษะ</div>
    <div class="col-md-12">
        <form>
            <div class="form-group col-md-12 input-data">
                <label for="message">แผนก:</label>
                <input type="text" class="form-control" value="<?=$UsrDevName?>" disabled="true">
                <input type="hidden" id="oetDepCode" name="oetDepCode" class="form-control" value="<?=$UsrDepCode?>">
            </div>
            <div class="form-group">
                <label>*Skill Name</label>
                <input type="hidden" class="form-control" id="oetSkillcode" name="oetSkillcode" value="<?= $tSkillcode ?>">
                <input type="text" class="form-control" id="oetSkillname" name="oetSkillname" required maxlength="50" value="<?= $tSkillname ?>">

                <label>*Group Skill</label>
                <select id="ocmGroupSkillName" name="ocmGroupSkillName" required class="form-control form-select ">
                    <option value="">โปรดเลือก</Option>
                    <?php foreach ($GroupSkillList["raItems"] as $key0 => $val0) { ?>
                        <option 
                            value="<?php echo $val0["FTSkgCode"]; ?>" <?= ($val0["FTSkgCode"] == $tGrpskillcode) ? 'selected' : ''; ?>><?php echo $val0["FTSkgGrpName"]; ?>
                        </option>
                    <?php } ?>
                </select>

                <label>*Role</label>
                <select id="ocmRoleSkill" name="ocmRoleSkill" required class="form-control form-select">
                    <option value="">โปรดเลือก</option>
                    <?php foreach ($RoleList["raItems"] as $key0 => $val0) { ?>
                        <option 
                            value="<?php echo $val0["FTRolCode"]; ?>" <?= ($val0["FTRolCode"] == $tRoleskill) ? 'selected' : ''; ?>><?php echo $val0["FTRolName"]; ?>
                        </option>
                    <?php } ?>
                    <option value="99999" <?= ($tRoleskill == '99999') ? 'selected' : ''; ?>>All</option>
                </select>

                <input type="hidden" class="form-control" id="oetSkillStatus" name="oetSkillStatus" value="<?= $tSkillStatus ?>">
            </div>
            <div>
                <input type="hidden" id="oetFilterGrpPage" value="<?= $nPage ?>">
            </div>
        </form>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <a href="<?php echo base_url('index.php/tpjSKRPageSkill') ?> " style="cursor='pointer'">
            << ย้อนกลับ</a>
    </div>
    <div class="col-md-6 text-end" style="z-index:10000">
        <button type="botton" class="btn btn-primary" onclick="JSxSKRUpdateSkill()">บันทึก</button>
    </div>
</div>


<script>
    function JSxSKRUpdateSkill() {
        if ($("#oetSkillName").val() == ' ') {
            $("#oetSkillName").focus();
        } else if ($("#ocmGroupSkillName").val() == '') {
            $("#ocmGroupSkillName").focus();
        } else if ($("#ocmRoleSkill").val() == '') {
            $("#ocmRoleSkill").focus();
        } else {
            var nPage = $("#oetFilterGrpPage").val()
            $.ajax({

                type: "POST",
                url: "<?= base_url('/index.php/tpjSKREventUpdateSkill') ?>",
                data: {
                    "oetSkillcode": $("#oetSkillcode").val(),
                    "oetSkillname": $("#oetSkillname").val(),
                    "ocmGroupSkillName": $("#ocmGroupSkillName").val(),
                    "ocmRoleSkill": $("#ocmRoleSkill").val(),
                    "oetSkillStatus": $("#oetSkillStatus").val(),
                    "nPage": nPage,
                },
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    if (tResult == 'success') {
                        localStorage.setItem('page', nPage)
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