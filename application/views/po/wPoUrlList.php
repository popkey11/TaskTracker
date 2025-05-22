<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr class="table-primary">
                <th width="5%">ลำดับ</th>
                <th width="40%">URL</th>
                <th>คำอธิบาย</th>
                <th>วันที่เพิ่ม</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(!empty($aUrlData) && count($aUrlData) > 0){
            ?>
                <?php foreach($aUrlData as $nKey => $aValue){ ?>
                    <tr>
                        <td><?= $nKey+1 ?></td>
                        <td><?= $aValue['FTPoUrlAddress'] ?></td>
                        <td><?= $aValue['FTPoUrlDesc'] ?></td>
                        <td><?= date('d/m/Y', strtotime($aValue['FDPoUrlCreateAt'])) ?></td>
                        <td>
                            <button class="btn btn-danger" id="obtPoDelDataUrl" data-nurlid="<?= $aValue['FNPoUrlID'] ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            <?php
            }else{
            ?>
                <tr>
                    <td class="text-center" colspan="6">ยังไม่มีเอกสารที่เกี่ยวข้อง</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>