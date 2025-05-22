<div class="modal fade" id="odvModalAddPay" tabindex="-1" aria-labelledby="obhPoTitleModalAddPay" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obhPoTitleModalAddPay">เพิ่มงวดการชำระ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ofmPayPoAdd" action="<?php echo site_url("docPOEventAddPay"); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ohdPayPoCode" id="ohdPayPoCode" value="<?= isset($aPoData) ? $aPoData['FTPoCode'] : ''; ?>">
                <div class="modal-body mx-2">
                    <div class="col-md-12 mb-2">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="text-dark" for="onbPayPoNo">งวดที่</label> <span class="text-danger">*</span>
                                <input type="number" class="form-control text-center" id="onbPayPoNo" name="onbPayPoNo" readonly>
                            </div>
                            <div class="col-6">
                                <label class="text-dark" for="oetPayName">ชื่องวด</label> <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="oetPayName" name="oetPayName">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="text-dark" for="ocmPayPoStatus">สถานะงวด</label> <span class="text-danger">*</span>
                                <select class="form-control form-select" id="ocmPayPoStatus" name="ocmPayPoStatus" placeholder="เลือกสถานะ">
                                    <?php
                                    $aPoPayTypeList = [
                                        3 => 'รอชำระ',
                                        1 => 'ชำระแล้ว',
                                        2 => 'ชำระบางส่วน'
                                    ];
                                    foreach ($aPoPayTypeList as $nIndex => $aRowPoPayType) {
                                    ?>
                                        <option value="<?= $nIndex; ?>"><?= $aRowPoPayType; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <!-- แก้การตั้งชื่อ id เป็น oetPayPoDueDate -->
                                <label for="oetPayPoDueDate" class="text-dark">วันที่กำหนดชำระ</label> <span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="text" id="oetPayPoDueDate" name="oetPayPoDueDate" class="form-control datepicker" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="row mb-0">
                                    <div class="col mb-0">
                                        <label class="text-dark" for="onbPayPoAmount">จำนวนเงิน (บาท)</label> <span class="text-danger">*</span>
                                    </div>
                                    <div class="col mb-0 text-end">
                                        <small class="text-muted" id="obpLimitAmount"></small>
                                    </div>
                                </div>
                                <input type="number" class="form-control text-end" id="onbPayPoAmount" name="onbPayPoAmount" min="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <!-- แก้การตั้งชื่อ id เป็น otaPayPoDesc -->
                                <label for="otaPayPoDesc" class="text-dark">รายละเอียดงวด</label> <span class="text-danger">*</span>
                                <textarea class="form-control" name="otaPayPoDesc" id="otaPayPoDesc" row="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>