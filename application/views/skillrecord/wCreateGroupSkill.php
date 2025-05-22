<?php include(APPPATH . 'views/wHeader.php') ?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/ada.titlebar.css'); ?>" />
<html>
<title>
    <?= $tTitle ?>
</title>

<body>
    <img src="<?php echo base_url('/assets/WorkingBg.png'); ?>" style="opacity: 0.2; position: absolute;
    right: 0px;
    bottom: 0px; width: 50%; z-index:-10000"></img>


	<?php include(APPPATH. 'views/menu/wMenu.php') ?>
    <div  class="container-fluid" style="margin-top:10px">
        <div class="row" style="margin-top:15px">
            <!-- <div class="col-md-12">
                <h5>ข้อมูลโปรเจ็ค</h5>
            </div> -->
            <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">เพิ่มกลุ่มทักษะ</div>
            <div class="col-md-12">
                <form>
                <div class="form-group col-md-12 input-data">
                        <label for="message">แผนก:</label>
                      
                        <input type="text" class="form-control" value="<?=$UsrDevName?>" disabled="true">
                        <input type="hidden" id="oetDepCode" name="oetDepCode" class="form-control" value="<?=$UsrDepCode?>">
                        
                    </div>
                    <div class="form-group">
                        <label>*กลุ่มทักษะ</label>
                      
                        <input type="text" class="form-control" id="oetGroupskillname" name="oetGroupskillname"
                        required maxlength="50">
                        </input>
                    </div>
                    
                    <hr />
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo base_url('index.php/tpjSKRPageGroupSkill') ?> " style="cursor='pointer'">
                                << ย้อนกลับ</a>
                        </div>
                        <div class="col-md-6 text-end" style="z-index:10000">
                            <button type="botton" class="btn btn-primary" required onclick="JSxSKRSavegroupskill()">บันทึก</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

</body>

</html>

<script>
    function JSxSKRSavegroupskill() {
        if($("#oetGroupskillname").val() == ''){
            $("#oetGroupskillname").focus();
        }else{
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventAddGroupskill') ?>",
            data: {
                "oetGroupskillname": $("#oetGroupskillname").val(),
                "oetDepCode": $("#oetDepCode").val(),
            },
            cache: false,
            timeout: 1000,
            success: function (tResult) {

                // console.log('test')
                    // console.log(tResult)
                if (tResult == 'success') {
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
