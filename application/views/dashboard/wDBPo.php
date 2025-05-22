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
        <div class="row mt-4">
            <div class="col-xl-12">
                <div class="row align-items-end">
                    <div class="col-sm-6 col-md-2 pe-0" style="padding-right:2px !important">
                        <label>ลูกค้า</label>
                        <div class="dropdown">
                            <button class="btn border dropdown-toggle form-control d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="flex-grow-1 text-start">เลือกตัวเลือก</span>
                            </button>
                            <ul class="dropdown-menu p-3" style="min-width: 200px;">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ocbDBSelectAllCustomer">
                                        <label class="form-check-label" for="ocbDBSelectAllCustomer">ทั้งหมด</label>
                                    </div>
                                </li>
                                <?php foreach($aPoSelectFrom as $aPoFrom){ ?>
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input checkboxCustomer" type="checkbox" value="<?=$aPoFrom['FTPoFrom']?>" id="ocbDBPoFrom<?=$aPoFrom['FTPoFrom']?>" name="ocbDBPoFrom<?=$aPoFrom['FTPoFrom']?>">
                                            <label class="form-check-label" for="ocbDBPoFrom<?=$aPoFrom['FTPoFrom']?>"><?=$aPoFrom['FTPoFrom']?></label>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 p-0" style="padding-right:2px !important">
                        <label>To</label>
                        <div class="dropdown">
                            <button class="btn border dropdown-toggle form-control d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="flex-grow-1 text-start">เลือกตัวเลือก</span>
                            </button>
                            <ul class="dropdown-menu p-3" style="min-width: 200px;">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ocbDBSelectAllTo">
                                        <label class="form-check-label" for="ocbDBSelectAllTo">ทั้งหมด</label>
                                    </div>
                                </li>
                                <?php foreach($aPoSelectTo as $aPoTo){ ?>
                                    <li>
                                        <div class="form-check">
                                            <input class="form-check-input checkboxTo" type="checkbox" value="<?=$aPoTo['FTPoTo']?>" id="ocbDBPoTo<?=$aPoTo['FTPoTo']?>" name="ocbDBPoTo<?=$aPoTo['FTPoTo']?>" <?= $aPoTo['FTPoTo'] == 'Adasoft'? 'checked' : '' ?>>
                                            <label class="form-check-label" for="ocbDBPoTo<?=$aPoTo['FTPoTo']?>"><?=$aPoTo['FTPoTo']?></label>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2 p-0" style="padding-right:2px !important">
                        <label>Phase</label>
                        <div class="dropdown">
                            <button class="btn border dropdown-toggle form-control d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="flex-grow-1 text-start">เลือกตัวเลือก</span>
                            </button>
                            <ul class="dropdown-menu p-3" style="min-width: 200px;">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ocbDBSelectAllPhase">
                                        <label class="form-check-label" for="ocbDBSelectAllPhase">ทั้งหมด</label>
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
                                            <input class="form-check-input checkbox" type="checkbox" value="<?=$nIndex?>" id="ocbDBPoStatus<?=$nIndex?>" name="ocbDBPoStatus<?=$nIndex?>" <?= ($nIndex != 8 && $nIndex != 9) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="ocbDBPoStatus<?=$nIndex?>"><?=$aRowPoStatus?></label>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 p-0" style="padding-right:2px !important">
                        <label for="odpDBFromDate">จากวันที่ PO</label>
                        <div class="input-group">
                            <input type="text" id="odpDBFromDate" name="odpDBFromDate" class="form-control datepicker" placeholder="dd/mm/yyyy" value="<?= isset($aPoSelectDate) ? date('d/m/Y', strtotime($aPoSelectDate->FDPoStartDate)) : ''; ?>">
                            <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 p-0" style="padding-right:2px !important">
                        <label for="odpDBToDate">ถึงวันที่</label>
                        <div class="input-group">
                            <input type="text" id="odpDBToDate" name="odpDBToDate" class="form-control datepicker" placeholder="dd/mm/yyyy" value="<?= isset($aPoSelectDate) ? date('d/m/Y', strtotime($aPoSelectDate->FDPoEndDate)) : ''; ?>">
                            <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 ps-0" style="text-align:left; margin-top:20px;">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="button" onclick="JSxDBFilterData()">ค้นหา</button>
                            <a class="btn btn-primary" href="<?= site_url('docPOPageListView') ?>">จัดการใบสั่งซื้อ</a>
                        </div>
                    </div>
                    <!-- <div class="col-sm-6 col-md-1 ps-0" style="text-align:right; margin-top:20px;">
                        <a class="btn btn-primary" href="<?= site_url('docPOPageListView') ?>">จัดการใบสั่งซื้อ</a>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="row mt-4" id="odvDBDataList">
        </div>
        <div>
            <input type="hidden" id="ohdFilterDBPage" value="1">
            <input type="hidden" id="ohdFilterDBPageTrack" value="1">
        </div>
    </div>
    <script>
        var tUrlDocDBGetDataPo = '<?= base_url('/index.php/docDBGetData') ?>';
        var tUrlDocDBExportProjectUrgent = '<?= base_url('/index.php/docDBExportExcelPrjUrgent') ?>';
    </script>
    <script src="<?= base_url('assets/js/chartjs/chart.umd.js') ?>"></script>
    <script src="<?= base_url('assets/js/localjs/dashboard/jDB.js') ?>"></script>
    <script>
        
    </script>
</body>

</html>