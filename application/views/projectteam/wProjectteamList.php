<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <!-- <th class="text-center">รหัส</th> -->
                    <th>ชื่อโครงการ</th>
                    <th>Release</th>
                    <th>พนักงาน</th>
                    <th>ทีม</th>
                    <th>วันที่เริ่มต้น</th>
                    <th>วันที่แผนสิ้นสุด</th>
                    <th>สถานะ</th>
                    <th class="text-center" style="width: 5%">ลบ</th>
                    <th class="text-center" style="width: 5%">แก้ไข</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($aProjectTeamList as $aPJT) {
                    if ($aPJT['FTPrjStaActive'] == '1') {
                        $aIsActive = [
                            'tClass' => 'bg-success',
                            'tText' => 'Active'
                        ];
                    } else {
                        $aIsActive = [
                            'tClass' => 'bg-danger',
                            'tText' => 'InActive'
                        ];
                    }
                    $tKey = $aPJT['FTPrjCode'] . '|' . $aPJT['FTDevCode'] . '|' . $aPJT['FTPrjRelease'];
                    $tEncodedPrjCode = urlencode(base64_encode($tKey));
                ?>
                    <tr>
                        <td><?= $aPJT['FTPrjName'] ?></td>
                        <td><?= $aPJT['FTPrjRelease'] ?></td>
                        <td><?= $aPJT['FTDevName'] ?> (<?= $aPJT['FTDevNickName'] ?>)</td>
                        <td><?= $aPJT['FTDevGrpTeam'] ?></td>
                        <td><?= date('d/m/Y', strtotime($aPJT['FDPrjPlanStart'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($aPJT['FDPrjPlanFinish'])) ?></td>
                        <td>
                            <span class="badge <?= $aIsActive['tClass'] ?>"><?= $aIsActive['tText'] ?></span>
                        </td>
                        <td class="text-center" style="width: 5%">
                            <img src="<?= base_url('/assets/bin.png'); ?>" style="margin-top:7px; width:12px;cursor:pointer" class="xWPjtDeleteData"
                                data-PrjCode="<?= $aPJT['FTPrjCode'] ?>" data-DevCode="<?= $aPJT['FTDevCode'] ?>" data-PrjRelease="<?= $aPJT['FTPrjRelease'] ?>">
                        </td>
                        <td class="text-center" style="width: 5%">
                            <a href="<?= base_url('index.php/masPJTPageEdit/' . $tEncodedPrjCode); ?>" class="xWPjtEditData">
                                <img src="<?= base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer">
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<div class="col-md-6">
    พบข้อมูล <?= $nTotalRecord; ?> รายการ
    แสดงหน้า <?= $nCurrentPage; ?>/ <label><?= $nTotalPages; ?></label>
    <input type="hidden" id="ohdTotalPage" value="<?= $nTotalPages; ?>">
    <!-- <input type="hidden" id="ohdFilterPage" value="<?= $nCurrentPage; ?>"> -->
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
                    <a class="page-link xCNCursorPointer" onclick="JSxPJTPreviousPage()" aria-label="Previous">
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
                                <a class="page-link xCNCursorPointer" onclick="JSxPJTSelectPage(' . $n . ')">' . $n . '</a>
                              </li>';
                    } else {
                        echo '<li class="page-item" aria-current="page">
                                <a class="page-link xCNCursorPointer" onclick="JSxPJTSelectPage(' . $n . ')">' . $n . '</a>
                              </li>';
                    }
                }
            }
            ?>
            <li class="page-item">
                <a class="page-link xCNCursorPointer" onclick="JSxPJTNextPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>