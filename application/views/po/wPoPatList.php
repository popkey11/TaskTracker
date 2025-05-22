<div class="row">
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr class="table-primary">
                    <th>วันที่ชำระ</th>
                    <th>จำนวนเงิน (บาท)</th>
                    <th>วิธีการชำระ</th>
                    <th>เลขอ้างอิง</th>
                    <th>หมายเหตุ</th>
                    <th>เอกสาร</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $aPoPatTypeList = [
                    3 => 'โอนเงิน',
                    1 => 'เงินสด',
                    2 => 'เช็ค'
                ];
                if (!empty($aPatList) && count($aPatList) > 0) {
                    foreach ($aPatList as $nKey => $aRowPat) {
                ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($aRowPat['FDPatDate'])) ?></td>
                            <td><?= number_format($aRowPat['FCPatAmount'], 2) ?></td>
                            <td><?= $aPoPatTypeList[$aRowPat['FTPatPaymethod']] ?></td>
                            <td><?= ($aRowPat['FTPatRefNo']) ? $aRowPat['FTPatRefNo'] : '-' ; ?></td>
                            <td><?= ($aRowPat['FTPatDesc']) ? $aRowPat['FTPatDesc'] : '-' ; ?></td>
                            <td>
                                <?php if($aRowPat['FTPatFile'] != null){ 
                                    $fileName = basename($aRowPat["FTPatFile"]); // ตั้งชื่อให้เป็น STD
                                    $fileUrl = base_url() . $aRowPat["FTPatFile"]; // ตั้งชื่อให้เป็น STD
                                ?>
                                    <a href="<?= $fileUrl ?>" target="_blank">เรียกดู</a> <!-- เพิ่ม ID -->
                                <?php }else{ ?>
                                    -
                                <?php } ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="JSxPOModalEditPat('<?= $aRowPat['FTPatCode'] ?>','<?= $aPayData->FNPayNo ?>','<?= $aPayData->FTPayName ?>','<?= $aPayData->FCPayAmount ?>','<?= $aPayData->FDPayDueDate ?>')">จัดการ</button>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <td class="text-center" colspan="7">ยังไม่มีข้อมูลการชำระเงิน</td>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="text-start">
    <?= $btn ?>
</div>