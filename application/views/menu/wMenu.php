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
<style>
    .Titlebar {
        padding: 10px;
        color: #ffffff;
    }

    .active {
        color: blue !important;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col bg-dark Titlebar" style="font-size:20px">
            <?= $tTitle ?>
        </div>

        <div class="col bg-dark Titlebar ">
            <div class="row">
                <!-- <div class="col bg-dark  text-end" style="padding-right:0 !important">
                   
                </div> -->
                <div class="col text-end">

                    <a class="btn btn-dark btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" id="createPassword">ตั้งค่ารหัสผ่าน</a></li>
                    </ul>

                    <?php echo get_cookie('TaskEmail'); ?>
                    <a style="color:#ffffff !important;" href="<?= base_url('/index.php/logout') ?>">[ออกจากระบบ]</a>
                </div>
            </div>
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
                if (get_cookie('StaAlwCreatPrj') == '2' && get_cookie('UsrDepCode') == 00002) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['docPOPageListView', 'docPOPageAdd', 'docPOPageEdit','docDBPageView']) ?>" aria-current="page" href="<?= base_url('/index.php/docDBPageView') ?>">ใบสั่งซื้อ</a>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['tpjSKRPageSkillRecord']) ?>" aria-current="page" href="<?= base_url('/index.php/tpjSKRPageSkillRecord') ?>">ข้อมูลทักษะ</a>
                    </li>
                    <?php
                } else {
                    if (get_cookie('StaAlwCreatPrj') == '3') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['ProjectList', 'AddNewProject', 'EditProject']) ?>" aria-current="page" href="<?= base_url('/index.php/ProjectList') ?>">โครงการ</a>
                        </li>
                        <?php
                        if (get_cookie('UsrDepCode') == 00005) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['docPOPageListView', 'docPOPageAdd', 'docPOPageEdit','docDBPageView']) ?>" aria-current="page" href="<?= base_url('/index.php/docDBPageView') ?>">ใบสั่งซื้อ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['masPJTPageListView', 'masPJTPageAdd', 'masPJTPageEdit']) ?>" aria-current="page" href="<?= base_url('/index.php/masPJTPageListView') ?>">แผนพนักงาน</a>
                            </li>
                        <?php
                        }
                        ?>
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

                    <?php
                    if (get_cookie('StaAlwCreatPrj') == '2') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['ProjectList', 'AddNewProject']) ?>" aria-current="page" href="<?= base_url('/index.php/ProjectList') ?>">โครงการ</a>
                        </li>
                        <?php
                        if (get_cookie('UsrDepCode') == 00005) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['docPOPageListView', 'docPOPageAdd', 'docPOPageEdit','docDBPageView']) ?>" aria-current="page" href="<?= base_url('/index.php/docDBPageView') ?>">ใบสั่งซื้อ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['masPJTPageListView', 'masPJTPageAdd', 'masPJTPageEdit']) ?>" aria-current="page" href="<?= base_url('/index.php/masPJTPageListView') ?>">แผนพนักงาน</a>
                            </li>
                        <?php
                        }
                        ?>
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

                    <?php
                    if (get_cookie('StaAlwCreatPrj') == '4') {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['docPOPageListView', 'docPOPageAdd', 'docPOPageEdit','docDBPageView']) ?>" aria-current="page" href="<?= base_url('/index.php/docDBPageView') ?>">ใบสั่งซื้อ</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['tpjSKRPageSkillRecord']) ?>" aria-current="page" href="<?= base_url('/index.php/tpjSKRPageSkillRecord') ?>">ข้อมูลทักษะ</a>
                        </li>
                    <?php }elseif(get_cookie('StaAlwCreatPrj') != '4'){ ?>

                        <li class="navbar-item">
                            <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['tpjSKRPageSkillRecord']) ?>" aria-current="page" href="<?= base_url('/index.php/tpjSKRPageSkillRecord') ?>">ข้อมูลทักษะ</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['Task', 'PageCreateNewtask']) ?>" aria-current="page" href="<?= base_url('/index.php/Task') ?>">ข้อมูลการทำงาน</a>
                        </li>
                        <li class="navbar-item">
                            <a class="nav-link <?php echo FStMNUActive($tMenuCurrent, ['masLEVLeave']) ?>" aria-current="page" href="<?= base_url('/index.php/masLEVLeave') ?>">ลางาน</a>
                        </li>
                        <!-- Test Excel -->
                        <li class="nav-item">
                            <!-- <a class="nav-link"
                            href="https://lookerstudio.google.com/u/0/reporting/1a56393f-c161-4f82-8d24-f40b27377f1d/page/aCNED?s=ryJ5gzQ8mf0"
                            target="_blank">รายงาน</a> -->
                            <a class="nav-link <?php if (empty($tDashboardURL))
                                                    echo 'd-none' ?>" href="<?= $tDashboardURL ?>" target="_blank">รายงาน</a>
                        </li>
                        
                    <?php } ?>
                    <!-- <li class="nav-item">
					<a class="nav-link" href="#">Project</a>
				</li> -->
                <?php
                }

                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="modal" tabindex="-1" id="createPasswordModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ตั้งค่ารหัสผ่าน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <input type="checkbox" name="usePassword" id="usePassword"> ใช้รหัสผ่าน
                </div>
                <div class="form-group">
                    รหัสผ่าน
                    <input type="password" name="objpassword" id="objpassword" class="form-control" placeholder="ระบุรหัสผ่าน">
                </div>
                <div class="form-group">
                    ยืนยันรหัสผ่าน
                    <input type="password" name="objconfirmpassword" id="objconfirmpassword" class="form-control" placeholder="ระบุรหัสผ่าน">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" onclick="createPassword()">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<script>
    function createPassword() {

        if ($('#objpassword').val() != $('#objconfirmpassword').val()) {

            alert('รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน');
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url('/index.php/savePassword'); ?>",
                data: {
                    'password': $('#objpassword').val()
                },
                success: function(result) {
                    if (result == 200) {
                        alert('บันทึกสำเร็จ');
                        $('#createPasswordModal').modal('hide');
                    } else {
                        alert('บันทึกไม่สำเร็จ');
                    }
                }
            })
        }

    }
    $('#createPassword').click(function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/checkemil') ?>",
            data: {
                "type": 'authorize',
                "email": '<?php echo get_cookie('TaskEmail'); ?>'
            },
            cache: false,
            timeout: 0,
            success: function(nCode) {
                console.log(nCode);
                if (nCode) {
                    $('#usePassword').prop("checked", true);
                }
                $('#objpassword').val(nCode);
                $('#createPasswordModal').modal('show');
            }
        });
    })
</script>