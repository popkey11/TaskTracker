<?php include(APPPATH . 'views/wHeader.php') ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- <style>
    .Titlebar {
        padding: 10px;
        color: #ffffff;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .datepicker {
        padding: 5px !important;
    }

    .ui-datepicker .ui-datepicker-title select {
        font-size: 15px !important;
    }

    .ui-datepicker-trigger {
        margin-left: -23px !important;
        margin-top: 0px !important;
        cursor: pointer !important;
        z-index: 1;
        position: absolute;
    }

    .datepicker {
        padding: 5px !important;
    }

    /*----- Icon Button Browse Date -----*/

    .btn.xCNBtnDateTime {
        box-shadow: none !important;
        padding: 7px 10px 7px 10px !important;
        background-color: #eee !important;
        border: 1px solid #cccccc !important;
        color: #706e6e !important;
    }

    .btn.xCNBtnDateTime:hover,
    .btn.xCNBtnDateTime:active,
    .btn.xCNBtnDateTime.active {
        border: 0.5px solid #cccccc !important;
        background-color: #e9e6e6 !important;
    }

    .btn.xCNBtnDateTime>i {
        padding-top: 5px !important;
        cursor: pointer;
        float: right;
        width: 20px;
    }

    .btn.xCNBtnDateTime>img {
        padding-top: 4px !important;
        cursor: pointer;
        float: right;
        width: 20px;
    }
</style> -->

<?php include(APPPATH. 'views/menu/wMenu.php') ?>

<div class="container">
    <div class="row" style="
        margin-top: 20px;
        border: #fff 1px solid;
        box-shadow: rgba(149, 157, 165, 0.2) 2px 2px 11px 2px;
        border-radius: 2px;
        background-color: #fff;
      ">

        <div class="col-lg-12" style="margin-top: 20px">
            <form class="fromCreateJob">
                <h4 style="
              border-left: 4px solid rgb(250, 168, 25);
              margin-bottom: 20px;
              padding-left: 16px;
            ">
                    Add My Skill
                </h4>
                <hr />

                <div class="form-group">
                    <label>*Skill Name</label>
                    <select id="ocmSkillName" name="ocmSkillName" class="selectpicker border rounded "
                        data-live-search="true" data-width="100%">
                        <option value="">โปรดเลือก</option>
                        <?php foreach ($SkillList["raItems"] as $key0 => $val0) { ?>
                            <option value="<?php echo $val0["FTSkrCode"]; ?>"><?php echo $val0["FTSkrSkillName"]; ?>
                            </option>
                        <?php } ?>
                    </select>

                    <label>*Level Skill</label>
                    <select id="ocmLevelSkill" name="ocmLevelSkill" class="selectpicker border rounded " data-live-search="true" data-width="100%"
                        t">
                        <option value="">โปรดเลือก</Option>
                        <option value="1">ไม่มี</Option>
                        <option value="2">พอใช้</Option>
                        <option value="3">ดี</Option>
                        <option value="4">ดีมาก</Option>
                    </select>
                </div>


                <hr />

                <div style="float: right; margin-bottom: 15px">
                    <a href="<?php echo base_url('index.php/Skillrecord') ?> "
                        class="btn btn-outline-secondary mr-3">ย้อนกลับ</a>
                    <input onclick="JSxSKRSaveMyskill()" class="btn btn-primary btninform" value="ยืนยันข้อมูล" />
                </div>
            </form>

        </div>

    </div>
</div>

<script>
    function JSxSKRSaveMyskill() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventAddMySkill') ?>",
            data: {
                "ocmSkillName": $("#ocmSkillName").val(),
                "ocmLevelSkill": $("#ocmLevelSkill").val(),
            },
            cache: false,
            timeout: 1000,
            success: function (tResult) {
                if (tResult == 'success') {
                    window.location.href = '<?= base_url('/index.php/Skillrecord') ?>';
                } else {
                    alert("เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง")
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });
    }
</script>
