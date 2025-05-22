<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr class="table-primary">
                <th width="5%">ลำดับ</th>
                <th width="15%">ชื่อเอกสาร</th>
                <th>อ้างอิงจากงวด</th>
                <th width="25%">คำอธิบาย</th>
                <th>ประเภท</th>
                <th>วันที่อัปโหลด</th>
                <th>ผู้อัปโหลด</th>
                <th width="10%">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $aPoDocList = [
                1 => 'เอกสารโครงการ',
                2 => 'เอกสาร Sign-off',
                3 => 'เอกสารอื่นๆ',
            ];
            if(!empty($aDocData) && count($aDocData) > 0){
            ?>
                <?php foreach($aDocData as $nKey => $aValue){ ?>
                    <tr>
                        <td><?= $nKey+1 ?></td>
                        <td><?= $aValue['FTPoDocName'] ?></td>
                        <td class="text-start"><?= isset($aValue['FTPayName']) ? $aValue['FTPayName'] : '-' ; ?></td>
                        <td><?= (isset($aValue['FTPoDocDesc']) && !empty($aValue['FTPoDocDesc'])) ? $aValue['FTPoDocDesc'] : '-'; ?></td>
                        <td><?= $aPoDocList[$aValue['FTPoDocType']] ?></td>
                        <td><?= date('d/m/Y', strtotime($aValue['FDPoDocCreateAt'])) ?></td>
                        <td><?= $aValue['FTPoDocCreateBy'] ?></td>
                        <td>
                            <?php
                                $fileName = basename($aValue["FTPoDocFile"]);
                                $fileUrl = base_url() . $aValue["FTPoDocFile"];  
                            ?>
                            <a class="btn btn-primary" href="<?= $fileUrl ?>" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
                            <button class="btn btn-danger" id="obtPoDelDataDoc" data-ndocid="<?= $aValue['FNPoDocID'] ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            <?php
            }else{
            ?>
                <tr>
                    <td class="text-center" colspan="100%">ยังไม่มีเอกสารที่เกี่ยวข้อง</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>