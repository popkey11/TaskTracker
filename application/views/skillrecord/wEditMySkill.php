<?php

// $tSkillName;
// $tLevelSkill;
?>


<div class="row" style="margin-top: 15px;">
    <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">แก้ไขทักษะ</div>
    <div class="col-md-12">
        <form>
            <div class="form-group">
                <label>*Skill Name</label>
                <input type="hidden" class="form-control" id="oetSkillcode" name="oetSkillcode" required
                    value="<?= $tMySkillID ?>">

                <input type="text" class="form-control" id="oetSkillname" name="oetSkillname" required maxlength="50" disabled
                    value=" <?= $tSkillName ?>">
                </input>

                <label>*ระดับSkill</label>
                <select id="ocmLevelSkill" required  name="ocmLevelSkill" class="form-control form-select ">
                    <option value="" >โปรดเลือก</Option>
                    <option value="0"<?= ($tLevelSkill == '') ? 'selected' : ''; ?>>ไม่มี</Option>
                    <option value="2"<?= ($tLevelSkill == '2') ? 'selected' : ''; ?>>พอใช้</Option>
                    <option value="3"<?= ($tLevelSkill == '3') ? 'selected' : ''; ?>>ดี</Option>
                    <option value="4"<?= ($tLevelSkill == '4') ? 'selected' : ''; ?>>ดีมาก</Option>
                </select>
            </div>

            <div>
            <input type="hidden" id="oetFilterGrpPage" value="<?= $nPage ?>">
            </div>

        </form>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <a href="<?php echo base_url('index.php/tpjSKRPageSkillRecord') ?> " style="cursor='pointer'">
            << ย้อนกลับ</a>
    </div>
    <div class="col-md-6 text-end" style="z-index:10000">
        <button type="botton" class="btn btn-primary" onclick="JSxSKRUpdateMySkill()">บันทึก</button>
    </div>
</div>


<script>
   function JSxSKRUpdateMySkill() {
    if($("#oetSkillName").val() == ''){
            $("#oetSkillName").focus();
        }else if($("#ocmLevelSkill").val() == ''){
            $("#ocmLevelSkill").focus();
        }else {
            var nPage = $("#oetFilterGrpPage").val()
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventUpdateMySkill') ?>",
            data: {
                "oetSkillcode": $("#oetSkillcode").val(),
                "oetSkillname": $("#oetSkillname").val(),
                "ocmLevelSkill": $("#ocmLevelSkill").val(),
                // "ocmRoleSkill": $("#ocmRoleSkill").val(),
                // "oetSkillStatus": $("#oetSkillStatus").val(),
                "nPage": nPage,
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                if (tResult == 'success') {
                    localStorage.setItem('page', nPage)
                    window.location.href = '<?= base_url('/index.php/tpjSKRPageSkillRecord') ?>';
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