<?php
$tGrpSkgCode = $aGrpSkillStart['raItems'][0]["FTSkgCode"];
$tGrpSkgName = $aGrpSkillStart['raItems'][0]["FTSkgGrpName"];
?>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">แก้ไขกลุ่มทักษะ</div>
    <div class="col-md-12">
        <form>
                <div class="form-group col-md-12 input-data">
                        <label for="message">แผนก:</label>
                      
                        <input type="text" class="form-control" value="<?=$UsrDevName?>" disabled="true">
                        <input type="hidden" id="oetDepCode" name="oetDepCode" class="form-control" value="<?=$UsrDepCode?>">
                        
                    </div>
            <div class="form-group">
                <label>*กลุ่มทักษะ</label>
                <input type="hidden" class="form-control" id="oetGroupskillcode" name="oetGroupskillcode"
                    value="<?= $tGrpSkgCode ?>">
                <input type="text" class="form-control" id="oetGroupskillname" name="oetGroupskillname" required maxlength="50"
                    value="<?= $tGrpSkgName ?>" >
                </input>
            </div>
            <div>
            <input type="hidden" id="oetFilterGrpPage" value="<?= $nPage ?>">
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <a href="<?php echo base_url('index.php/tpjSKRPageGroupSkill') ?> " style="cursor='pointer'">
            << ย้อนกลับ</a>
    </div>
    <div class="col-md-6 text-end" style="z-index:10000">
        <button type="botton" class="btn btn-primary" onclick="JSxSKRUpdategroupskill()">บันทึก</button>
    </div>
</div>


<script>
    function JSxSKRUpdategroupskill() {
        if($("#oetGroupskillname").val() == ''){
            $("#oetGroupskillname").focus();
        }else{
            var nPage = $("#oetFilterGrpPage").val()
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventUpdateGroupskill') ?>",
            data: {
                "oetGroupskillcode": $("#oetGroupskillcode").val(),
                "oetGroupskillname": $("#oetGroupskillname").val(),
                "oetDepCode": $("#oetDepCode").val(),
                "nPage": nPage,
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                if (tResult == 'success') {
                    localStorage.setItem('page', nPage)
                    window.location.href = '<?= base_url('/index.php/tpjSKRPageGroupSkill') ?>';
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