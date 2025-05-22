<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $tTitle ?></title>
    <?php include(APPPATH . 'views/wHeader.php') ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/ada.titlebar.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/po/ada.po.css'); ?>" />
</head>

<body>
    <img class="xCNWorkingBg" src="<?php echo base_url('/assets/WorkingBg.png'); ?>"> </img>
    <?php include(APPPATH . 'views/menu/wMenu.php') ?>

    <div class="container-fluid" style="margin-top:10px">
        <div id="odvCardPO" class="container-fluid" style="margin-top:10px">
            <div class="row align-items-end" style="margin-top:15px">
                <div class="col-xl-12">
                    <div class="row align-items-end">
                        <div class="col-sm-12 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="ocmPoSearchYear">ปี</label>
                            <div class="input-group">
                                <select name="ocmPoSearchYear" id="ocmPoSearchYear"
                                    class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php
                                    foreach ($aPoSelectYear as $aYear) { ?>
                                        <option value="<?= $aYear['year'] ?>"><?= $aYear['year'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="ocmPoSearchStatus">สถานะ</label>
                            <div class="dropdown">
                                <button class="btn border dropdown-toggle form-control d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="flex-grow-1 text-start">เลือกตัวเลือก</span>
                                </button>
                                <ul class="dropdown-menu p-3" style="min-width: 200px;">
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="ocbPOSelectAllPhase">
                                            <label class="form-check-label" for="ocbPOSelectAllPhase">ทั้งหมด</label>
                                        </div>
                                    </li>
                                    <?php 
                                    $aPoStatusList = [
                                        3 => 'Requirement',
                                        1 => 'Analysys & Design',
                                        2 => 'Develop',
                                        4 => 'SIT',
                                        5 => 'UAT',
                                        6 => 'Imprement',
                                        7 => 'Golive',
                                        8 => 'Cancel',
                                        9 => 'Pre-Dev/Wait PO'
                                    ];
                                    foreach($aPoStatusList as $nIndex => $aRowPoStatus){
                                    ?>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input CheckBoxPoStatus" type="checkbox" value="<?=$nIndex?>" id="ocbPoStatus<?=$nIndex?>" name="ocbPoStatus<?=$nIndex?>">
                                                <label class="form-check-label" for="ocbPoStatus<?=$nIndex?>"><?=$aRowPoStatus?></label>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <!-- <div class="input-group">
                                <select name="ocmPoSearchStatus" id="ocmPoSearchStatus" class="form-control form-select">
                                    <option value="">ทั้งหมด</option>
                                    <option value="3">Requirement</option>
                                    <option value="1">Analysys & Design</option>
                                    <option value="2">Develop</option>
                                    <option value="4">SIT</option>
                                    <option value="5">UAT</option>
                                    <option value="6">Imprement</option>
                                    <option value="7">Golive</option>
                                    <option value="8">Cancel</option>
                                    <option value="9">Pre-Dev/Wait PO</option>
                                </select>
                            </div> -->
                        </div>
                        <div class="col-sm-6 col-md-2 p-0" style="padding-right:2px !important">
                            <label for="ocmPoSearchProject">โครงการ</label>
                            <div class="input-group">
                                <select name="ocmPoSearchProject" id="ocmPoSearchProject"
                                    class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($aProjectList as $aTeam) { ?>
                                        <option value="<?= $aTeam["FTPrjCode"]; ?>">
                                            <?= $aTeam["FTPrjName"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="ocmPoSearchFrom">From</label>
                            <div class="input-group">
                                <select name="ocmPoSearchFrom" id="ocmPoSearchFrom"
                                    class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php
                                    foreach ($aPoSelectFrom as $aPoFrom) {
                                    ?>
                                        <option value="<?= $aPoFrom['FTPoFrom'] ?>"><?= $aPoFrom['FTPoFrom'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="ocmPoSearchTo">To</label>
                            <div class="input-group">
                                <select name="ocmPoSearchTo" id="ocmPoSearchTo"
                                    class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php
                                    foreach ($aPoSelectTo as $aPoTo) {
                                    ?>
                                        <option value="<?= $aPoTo['FTPoTo'] ?>"><?= $aPoTo['FTPoTo'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="ocmPoSearchPm">PM</label>
                            <div class="input-group">
                                <select name="ocmPoSearchPm" id="ocmPoSearchPm"
                                    class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php
                                    foreach ($aPoTeamDevList as $aPoPM) {
                                    ?>
                                        <option value="<?= $aPoPM["FTDevCode"]; ?>">
                                            <?= $aPoPM["FTDevName"] . ' (' . $aPoPM['FTDevNickName'] . ')' ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="ocmPoSearchSa">SA</label>
                            <div class="input-group">
                                <select name="ocmPoSearchSa" id="ocmPoSearchSa"
                                    class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php
                                    foreach ($aPoTeamDevList as $aPoSA) {
                                    ?>
                                        <option value="<?= $aPoSA["FTDevCode"]; ?>">
                                            <?= $aPoSA["FTDevName"] . ' (' . $aPoSA['FTDevNickName'] . ')' ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="ocmPoSearchBD">BD</label>
                            <div class="input-group">
                                <select name="ocmPoSearchBD" id="ocmPoSearchBD"
                                    class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php
                                    foreach ($aPoSelectBD as $aPoBD) {
                                    ?>
                                        <option value="<?= $aPoBD['FTPoBD'] ?>">
                                            <?= $aPoBD['FTPoBD'] ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="onbPoProgress">% ความคืบหน้า</label>   
                            <input type="number" name="onbPoProgress" id="onbPoProgress" class="form-control" placeholder="กรอกเลขความคืบหน้า">     
                        </div>
                        <div class="col-sm-6 col-md-2 p-0" style="padding-right:2px !important">
                            <label for="oetPoSearch">ค้นหา</label>
                            <div class="input-group">
                                <input type="text" name="oetPoSearch" id="oetPoSearch" class="form-control"
                                    placeholder="กรอกคำค้นหา">
                                <button class="btn btn-primary w-auto" type="button" onclick="JSxPOFilterData()"><i class="fa fa-search"></i> ค้นหา</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- <div class="row align-items-end" style="margin-top:15px">
                <div class="col-xl-12">
                    <div class="row align-items-end">
                        
                    </div>
                </div>
            </div> -->
            
            <div class="row align-items-end mt-2">
                <div class="col-xl-6 p-0">
                    <div class="row justify-content-start gap-2">
                        <div class="col-auto pe-0">
                            <a href="<?= base_url('/index.php/docDBPageView') ?>" class="btn btn-primary">Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 p-0">
                    <div class="row justify-content-end gap-2">
                        <div class="col-auto p-0">
                            <a href="<?= base_url('/index.php/docPOPageAdd') ?>" id="oahPoPageAdd" class="btn btn-primary">+ สร้างใบสั่งซื้อ</a>
                        </div>
                        <div class="col-auto ps-0">
                            <button class="btn btn-primary" onclick="JSxPOExportExcel()">ส่งออก excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:10px" id="odvPoList"></div>

        <div>
            <input type="hidden" id="ohdFilterPoPage" value="1">
        </div>
    </div>
    <script>
        var tUrlDocPOGetData = '<?= base_url('/index.php/docPOGetData') ?>';
        var tUrlDocPODeleteData = '<?= base_url('/index.php/docPOEventDelete') ?>';
        var docPOEventExportExcel = '<?= base_url('/index.php/docPOEventExportExcel') ?>';
    </script>
    <script src="<?= base_url('assets/js/localjs/po/jPo.js') ?>"></script>
</body>

</html>