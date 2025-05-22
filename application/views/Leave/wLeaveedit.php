<?php include(APPPATH . 'views/wHeader.php') ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
.Titlebar {
    padding: 10px;
    color: #ffffff;
}

.mb-2 {
    margin-bottom: 1rem;
}
</style>


<div class="row">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <h5 class="card-title">แก้ไขวันลา</h5>
            <form id="formeditleave"
                action="<?php echo base_url('index.php/Leave_Controller/edit_leave/' . $item['FTHisCode']); ?>"
                method="post">
                <div class="mb-2">
                    <label for="ocmLSType" class="form-label">ประเภทการลา</label>
                    <select class="form-control" id="ocmLSType" name="ocmLSType" required>
                        <?php foreach ($LeaveTypeList['raItems'] as $type) { ?>
                        <option value="<?php echo $type['FNTypeID']; ?>"
                            <?php if ($item['FNTypeID'] == $type['FNTypeID']) echo "selected"; ?>>
                            <?php echo $type['FTTypeName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="odpLSDateFrom" class="form-label">วันที่เริ่มต้น</label>
                            <input type="date" class="form-control" id="odpLSDateFrom" name="odpLSDateFrom"
                                value="<?php echo $item['FDDateFrom']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="odpLSDateTo" class="form-label">วันที่สิ้นสุด</label>
                            <input type="date" class="form-control" id="odpLSDateTo" name="odpLSDateTo"
                                value="<?php echo $item['FDDateTo']; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 nopadding mb-2">
                    <label for="otaLSRemark" class="form-label">เหตุผล</label>
                    <textarea id="otaLSRemark" placeholder="ระบุเหตุผล" name="otaLSRemark" class="form-control">
                    <?php echo $item['FTRemark'];?>
                    </textarea>
                    <div id="odvLSRemarkText"></div>

                </div>
        </div>
        <div class="col-md-2">
            <a href="<?php echo base_url('index.php/Leave') ?> " style="cursor='pointer'">
                << ย้อนกลับ</a>
        </div>


        <div class="text-end">
            <button type="button" class="btn btn-outline-dark" onclick="resetvalueinform()">ล้างข้อมูล</button>
            <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
        </div>
        </form>
    </div>
</div>
</div>


<script>
$('.xWSelectOptions').selectpicker();
</script>

<script type="text/javascript">
function resetvalueinform() {
    document.getElementById("formcreateleave").reset();
}
