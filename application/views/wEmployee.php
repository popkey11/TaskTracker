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



	<?php include(APPPATH. 'views/menu/wMenu.php') ?>


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
                                <?php //foreach($DepartmentList["raItems"] as $key1=>$val1){ ?>
                                <option value="<?= $val1["FTDepCode"] ?>"><?= $val1["FTDepName"] ?></option>
                                <?php //} ?>
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
            <div class="col-md-4 text-right" style="text-align:right; margin-top:20px;">
                <button type="button" class="btn btn-primary" onclick="AddNewEmployee()">+ เพิ่มพนักงาน</button>
            </div>
        </div>

        <div class="row" style="margin-top:10px" id="odvEmployeetList">
            ..
        </div>

        <div>
            <input type="hidden" id="oetFilterEmpPage" value="1">
        </div>

    </div>

</body>

</html>

<script>
    $(document).ready(function () {
        GetEmployeeList();
    });

    function FilterData() {

        $("#oetFilterEmpPage").val(1);
        GetEmployeeList()
    }

    function GetEmployeeList() {

        var tDevSearch = $("#oetDevSearch").val()
        var tLikeSearch = $("#oetLikeSearch").val()
        var nPage = $("#oetFilterEmpPage").val()

        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/GetEmployee') ?>",
            data: {
                "tDevSearch": tDevSearch,
                "tLikeSearch": tLikeSearch,
                "nPage": nPage
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                // console.log(tResult)
				$("#odvEmployeetList").html(tResult);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
            }
        });

    }

    //สร้างพนักงานใหม่
    function AddNewEmployee() {
        window.location.href = 'register';

        //reset email null
        <?= set_cookie('EmailForRegister', ' ', '31556926'); ?>

        //เก็บเอาไว้ว่ามาจากหน้าไหน
        <?= set_cookie('RouteMenu', 'employee', '31556926'); ?>
    }

    function DeleteEmployee(tEmpCode) {

        if (confirm("ยืนยันการลบข้อมูลพนักงานที่เลือกใช่หรือไม่?")) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/DeleteEmployee') ?>",
                data: {
                    "tEmpCode": tEmpCode
                },
                cache: false,
                timeout: 0,
                success: function (tResult) {

                    // console.log(tResult)

                    GetEmployeeList()
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                }
            });
        }
    }

    //เข้าหน้าแก้ไขข้อมูล
    function EditEmployee(tEmpCode) {
        window.location.href = 'editmember_page/' + tEmpCode;
    }

// function EditProject(tPrjCode) {
//     window.location.href = 'EditProject/' + tPrjCode;
// }

// function ResetPage() {
//     $("#oetFilterEmpPage").val(1);
// }
</script>
