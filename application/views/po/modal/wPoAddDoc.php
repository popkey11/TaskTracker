<div class="modal fade" id="odvModalAddDocPo" tabindex="-1" aria-labelledby="obhPoTitleModalAddDocPo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obhPoTitleModalAddDocPo">อัพโหลดเอกสารใหม่</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ofmPoAddDoc" action="<?= site_url('docPOEventAddDoc') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" id="ohdDocPoCode" name="ohdDocPoCode" value="<?= isset($aPoData) ? $aPoData['FTPoCode'] : ''; ?>">
                <div class="modal-body mx-2">
                    <div class="col-md-12 mb-2">
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">อ้างอิงงวด</span>
                            </div>
                            <div class="col">
                                <select class="form-control form-select" id="ocmDocPayCode" name="ocmDocPayCode" placeholder="เลือกประเภทเอกสาร">
                                    <option value="">เลือกงวด</option>
                                    <?php foreach ($aPaySelectNo as $nKey => $aRow) { ?>
                                        <option value="<?= $aRow['FTPayCode']; ?>"><?= $aRow['FNPayNo'] . ' - ' . $aRow['FTPayName']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">ประเภทเอกสาร</span>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <select class="form-control form-select" id="ocmPoDocType" name="ocmPoDocType" placeholder="เลือกประเภทเอกสาร">
                                    <?php
                                    $aPoDocList = [
                                        1 => 'เอกสารโครงการ',
                                        2 => 'เอกสาร Sign-off',
                                        3 => 'เอกสารอื่นๆ',
                                    ];
                                    foreach ($aPoDocList as $nIndex => $aRowPoDocType) {
                                    ?>
                                        <option value="<?= $nIndex; ?>"><?= $aRowPoDocType; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">เลือกไฟล์</span>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="file" id="oflPoDocFile" name="oflPoDocFile" accept=".gif, .jpg, .jpeg, .png, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">คำอธิบายเอกสาร</span>
                            </div>
                            <div class="col">
                                <textarea class="form-control" id="otaPoDocDesc" name="otaPoDocDesc"  rows="3"></textarea>
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