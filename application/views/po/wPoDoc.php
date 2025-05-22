<div class="row mx-md-4 mx-sm-3 mx-0 mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between mb-1">
            <h5 class="mx-2 text-dark">เอกสารแนบ</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#odvModalAddDocPo">+เพิ่มเอกสารใหม่</button>
        </div>
        <div class="col-md-12 mb-2">
            <?php include(APPPATH . 'views/po/wPoDocList.php') ?>
        </div>
        <hr class="text-dark">
        <div class="d-flex justify-content-between mb-1">
            <h5 class="mx-2 text-dark">URL ที่เกี่ยวข้อง</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#odvModalAddUrlPo">+เพิ่ม URL</button>
        </div>
        <div class="col-md-12 mb-2">
            <?php include(APPPATH . 'views/po/wPoUrlList.php') ?>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <a href="<?= base_url('/index.php/docPOPageListView') ?>" class="xCNCursorPointer">
                << ย้อนกลับ
                    </a>
        </div>
    </div>
</div>