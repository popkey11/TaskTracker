<?php include(APPPATH . 'views/wHeader.php') ?>

<style>
.Titlebar {
    padding: 10px;
    color: #ffffff;
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


    <div class="container-fluid" style="margin-top:10px">

        <div class="row" style="margin-top:15px">
            <!-- <div class="col-md-12">
                <h5>ข้อมูลโปรเจ็ค</h5>
            </div> -->
            <div class="col-md-8">

                <table widht="100%">
                    <tr>
                        <td>แผนก
                            <?php
                            // print_r($UsrInfo);
                            $tUsrDepCode = trim($UsrInfo['raItems'][0]['FTDepCode']);
                            $tUsrDepName =  trim($UsrInfo['raItems'][0]['FTDepName']);

                            ?>
                            <input type="text" value="<?= $tUsrDepName ?>" class="form-control" disabled>
                            <input type="hidden" id="oetDevSearch" name="oetDevSearch" value="<?= $tUsrDepCode ?>"
                                class="form-control">
                            <!-- <select name="oetDevSearch" id="oetDevSearch" class="form-control" onchange="ResetPage()">
                                <option value="">ทั้งหมด</option>
                                <?php //foreach($DepartmentList["raItems"] as $key1=>$val1){ 
                                ?>
                                <option value="<?= $val1["FTDepCode"] ?>"><?= $val1["FTDepName"] ?></option>
                                <?php //} 
                                ?>
                            </select> -->
                        </td>
                        <td width="70%">
                            ค้นหา
                            <div class="input-group  ">
                                <input type="text" name="oetLikeSearch" id="oetLikeSearch" class="form-control"
                                    placeholder="กรอกคำค้นหา">
                                <button class="btn btn-primary" type="button" onclick="FilterData()">ค้นหา</button>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="col-md-4 text-right" style="text-align:right">
                <button type="button" class="btn btn-primary" onclick="AddNewProject()">+ สร้างโปรเจ็ค</button>
            </div>
        </div>

        <div class="row" style="margin-top:10px" id="odvProjectList">
            ..
        </div>

        <div>
            <input type="hidden" id="oetFilterProjectPage" value="1">
        </div>

    </div>






</body>

</html>

<script>
$(document).ready(function() {
    GetProject();
});

function FilterData() {

    $("#oetFilterProjectPage").val(1);
    GetProject()
}

function GetProject() {

    var tDevSearch = $("#oetDevSearch").val()
    var tLikeSearch = $("#oetLikeSearch").val()
    var nPage = $("#oetFilterProjectPage").val()


    $.ajax({
        type: "POST",
        url: "<?= base_url('/index.php/GetProject') ?>",
        data: {
            "tDevSearch": tDevSearch,
            "tLikeSearch": tLikeSearch,
            "nPage": nPage
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $("#odvProjectList").html(tResult)
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        }
    });

}

//สร้างโปรเจ็คใหม่
function AddNewProject() {
    $('#add_modal').modal('show');
    window.location.href = 'AddNewProject';
}

function DeleteProject(tPrjCode) {
    if (confirm("ยืนยันการลบโปรเจ็คที่เลือกใช่หรือไม่?")) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/DeleteProject') ?>",
            data: {
                "tPrjCode": tPrjCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                GetProject()
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
            }
        });
    }
}

function EditProject(tPrjCode) {
    window.location.href = 'EditProject/' + tPrjCode;
}

function ResetPage() {
    $("#oetFilterProjectPage").val(1);
}
</script>
