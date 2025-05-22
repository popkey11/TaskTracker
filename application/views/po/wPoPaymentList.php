<div class="table-responsive">
    <table class="table table-sm">
        <thead>
            <tr class="table-primary">
                <th class="text-center">งวดที่</th>
                <th>ชื่องวด</th>
                <th class="text-end">จำนวน %</th>
                <th class="text-end">จำนวนเงิน (บาท)</th>
                <th class="text-center">วันที่กำหนดชำระ</th>
                <th width="40%">รายละเอียด</th>
                <th>แนบเอกสาร</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $aPoPayTypeList = [
                3 => 'รอชำระ',
                1 => 'ชำระแล้ว',
                2 => 'ชำระบางส่วน'
            ];
            if (!empty($aPayList) && count($aPayList) > 0) {
                foreach ($aPayList as $nKey => $aRowPay) {
                    $nPercent = 0;
                    if(isset($aPoList['FCPoValue']) && $aPoList['FCPoValue'] > 0){
                        $nPercent = ($aRowPay['FCPayAmount'] / $aPoList['FCPoValue']) * 100;
                    }else{
                        $nPercent = 100;
                    }
            ?>
                    <tr>
                        <td class="text-center"><?= $aRowPay['FNPayNo'] ?></td>
                        <td><?= $aRowPay['FTPayName'] ?></td>
                        <td class="text-end"><?= number_format($nPercent,2) ?>%</td>
                        <td class="text-end"><?= number_format($aRowPay['FCPayAmount'], 2) ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($aRowPay['FDPayDueDate'])) ?></td>
                        <td><?= $aRowPay['FTPayDesc'] ?></td>
                        <td class="text-center">
                            <?php if(in_array($aRowPay['FTPayCode'],$aListDoc)){ ?>
                                <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                            <?php }else{ ?>
                                <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($aRowPay['FTPayStatus'] == 1){ ?>
                                <span class="badge text-bg-success"><?= $aPoPayTypeList[$aRowPay['FTPayStatus']] ?></span>
                            <?php }else if($aRowPay['FTPayStatus'] == 2){ ?>
                                <span class="badge text-bg-warning"><?= $aPoPayTypeList[$aRowPay['FTPayStatus']] ?></span>
                            <?php }else{ ?>
                                <span class="badge text-bg-secondary"><?= $aPoPayTypeList[$aRowPay['FTPayStatus']] ?></span>
                            <?php } ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="JStPOModalEditPay('<?= $aRowPay['FTPayCode'] ?>')">จัดการ</button>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <td class="text-center" colspan="100%">ไม่พบข้อมูล</td>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>