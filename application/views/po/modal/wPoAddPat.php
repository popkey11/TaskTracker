<div class="modal fade" id="odvModalAddPat" tabindex="-1" aria-labelledby="obhPoTitleModalAddPat" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obhPoTitleModalAddPat"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ofmPatAdd" action="<?php echo site_url("docPOEventAddPat"); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ohdPatPayCode" id="ohdPatPayCode">
                <div class="modal-body mx-2">
                    <div class="col-md-12 mb-2">
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">งวดที่:</span>
                            </div>
                            <div class="col">
                                <span class="text-dark" id="ospPoPeriodNo"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">จำนวนเงินตามงวด:</span>
                            </div>
                            <div class="col">
                                <span class="text-dark" id="ospPoPeriodAmount"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">วันที่กำหนดชำระ:</span>
                            </div>
                            <div class="col">
                                <span class="text-dark" id="ospPoPeriodDueDate"></span>
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
                                    <!-- แก้การตั้งชื่อ id เป็น oetPatDate -->
                                    <input type="text" id="oetPatDate" name="oetPatDate" class="form-control datepicker" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0 text-end"><small class="text-muted" id="obpLimitPatAmount"></small></p>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">จำนวนเงินที่ชำระ(บาท)</span>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <input type="number" class="form-control text-end" id="onbPatAmount" name="onbPatAmount" min="0">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">วิธีการชำระเงิน</span>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <select class="form-control form-select" id="ocmPatPyMethod" name="ocmPatPyMethod" placeholder="เลือกสถานะ">
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
                                <input type="text" class="form-control" id="oetPatRefNo" name="oetPatRefNo">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">หมายเหตุ</span>
                            </div>
                            <div class="col">
                                <!-- แก้การตั้งชื่อ id เป็น otaPatDesc -->
                                <textarea class="form-control" id="otaPatDesc" name="otaPatDesc"  rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">เอกสารยืนยันการชำระเงิน</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="file" id="oflPatFile" name="oflPatFile" accept=".gif, .jpg, .jpeg, .png, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf">
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