<div class="row mx-md-4 mx-sm-3 mx-0 mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <h5 class="mx-2 text-dark">งวดการชำระเงิน</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#odvModalAddPay" onclick="JSxPOLastNoRunningPay('<?= $aPoData['FCPoValue'] ?>')" <?= isset($nPaySumAmount) && $nPaySumAmount >= $aPoData['FCPoValue'] ? 'disabled' : '' ?>>+เพิ่มงวดการชำระ</button>
        </div>
        <hr class="text-dark">
        <div class="row" id="odvPoPayList"></div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <a class="xCNCursorPointer" id="oahBtnBack">
                << ย้อนกลับ
                    </a>
            <!-- <a href="<?= base_url('/index.php/docPOPageListView') ?>" class="xCNCursorPointer" id="oahBtnBackHide" style="display: none">
                << ย้อนกลับ
                    </a> -->
        </div>
    </div>
</div>
