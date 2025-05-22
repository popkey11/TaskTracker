<html>
<?php include(APPPATH . 'views/wHeader.php') ?>
<head>
    <!-- Local CSS -->
    <link rel="stylesheet" href="<?php echo base_url("assets/po_css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/po_css/po_style.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/localcss/purchaseorder/Ada.Purchase.css"); ?>">

    <title>AdaTask Tracker</title>
</head>

<?php
function FStMNUActive($ptMenuCurrent, $ptMenuName)
{
    if (in_array($ptMenuCurrent, $ptMenuName)) {
        return 'active';
    } else {
        return '';
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col bg-dark Titlebar" style="font-size:20px">
            <?= $tTitle ?>
        </div>
        <div class="col bg-dark Titlebar text-end login-acc">
            <?php echo get_cookie('TaskEmail'); ?>
            <a style="color:#ffffff !important;" href="<?= base_url('/index.php/logout') ?>">[ออกจากระบบ]</a>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                $tMenuCurrent = $this->uri->segment(1);
                if (get_cookie('StaAlwCreatPrj') != '') {
                ?>
                    <li class="nav-item">
                        <a class="nav-link active <?php echo FStMNUActive($tMenuCurrent, ['ProjectList', 'AddNewProject']) ?>" aria-current="page" href="<?= base_url('/index.php/ProjectList') ?>">โครงการ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['Employee', 'register', 'editmember_page']) ?>" aria-current="page" href="<?= base_url('/index.php/Employee') ?>">พนักงาน</a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['tpjSKRPageGroupSkill', 'tpjSKRPageNewGroupSkill']) ?>" aria-current="page" href="<?= base_url('/index.php/tpjSKRPageGroupSkill') ?>">กลุ่มทักษะ</a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['tpjSKRPageSkill', 'tpjSKRPageNewSkill']) ?>" aria-current="page" href="<?= base_url('/index.php/tpjSKRPageSkill') ?>">ทักษะ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['masLEVLeaveManage']) ?>" aria-current="page" href="<?= base_url('/index.php/masLEVLeaveManage') ?>">จัดการลางาน</a>
                    </li>
                <?php } ?>

                <li class="navbar-item">
                    <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['tpjSKRPageSkillRecord']) ?>" aria-current="page" href="<?= base_url('/index.php/tpjSKRPageSkillRecord') ?>">ข้อมูลทักษะ</a>
                </li>
                <li class="navbar-item">
                    <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['Task']) ?>" aria-current="page" href="<?= base_url('/index.php/Task') ?>">ข้อมูลการทำงาน</a>
                </li>
                <li class="navbar-item">
                    <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['masLEVLeave']) ?>" aria-current="page" href="<?= base_url('/index.php/masLEVLeave') ?>">ลางาน</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link"
						   href="https://lookerstudio.google.com/u/0/reporting/1a56393f-c161-4f82-8d24-f40b27377f1d/page/aCNED?s=ryJ5gzQ8mf0"
						target="_blank">รายงาน</a> -->
                    <a class="nav-link <?php if (empty($tDashboardURL))
                                            echo 'd-none' ?>" href="<?= $tDashboardURL ?>" target="_blank">รายงาน</a>
                </li>
                <!-- <li class="nav-item">
					<a class="nav-link" href="#">Project</a>
				</li> -->
            </ul>
        </div>
    </div>
</nav>


<body>
    <img src="<?php echo base_url('/assets/WorkingBg.png'); ?>" style="opacity: 0.2; position: absolute;
    right: 0px;
    bottom: 0px; width: 50%; z-index:-10000"></img>
    <div class="container-fluid" style="margin-top:10px">
        <div class="row">
            <div class="col-md-3">
                <h5>โครงการ</h5>
                <div><?php echo $ProjectName; ?></div>
            </div>
        </div>
        <div class="row" style="margin-top:15px">

            <div class="col-md-3" style="padding-right:0px">
                แผนก
                <?php
                // print_r($UsrInfo);
                $tUsrDepCode = trim($UsrInfo['raItems'][0]['FTDepCode']);
                $tUsrDepName =  trim($UsrInfo['raItems'][0]['FTDepName']);

                ?>
                <input type="text" value="<?= $tUsrDepName ?>" class="form-control" disabled>
                <input type="hidden" id="oetDevSearch" name="oetDevSearch" value="<?= $tUsrDepCode ?>" class="form-control">
                <!-- <select name="oetDevSearch" id="oetDevSearch" class="form-control" onchange="ResetPage()">
                                <option value="">ทั้งหมด</option>
                                <?php //foreach($DepartmentList["raItems"] as $key1=>$val1){ 
                                ?>
                                <option value="<?= $val1["FTDepCode"] ?>"><?= $val1["FTDepName"] ?></option>
                                <?php //} 
                                ?>
                            </select> -->
            </div>
            <div class="col-md-3" style="padding-left:3px">

                <div> ค้นหา
                    <div class="input-group  ">
                        <input type="text" name="oetLikeSearch" id="oetLikeSearch" class="form-control" placeholder="กรอกคำค้นหา">
                        <button class="btn btn-primary" type="button" onclick="JSxPOFilterData()">ค้นหา</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-end" style="text-align:right">
                <input type="hidden" id="project" value="<?php echo $projectId; ?>" name="project">
                <button type="button" class="btn btn-primary mt-4" onclick="AddNewProject('<?php echo $projectId; ?>')">+
                    สร้างใบสั่งซื้อ</button>
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
        JStPOGetData();

        $('#summernote').summernote();

    });

    function FilterData() {
        $("#oetFilterProjectPage").val(1);
        JStPOGetData()
    }

    async function JStPOGetData() {
        var tDevSearch = $("#oetDevSearch").val()
        var tLikeSearch = $("#oetLikeSearch").val()
        var nPage = $("#oetFilterProjectPage").val()
        var project = $('#project').val()
        var result = $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/docPOGetData') ?>",
            data: {
                "projectId": project,
                "tLikeSearch": tLikeSearch,
                "nPage": nPage,
                "project": project
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
        return result;
    }

    //สร้างโปรเจ็คใหม่
    function AddNewProject(id) {
        $('#ohdProjectId').val(id);
        $('#add_modal').modal('show');
        // window.location.href = 'docPOAddPage';
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
                    FStPpoPo()
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
