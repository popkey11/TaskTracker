<div class="modal fade" id="odvModalAddUrlPo" tabindex="-1" aria-labelledby="obhPoTitleModalAddUrlPo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obhPoTitleModalAddUrlPo">เพิ่ม URL</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ofmPoAddUrl" action="<?= site_url('docPOEventAddUrl') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" id="ohdUrlPoCode" name="ohdUrlPoCode" value="<?= isset($aPoData) ? $aPoData['FTPoCode'] : ''; ?>">
                <div class="modal-body mx-2">
                    <div class="col-md-12 mb-2">
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">ที่อยู่ URL</span>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="col">
                                <input class="form-control" type="text" id="oetPoUrlAddress" name="oetPoUrlAddress">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-3">
                                <span class="text-dark">คำอธิบาย URL</span>
                            </div>
                            <div class="col">
                                <textarea class="form-control" id="otaPoUrlDesc" name="otaPoUrlDesc"  rows="3"></textarea>
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