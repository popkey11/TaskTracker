<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $tTitle ?></title>
    <?php include(APPPATH . 'views/wHeader.php') ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/ada.titlebar.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/po/ada.po.css'); ?>" />
    <style>
        /* ข้อความแสดงข้อผิดพลาดสำหรับ selectpicker ให้แสดงด้านล่าง */
        .bootstrap-select+.text-danger {
            margin-top: 5px;
            display: block;
        }

        button.active{
            color: #fff !important;
        }

        .nav-pills .nav-link{
            color: #000;
            background-color: #e9e3e3;
        }

        .nav-pills .nav-link:disabled{
            color: #6c757d;
            background-color: #e9e3e3;
        }

        .ui-datepicker{
            z-index: 99999 !important;
        }
    </style>
</head>

<body>
    <img class="xCNWorkingBg" src="<?php echo base_url('/assets/WorkingBg.png'); ?>"> </img>
    <?php include(APPPATH . 'views/menu/wMenu.php') ?>

    <div class="container-fluid my-4">
        <ul class="nav nav-pills mb-3 gap-2" id="pills-tab" role="tablist"> <!-- เพิ่ม STD ID -->
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="obtPoInfoTab" data-bs-toggle="pill" href="#odvPoInfoPanel" data-bs-target="#odvPoInfoPanel" type="button" role="tab" aria-controls="odvPoInfoPanel" aria-selected="true">ข้อมูลทั่วไป</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="obtPoPaymentTab" data-bs-toggle="pill" href="#odvPoPaymentPanel" data-bs-target="#odvPoPaymentPanel" type="button" role="tab" aria-controls="odvPoPaymentPanel" aria-selected="false" <?= ($tActionTitle === 'addPo') ? 'disabled' : null ; ?>>งวดการชำระเงิน</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="obtPoMandayTab" data-bs-toggle="pill" href="#odvPoMandayPanel" data-bs-target="#odvPoMandayPanel" type="button" role="tab" aria-controls="odvPoMandayPanel" aria-selected="false" <?= ($tActionTitle === 'addPo') ? 'disabled' : null ; ?>>Man/Day</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="obtPoAttachDocTab" data-bs-toggle="pill" href="#odvPoAttachDocPanel" data-bs-target="#odvPoAttachDocPanel" type="button" role="tab" aria-controls="odvPoAttachDocPanel" aria-selected="false" <?= ($tActionTitle === 'addPo') ? 'disabled' : null ; ?>>เอกสารแนบ</button>
            </li>
        </ul>
        <div class="row mx-md-4 mx-sm-3 mx-0 mt-4">
            <div class="col-md-12">
                <div class="card border rounded p-3 mb-3">
                    <div class="row mb-2">
                        <div class="col-4">
                            <span class="text-dark">โครงการ:</span>
                            <span class="text-dark">
                                <?php foreach ($aProjectList as $tTeam) { ?>
                                    <?= (isset($aPoData) && $aPoData['FTPrjCode'] == $tTeam["FTPrjCode"]) ? $tTeam["FTPrjName"] : ''; ?>
                                <?php } ?>
                            </span> 
                            <!-- ปรับ Query เพิ่มการ Join table Project -->
                        </div>
                        <div class="col-4">
                            <span class="text-dark">เลขที่ PO:</span>
                            <span class="text-dark">
                                <?= isset($aPoData) ? $aPoData['FTPoDocNo'] : ''; ?>
                            </span>
                        </div>
                        <div class="col-4">
                            <span class="text-dark">วันที่ PO:</span>
                            <span class="text-dark">
                                <?= (isset($aPoData) && !empty($aPoData['FDPoQttDate'])) ?  date('d/m/Y', strtotime($aPoData['FDPoQttDate']))  : ''; ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <span class="text-dark">มูลค่า PO:</span>
                            <span class="text-dark">
                                <?= isset($aPoData) ? number_format($aPoData['FCPoValue'],2) : '0.00'; ?> บาท
                            </span>
                        </div>
                        <div class="col-4">
                            <span class="text-dark">ชำระแล้ว:</span>
                            <span class="text-dark">
                                <?= isset($aTotalPatAmount) ? number_format($aTotalPatAmount,2) : '0.00' ; ?> บาท
                            </span>
                        </div>
                        <div class="col-4">
                            <span class="text-dark">คงเหลือ:</span>
                            <span class="text-dark">
                                <?php
                                    if(isset($aPoData) && isset($aTotalPatAmount)){
                                        $nPoBalance = $aPoData['FCPoValue'] - $aTotalPatAmount;
                                        echo number_format($nPoBalance,2);
                                    }else{
                                        echo '0.00';
                                    }
                                ?> บาท
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="odvPoInfoPanel" role="tabpanel" aria-labelledby="obtPoInfoTab" tabindex="0">
                <?php include(APPPATH . 'views/po/wPoInfo.php') ?>
            </div>
            <div class="tab-pane fade" id="odvPoPaymentPanel" role="tabpanel" aria-labelledby="obtPoPaymentTab" tabindex="0">
                <?php include(APPPATH . 'views/po/wPoPayment.php') ?>
            </div>
            <div class="tab-pane fade" id="odvPoMandayPanel" role="tabpanel" aria-labelledby="obtPoMandayTab" tabindex="0">
                <?php include(APPPATH . 'views/po/wPoManday.php') ?>
            </div>
            <div class="tab-pane fade" id="odvPoAttachDocPanel" role="tabpanel" aria-labelledby="obtPoAttachDocTab" tabindex="0">
                <?php include(APPPATH . 'views/po/wPoDoc.php') ?>
            </div>
        </div>
    </div>
    <input type="hidden" id="ohdPoCode" value="<?= isset($aPoData) ? $aPoData['FTPoCode'] : ''; ?>">
    <input type="hidden" id="ohdPoValue" value="<?= isset($aPoData) ? $aPoData['FCPoValue'] : ''; ?>">
    <input type="hidden" id="ohdPayAmount" value="<?= isset($nPaySumAmount) ? $nPaySumAmount : ''; ?>">
    <!-- Modal -->
     <?php include(APPPATH . 'views/po/modal/wPoAddPay.php') ?>
     <?php include(APPPATH . 'views/po/modal/wPoEditPay.php') ?>
     <?php include(APPPATH . 'views/po/modal/wPoAddPat.php') ?>
     <?php include(APPPATH . 'views/po/modal/wPoEditPat.php') ?>
     <?php include(APPPATH . 'views/po/modal/wPoAddDoc.php') ?>
     <?php include(APPPATH . 'views/po/modal/wPoAddUrl.php') ?>
    <!-- Modal -->

    <script>
        var tUrlDocPOPageListView = '<?= site_url('docPOPageListView') ?>';
        var tUrlDocPOGetDataPay = '<?= base_url('/index.php/docPOGetDataPay') ?>';
        var tUrlDocPOGetDataPayEdit = '<?= base_url('/index.php/docPOGetDataPayEdit') ?>';
        var tUrlDocPOGetDataPat = '<?= base_url('/index.php/docPOGetDataPat') ?>';
        var tUrlPODeleteDataDocID = '<?= site_url('docPOEventDeleteDataDoc') ?>';
        var tUrlPODeleteDataUrlID = '<?= site_url('docPOEventDeleteDataUrl') ?>';
        var tUrlPODeleteDataPay = '<?= site_url('docPOEventDeleteDataPay') ?>';
        var tUrlDocPOGetDataPatEdit = '<?= base_url('/index.php/docPOGetDataPatEdit') ?>';
        var tUrlPOLastPayNo = '<?= base_url('/index.php/docPOGetLastPayNo') ?>';
    </script>
    <script src="<?= base_url('assets/js/localjs/po/jPoForm.js') ?>"></script>
</body>

</html>