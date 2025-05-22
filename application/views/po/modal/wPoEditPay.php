<div class="modal fade" id="odvModalEditPay" tabindex="-1" aria-labelledby="obhPoTitleModalEditPay" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obhPoTitleModalEditPay">จัดการงวดการชำระเงิน</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ofmPayPoEdit" action="<?php echo site_url("docPOEventEditPay"); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ohdPayCodeEdit" id="ohdPayCodeEdit">
                <div class="modal-body mx-2">
                    <div class="col-md-12 mb-4">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="text-dark" for="onbPayPoNoEdit">งวดที่</label> <span class="text-danger">*</span>
                                <input type="number" class="form-control text-center" id="onbPayPoNoEdit" name="onbPayPoNoEdit">
                            </div>
                            <div class="col-6">
                                <label class="text-dark" for="oetPayNameEdit">ชื่องวด</label> <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="oetPayNameEdit" name="oetPayNameEdit">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="text-dark" for="ocmPayPoStatusEdit">สถานะงวด</label> <span class="text-danger">*</span>
                                <select class="form-control form-select" id="ocmPayPoStatusEdit" name="ocmPayPoStatusEdit" placeholder="เลือกสถานะ">
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
                                <label for="oetPayPoDueDateEdit" class="text-dark">วันที่กำหนดชำระ</label> <span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="text" id="oetPayPoDueDateEdit" name="oetPayPoDueDateEdit" class="form-control" placeholder="dd/mm/yyyy">
                                    <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                </div>
                                <!-- แก้การตั้งชื่อ id เป็น oetPayPoDueDateEdit -->
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="row mb-0">
                                    <div class="col mb-0">
                                        <label class="text-dark" for="onbPayPoAmountEdit">จำนวนเงิน (บาท)</label> <span class="text-danger">*</span>                                    </div>
                                    <div class="col mb-0 text-end">
                                        <small class="text-muted" id="obpLimitAmountEdit"></small>
                                    </div>
                                </div>
                                <input type="number" class="form-control text-end" id="onbPayPoAmountEdit" name="onbPayPoAmountEdit" min="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="otaPayPoDescEdit" class="text-dark">รายละเอียดงวด</label> <span class="text-danger">*</span>
                                <textarea class="form-control" name="otaPayPoDescEdit" id="otaPayPoDescEdit" row="3"></textarea>
                            </div>
                            <!-- แก้การตั้งชื่อ id เป็น otaPayPoDueDateEdit -->
                        </div>
                        <div class="row mb-3">
                            <div class="d-flex justify-content-between">
                                <div class="mb-1">
                                    <button id="obtDeletePay" type="button" class="btn btn-danger m-1">ลบ</button>
                                </div>
                                <div class="mb-1">
                                    <button type="button" class="btn btn-secondary m-1" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary m-1">บันทึก</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <h5 class="mx-2 text-dark">ข้อมูลการชำระเงิน</h5>
                    <hr class="text-dark">
                    <div id="odvPoPatInfo"></div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div> -->
            </form>
        </div>
    </div>
</div>