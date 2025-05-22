<div class="modal fade" id="odvModalEditPat" tabindex="-1" aria-labelledby="obhPoTitleModalEditPat" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obhPoTitleModalEditPat"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ofmPatEdit" action="<?php echo site_url("docPOEventEditPat"); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ohdPatCodeEdit" id="ohdPatCodeEdit">
                <div class="modal-body mx-2">
                    <div class="col-md-12 mb-2">
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">งวดที่:</span>
                            </div>
                            <div class="col">
                                <span class="text-dark" id="ospPoPeriodNoEdit"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">จำนวนเงินตามงวด:</span>
                            </div>
                            <div class="col">
                                <span class="text-dark" id="ospPoPeriodAmountEdit"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">วันที่กำหนดชำระ:</span>
                            </div>
                            <div class="col">
                                <span class="text-dark" id="ospPoPeriodDueDateEdit"></span>
                            </div>
                        </div>
                    </div>
                    <hr class="text-dark">
                    <div class="col-md-12 mb-2">
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">วันที่ชำระเงิน</span>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <input type="text" id="oetPatDateEdit" name="oetPatDateEdit" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">จำนวนเงินที่ชำระ(บาท)</span>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control text-end" id="onbPatAmountEdit" name="onbPatAmountEdit" min="0">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">วิธีการชำระเงิน</span>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <select class="form-control form-select" id="ocmPatPyMethodEdit" name="ocmPatPyMethodEdit" placeholder="เลือกสถานะ">
                                    <?php
                                    $aPoPatTypeList = [
                                        3 => 'โอนเงิน',
                                        1 => 'เงินสด',
                                        2 => 'เช็ค'
                                    ];
                                    foreach ($aPoPatTypeList as $nIndex => $aRowPoPatType) {
                                    ?>
                                        <option value="<?= $nIndex; ?>"><?= $aRowPoPatType; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">เลขอ้างอิงการชำระเงิน</span>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="oetPatRefNoEdit" name="oetPatRefNoEdit">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">หมายเหตุ</span>
                            </div>
                            <div class="col">
                                <textarea class="form-control" id="otaPatDescEdit" name="otaPatDescEdit"  rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">เอกสารยืนยันการชำระเงิน</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="file" id="oflPatFileEdit" name="oflPatFileEdit" accept=".gif, .jpg, .jpeg, .png, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf">
                                <p id="obpPoPatFilePreview">
                                </p>
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