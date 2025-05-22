<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $tTitle ?></title>
    <?php include(APPPATH . 'views/wHeader.php') ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/ada.titlebar.css'); ?>" />
    <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/projectteam/ada.po.css'); ?>" /> -->
    <style>
        /* ข้อความแสดงข้อผิดพลาดสำหรับ selectpicker ให้แสดงด้านล่าง */
        .disabled.dropdown-toggle::after {
            display: none !important
        }

        .bootstrap-select+.text-danger {
            margin-top: 5px;
            display: block;
        }
    </style>
</head>

<body>
    <img class="xCNWorkingBg" src="<?php echo base_url('/assets/WorkingBg.png'); ?>"> </img>
    <?php include(APPPATH . 'views/menu/wMenu.php') ?>

    <div class="container my-4">
        <div class="bg-white rounded p-3 shadow">
            <h5 class="mx-2"><?= $tAction == base_url('index.php/masPJTEventEdit') ? 'แก้ไขแผนพนักงาน' : 'เพิ่มแผนพนักงาน' ?></h5>
            <hr>
            <form id="ofmPjtAddData" method="POST" action="<?= $tAction ?>" enctype="multipart/form-data" class="mt-4">
                <?php
                if (isset($aData)) {
                    echo '<input type="hidden" name="ohdPjtCode" value="' . $aData['FTPrjCode'] . '">';
                    echo '<input type="hidden" name="ohdPjtRelease" value="' . $aData['FTPrjRelease'] . '">';
                    echo '<input type="hidden" name="ohdPjtDev" value="' . $aData['FTDevCode'] . '">';
                }
                ?>
                <!-- Project Code -->
                <div class="col-12 p-0 mb-3">
                    <span class="text-danger">*</span> <label for="ocmPjtCode">โครงการ</label>
                    <div class="input-group">
                        <select name="ocmPjtCode" id="ocmPjtCode" class="form-control form-select selectpicker w-100" data-live-search="true"
                            <?= isset($aData) && $aData['FTPrjCode'] != '' ? 'disabled' : '' ?> placeholder="เลือกโครงการ" data-id="ocmPjtCode">
                            <?php foreach ($aProjectList as $aProject) { ?>
                                <option value="<?= $aProject['FTPrjCode'] ?>"
                                    <?= isset($aData) && $aData['FTPrjCode'] === $aProject['FTPrjCode'] ? 'selected' : '' ?>>
                                    <?= $aProject['FTPrjName'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Project Release -->
                <div class="col-12 p-0 mb-3">
                    <span class="text-danger">*</span> <label for="ocmPjtRelease">Release</label>
                    <div class="input-group">
                        <select name="ocmPjtRelease" id="ocmPjtRelease" class="form-control form-select selectpicker w-100" data-live-search="true"
                            <?= isset($aData) && $aData['FTPrjRelease'] != '' ? 'disabled' : '' ?> placeholder="เลือก Release" data-id="ocmPjtRelease">
                            <?php foreach ($aReleaseList as $aRelease) { ?>
                                <option value="<?= $aRelease['FTPrjRelease'] ?>"
                                    <?= isset($aData) && $aData['FTPrjRelease'] === $aRelease['FTPrjRelease'] ? 'selected' : '' ?>>
                                    <?= $aRelease['FTPrjRelease'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <small class="text-muted">พิมพ์เพื่อค้นหา หรือพิมพ์เพื่อเพิ่มตัวเลือกใหม่</small>
                </div>

                <!-- Developer -->
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <span class="text-danger">*</span> <label for="ocmPjtDev">พนักงาน</label>
                            <div class="input-group">
                                <select name="ocmPjtDev" id="ocmPjtDev" class="form-control form-select selectpicker w-100" data-live-search="true"
                                    <?= isset($aData) && $aData['FTDevCode'] != '' ? 'disabled' : '' ?> placeholder="เลือกพนักงาน" data-id="ocmPjtDev">
                                    <?php foreach ($aDevList as $aDev) { ?>
                                        <option value="<?= $aDev['FTDevCode'] ?>"
                                            data-pjtdevgroup="<?= $aDev['FTDevGrpTeam'] ?>"
                                            data-pjtdepgroup="<?= $aDev['FTDepCode'] ?>"
                                            <?= isset($aData) && $aData['FTDevCode'] === $aDev['FTDevCode'] ? 'selected' : '' ?>>
                                            <?= $aDev['FTDevName'] . ' (' . $aDev['FTDevNickName'] . ')' ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="oetPjtDevGroup">ทีม</label>
                            <div class="input-group">
                                <input type="text" name="oetPjtDevGroup" id="oetPjtDevGroup" class="form-control w-100"
                                    value="<?= isset($aData['FTDevGrpTeam']) ? $aData['FTDevGrpTeam'] : '' ?>" placeholder="เลือกพนักงาน" disabled>
                            </div>
                            <input type="hidden" name="ohdPjtDepCode" id="ohdPjtDepCode" value="<?= isset($aData['FTDepCode']) ? $aData['FTDepCode'] : '' ?>">
                        </div>
                    </div>
                </div>

                <!-- Start Date and End Date -->
                <div class="row mb-3">
                    <div class="col-12 col-md-6">
                        <span class="text-danger">*</span> <label for="odpPjtStartDate">วันที่เริ่มต้น</label>
                        <div class="input-group">
                            <input type="text" id="odpPjtStartDate" name="odpPjtStartDate" class="form-control" placeholder="dd/mm/yyyy"
                                value="<?= isset($aData['FDPrjPlanStart']) ? date('d/m/Y', strtotime($aData['FDPrjPlanStart'])) : '' ?>">
                            <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <span class="text-danger">*</span> <label for="odpPjtEndDate">วันที่สิ้นสุด</label>
                        <div class="input-group">
                            <input type="text" id="odpPjtEndDate" name="odpPjtEndDate" class="form-control" placeholder="dd/mm/yyyy"
                                value="<?= isset($aData['FDPrjPlanFinish']) ? date('d/m/Y', strtotime($aData['FDPrjPlanFinish'])) : '' ?>">
                            <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-12 mb-3">
                    <label for="ocbPjtIsAcive">สถานะ</label>
                    <div class="col-auto">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="ocbPjtIsAcive"
                                <?= isset($aData) && $aData['FTPrjStaActive'] == 0 ? '' : 'checked' ?>>
                            <label class="form-check-label" id="olaPjtIsActive" for="ocbPjtIsAcive">
                                <?= isset($aData) && $aData['FTPrjStaActive'] == 0 ? 'ไม่ใช้งาน' : 'ใช้งาน' ?>
                            </label>
                            <input type="hidden" id="ohdPjtIsAcive" name="ohdPjtIsAcive" value="<?= isset($aData['FTPrjStaActive']) && $aData['FTPrjStaActive'] == 0 ? '0' : '1' ?>">
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="<?= base_url('/index.php/masPJTPageListView') ?>" class="btn btn-outline-secondary">
                            << ย้อนกลับ</a>
                    </div>
                    <div>
                        <?php
                        if (!isset($aData)) {
                            echo '<button type="reset" class="btn btn-outline-dark">ล้างข้อมูล</button>';
                        }
                        ?>
                        <button type="submit" class="btn btn-primary">ยืนยันข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        var tUrlMasPJTPageListView = '<?= base_url('/index.php/masPJTPageListView') ?>';
    </script>
    <script src="<?= base_url('assets\js\localjs\projectteam\jProjectteamForm.js') ?>"></script>
</body>

</html>