<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th class="text-center">รหัส</th>
                    <th>ชื่อโครงการ</th>
                    <th>Release</th>
                    <th>เลขที่เอกสาร PO</th>
                    <th>วันที่ PO</th>
                    <th>From</th>
                    <th>To</th>
                    <th class="text-center">มูลค่า PO</th>
                    <th>Phase</th>
                    <th>%</th>
                    <th>PM,SA</th>
                    <th>BD</th>
                    <th class="text-center" style="width: 5%">ลบ</th>
                    <th class="text-center" style="width: 5%">แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $aPoMapStatus = [
                    3 => 'Requirement',
                    1 => 'Analysys & Design',
                    2 => 'Develop',
                    4 => 'SIT',
                    5 => 'UAT',
                    6 => 'Imprement',
                    7 => 'Golive',
                    8 => 'Cancel',
                    9 => 'Pre-Dev/Wait PO',
                ];
                if (!empty($aPoList) && count($aPoList) > 0) {
                    foreach ($aPoList as $nKey => $aRowPo) {
                ?>
                        <tr>
                            <td class="text-center"><?= $aRowPo['FTPoCode'] ?></td>
                            <td><?= $aRowPo['FTPrjName'] ?></td>
                            <td><?= $aRowPo['FTPoRelease'] ?></td>
                            <td><?= $aRowPo['FTPoDocNo'] ?></td>
                            <td><?= date('d/m/Y', strtotime($aRowPo['FDPoDate'])) ?></td>
                            <td><?= $aRowPo['FTPoFrom'] ?? '-' ?></td>
                            <td><?= $aRowPo['FTPoTo'] ?? '-' ?></td>
                            <td class="text-end pe-2"><?= number_format($aRowPo['FCPoValue'], 2) ?></td>
                            <td><?= $aPoMapStatus[$aRowPo['FNPoStatus']] ?></td>
                            <td class="text-center px-2">
                                <div class="xWProgressBarContainer">
                                    <div class="xWProgressBar" style="width: <?= $aRowPo['FNPoProgress'] ?>%;"></div>
                                </div>
                                <span><?= $aRowPo['FNPoProgress'] ?>%</span>
                            </td>
                            <td style="width: 5%">
                                <?php
                                if (!empty($aRowPo['FTPoPMNickName']) && !empty($aRowPo['FTPoSANickName'])) {
                                    echo $aRowPo['FTPoPMNickName'] . ',' . $aRowPo['FTPoSANickName'];
                                } elseif (!empty($aRowPo['FTPoPMNickName'])) {
                                    echo $aRowPo['FTPoPMNickName'];
                                } elseif (!empty($aRowPo['FTPoSANickName'])) {
                                    echo $aRowPo['FTPoSANickName'];
                                } else {
                                    echo '<span class="text-muted">-</span>';
                                }
                                ?>
                            </td>
                            <td style="width: 5%"><?= $aRowPo['FTPoBD'] ?? '-' ?></td>
                            <td class="text-center" style="width: 5%">
                                <img src="<?php echo base_url('/assets/bin.png'); ?>" style="margin-top:7px; width:12px;cursor:pointer"
                                    class="xWPoDeleteData" data-tPoCode="<?= $aRowPo['FTPoCode'] ?>">
                            </td>
                            <td class="text-center" style="width: 5%">
                                <a href="<?= site_url('docPOPageEdit/' . $aRowPo['FTPoCode']) ?>">
                                    <img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer">
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <td class="text-center" colspan="14">ไม่พบข้อมูล</td>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<div class="col-md-6">
    พบข้อมูล <?php echo $nTotalRecord; ?> รายการ
    แสดงหน้า <?php echo $nCurrentPage; ?>/ <label><?php echo $nTotalPages; ?></label>
    <input type="hidden" id="ohdTotalPage" value="<?php echo $nTotalPages; ?>">
    <input type="hidden" id="ohdTotalRecord" value="<?php echo $nTotalRecord; ?>">
    <input type="hidden" id="ohdFilterPoPage" value="<?php echo $nCurrentPage; ?>">
    มูลค่ารวม PO <?= number_format($nTotalPoValue,2) ?> บาท
</div>
<div class="col-md-6">
    <nav>
        <ul class="pagination justify-content-end">
            <?php if ($nCurrentPage == 0 or $nCurrentPage == 1) { ?>
                <li class="page-item disabled">
                    <a class="page-link xCNCursorPointer" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="page-item">
                    <a class="page-link xCNCursorPointer" onclick="JSxPOPreviousPage()" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php }
            $cPage = $nCurrentPage;
            $tPage = $nTotalPages;

            if ($tPage > 2 && $cPage == $tPage) {
                $ldPage = $tPage;
                $fdPage =  $tPage - 3;
            } else {
                $fdPage =  $cPage - 2;
                $ldPage = $cPage + 2;
            }

            for ($n = 1; $n <= $nTotalPages; $n++) {
                if ($n >= $fdPage && $n <= $ldPage) {
                    if ($nCurrentPage == $n) {
                        echo '<li class="page-item active" aria-current="page">
                                <a class="page-link xCNCursorPointer" onclick="JSxPOSelectPage(' . $n . ')">' . $n . '</a>
                              </li>';
                    } else {
                        echo '<li class="page-item" aria-current="page">
                                <a class="page-link xCNCursorPointer" onclick="JSxPOSelectPage(' . $n . ')">' . $n . '</a>
                              </li>';
                    }
                }
            }
            ?>
            <li class="page-item">
                <a class="page-link xCNCursorPointer" onclick="JSxPONextPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<script>
    function JSxPOSelectPage(nPage) {
        $("#ohdFilterPoPage").val(nPage);
        JStPOGetData(nPage);
    }

    function JSxPOPreviousPage() {
        var cPage = $("#ohdFilterPoPage").val();
        var nPage = 0;
        if (cPage > 1) {
            nPage = cPage - 1;
            $("#ohdFilterPoPage").val(nPage);
            JStPOGetData(nPage);
        }
    }

    function JSxPONextPage() {
        var cPage = $("#ohdFilterPoPage").val();
        var tPage = $("#ohdTotalPage").val();

        var nPage = 0;
        if (cPage < tPage) {
            nPage = parseInt(cPage) + 1;
            $("#ohdFilterPoPage").val(nPage);
            JStPOGetData(nPage);
        }
    }
</script>