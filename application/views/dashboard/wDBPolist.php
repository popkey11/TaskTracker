
<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
    <div class="row">
        <div class="col-md-3">
            <div class="card border rounded p-2 px-3">
                <h5 class="text-dark">มูลค่าโครงการรวม</h5>
                <h1 class="text-primary"><?= isset($nTotalPoValue['nFomat']) ? $nTotalPoValue['nFomat'] : '0' ; ?></h1>
                <h6 class="text-primary text-end"><?= isset($nTotalPoValue['nNum']) ? number_format($nTotalPoValue['nNum'],2) : '0.00' ; ?> บาท</h6>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border rounded p-2 px-3">
                <h5 class="text-dark">ชำระแล้ว</h5>
                <h1 class="text-success"><?= isset($nTotalPoPaid['nFomat']) ? $nTotalPoPaid['nFomat'] : '0' ; ?></h1>
                <h6 class="text-success text-end"><?= isset($nTotalPoPaid['nNum']) ? number_format($nTotalPoPaid['nNum'],2) : '0.00' ; ?> บาท</h6>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border rounded p-2 px-3">
                <h5 class="text-dark">ยอดค้างชำระ</h5> 
                <h1 class="text-danger"><?= isset($nTotalPoUnPaid['nFomat']) ? $nTotalPoUnPaid['nFomat'] : '0' ; ?></h1>
                <h6 class="text-danger text-end"><?= isset($nTotalPoUnPaid['nNum']) ? number_format($nTotalPoUnPaid['nNum'],2) : '0.00' ; ?> บาท</h6>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border rounded p-2 px-3">
                <h5 class="text-dark">ยอดรอชำระ (ไม่ครบกำหนด)</h5>
                <h1 class="text-secondary"><?= isset($nTotalPendingPay['nFomat']) ? $nTotalPendingPay['nFomat'] : '0' ; ?></h1>
                <h6 class="text-secondary text-end"><?= isset($nTotalPendingPay['nNum']) ? number_format($nTotalPendingPay['nNum'],2) : '0.00' ; ?> บาท</h6>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 mb-3">
    <div class="row">
        <div class="col-md-6">
            <div class="card border rounded p-3">
                <div class="row">
                    <h5 class="text-dark">สัดส่วนมูลค่าโครงการตามสถานะ</h5>
                    <div class="chart-container d-flex justify-content-center" style="width:100%;height:300px;">
                        <canvas id="ocvDBPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border rounded p-3">
                <div class="row">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <h5 class="text-dark">โครงการที่ต้องติดตามเร่งด่วน (Delay + ใกล้อีก 30 วัน)</h5>
                        <button type="button" class="btn btn-success" onclick="JSxDBExportExcelProjectUrgent()"><i class="fa fa-download" aria-hidden="true"></i> Excel</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr class="table-primary">
                                    <th>ชื่อโครงการ</th>
                                    <th>Release</th>
                                    <th>Phase</th>
                                    <th>สถานะ</th>
                                    <th>ความคืบหน้า</th>
                                    <th>กำหนดเสร็จ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $aPoStatusList = [
                                    3 => 'Requirement',
                                    1 => 'Analysys & Design',
                                    2 => 'Develop',
                                    4 => 'SIT',
                                    5 => 'UAT',
                                    6 => 'Imprement',
                                    7 => 'Golive',
                                    8 => 'Cancel',
                                    9 => 'Pre-Dev/Wait PO'
                                ];
                                if(!empty($aDBPotrackingList) && count($aDBPotrackingList) > 0){ ?>
                                    <?php foreach($aDBPotrackingList as $nKey => $aVal){ ?>
                                        <tr>
                                            <td><?= $aVal['FTPrjName'] ?></td>
                                            <td><?= $aVal['FTPoRelease'] ?></td>
                                            <td><?= $aPoStatusList[$aVal['FNPoStatus']] ?></td>
                                            <td>
                                                <?php
                                                    $today = new DateTime(); // วันนี้
                                                    $dueDate = new DateTime($aVal['FDPoEndDate']); // วันที่ครบกำหนดของ PO
                                                    
                                                    $interval = (int)$today->diff($dueDate)->format("%r%a"); // จำนวนวันห่างจากวันนี้ (บวก = อนาคต, ลบ = เลยกำหนด)         
                                                    if($interval < 0){
                                                        echo '<span class="badge text-bg-danger">เลยกำหนดการ</span>';
                                                    }else{
                                                        echo '<span class="badge text-bg-warning">ใกล้ถึงกำหนดการ</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="xWProgressBarContainer">
                                                    <div class="xWProgressBar" style="width: <?= $aVal['FNPoProgress'] ?>%;"></div>
                                                </div>
                                                <span><?= $aVal['FNPoProgress'] ?>%</span>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($aVal['FDPoEndDate'])) ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="8" class="text-center">ไม่พบข้อมูล</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        พบข้อมูล <?php echo $nTotalRecordPotracking; ?> รายการ
                        แสดงหน้า <?php echo $nCurrentPageTrack; ?>/ <label><?php echo $nTotalPagesPotracking; ?></label>
                        <input type="hidden" id="ohdTotalPageTrack" value="<?php echo $nTotalPagesPotracking; ?>">
                        <input type="hidden" id="ohdTotalRecordTrack" value="<?php echo $nTotalRecordPotracking; ?>">
                        <input type="hidden" id="ohdFilterDBPageTrack" value="<?php echo $nCurrentPageTrack; ?>">
                    </div>
                    <div class="col-md-6">
                        <nav>
                            <ul class="pagination justify-content-end">
                                <?php if ($nCurrentPageTrack == 0 or $nCurrentPageTrack == 1) { ?>
                                    <li class="page-item disabled">
                                        <a class="page-link xCNCursorPointer" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <li class="page-item">
                                        <a class="page-link xCNCursorPointer" onclick="JSxDBPreviousPageTrack()" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php }
                                $cPage = $nCurrentPageTrack;
                                $tPage = $nTotalPagesPotracking;//nTotalPagesPotracking

                                if ($tPage > 2 && $cPage == $tPage) {
                                    $ldPage = $tPage;
                                    $fdPage =  $tPage - 3;
                                } else {
                                    $fdPage =  $cPage - 2;
                                    $ldPage = $cPage + 2;
                                }

                                for ($n = 1; $n <= $nTotalPagesPotracking; $n++) {
                                    if ($n >= $fdPage && $n <= $ldPage) {
                                        if ($nCurrentPageTrack == $n) {
                                            echo '<li class="page-item active" aria-current="page">
                                                    <a class="page-link xCNCursorPointer" onclick="JSxDBSelectPageTrack(' . $n . ')">' . $n . '</a>
                                                </li>';
                                        } else {
                                            echo '<li class="page-item" aria-current="page">
                                                    <a class="page-link xCNCursorPointer" onclick="JSxDBSelectPageTrack(' . $n . ')">' . $n . '</a>
                                                </li>';
                                        }
                                    }
                                }
                                ?>
                                <li class="page-item">
                                    <a class="page-link xCNCursorPointer" onclick="JSxDBNextPageTrack()" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card border rounded p-3">
        <div class="row">
            <h5 class="text-dark">รอจ่ายชำระ (ค้าง + ใกล้อีก 30 วัน)</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr class="table-primary">
                            <th>ชื่อโครงการ</th>
                            <th width="25%">Release</th>
                            <th>เลขที่ใบเสนอราคา</th>
                            <th>เลขที่ใบสั่งซื้อ</th>
                            <th>ลูกค้า</th>
                            <th class="text-center">งวดที่</th>
                            <th class="text-center">มูลค่า (บาท)</th>
                            <th class="text-center">กำหนดชำระ</th>
                            <th>สถานะ</th>
                            <th class="text-center">รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $aPoPayTypeList = [
                            3 => 'รอชำระ',
                            1 => 'ชำระแล้ว',
                            2 => 'ชำระบางส่วน'
                        ];
                        if(!empty($aDBPoList) && count($aDBPoList) > 0){ ?>
                            <?php foreach($aDBPoList as $nKey => $aVal){ ?>
                                <tr>
                                    <td><?= $aVal['FTPrjName'] ?></td>
                                    <td><?= $aVal['FTPoRelease'] ?></td>
                                    <td><?= !empty($aVal['FTPoQttNo']) ? $aVal['FTPoQttNo'] : '-' ; ?></td>
                                    <td><?= $aVal['FTPoDocNo'] ?></td>
                                    <td><?= $aVal['FTPoFrom'] ?></td>
                                    <td class="text-center"><?= $aVal['FNPayNo'] ?></td>
                                    <td class="text-end"><?= number_format($aVal['FCPayAmount'],2) ?></td>
                                    <td class="text-center"><?= date('d/m/Y', strtotime($aVal['FDPayDueDate'])) ?></td>
                                    <td>
                                        <?php
                                            $today = new DateTime(); // วันนี้
                                            $dueDate = new DateTime($aVal['FDPayDueDate']); // วันที่ครบกำหนดของ PO
                                            
                                            $interval = (int)$today->diff($dueDate)->format("%r%a"); // จำนวนวันห่างจากวันนี้ (บวก = อนาคต, ลบ = เลยกำหนด)         
                                            if($interval < 0){
                                                echo '<span class="badge text-bg-danger">เลยกำหนดชำระ</span>';
                                            }else{
                                                echo '<span class="badge text-bg-secondary">รอชำระ</span>';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="link-dark" href="<?= site_url('docPOPageEdit/' . $aVal['FTPoCode']) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                            <tr>
                                <td colspan="8" class="text-center">ไม่พบข้อมูล</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                พบข้อมูล <?php echo $nTotalRecord; ?> รายการ
                แสดงหน้า <?php echo $nCurrentPage; ?>/ <label><?php echo $nTotalPages; ?></label>
                <input type="hidden" id="ohdTotalPage" value="<?php echo $nTotalPages; ?>">
                <input type="hidden" id="ohdTotalRecord" value="<?php echo $nTotalRecord; ?>">
                <input type="hidden" id="ohdFilterDBPage" value="<?php echo $nCurrentPage; ?>">
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
                                <a class="page-link xCNCursorPointer" onclick="JSxDBPreviousPage()" aria-label="Previous">
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
                                            <a class="page-link xCNCursorPointer" onclick="JSxDBSelectPage(' . $n . ')">' . $n . '</a>
                                        </li>';
                                } else {
                                    echo '<li class="page-item" aria-current="page">
                                            <a class="page-link xCNCursorPointer" onclick="JSxDBSelectPage(' . $n . ')">' . $n . '</a>
                                        </li>';
                                }
                            }
                        }
                        ?>
                        <li class="page-item">
                            <a class="page-link xCNCursorPointer" onclick="JSxDBNextPage()" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    JSxDBGetPieChart()
    function JSxDBSelectPage(nPage) {
        $("#ohdFilterDBPage").val(nPage);
        var nPageTrack = $("#ohdFilterDBPageTrack").val();
        JStDBGetData(nPage,nPageTrack);
    }

    function JSxDBPreviousPage() {
        var cPage = $("#ohdFilterDBPage").val();
        var nPage = 0;
        if (cPage > 1) {
            nPage = cPage - 1;
            $("#ohdFilterDBPage").val(nPage);
            var nPageTrack = $("#ohdFilterDBPageTrack").val();
            JStDBGetData(nPage,nPageTrack);
        }
    }

    function JSxDBNextPage() {
        var cPage = $("#ohdFilterDBPage").val();
        var tPage = $("#ohdTotalPage").val();

        var nPage = 0;
        if (cPage < tPage) {
            nPage = parseInt(cPage) + 1;
            $("#ohdFilterDBPage").val(nPage);
            var nPageTrack = $("#ohdFilterDBPageTrack").val();
            JStDBGetData(nPage,nPageTrack);
        }
    }

    function JSxDBSelectPageTrack(nPageTrack) {
        $("#ohdFilterDBPageTrack").val(nPageTrack);
        var nPage = $("#ohdFilterDBPage").val();
        JStDBGetData(nPage,nPageTrack);
    }

    function JSxDBPreviousPageTrack() {
        var cPageTrack = $("#ohdFilterDBPageTrack").val();
        var nPageTrack = 0;
        if (cPageTrack > 1) {
            nPageTrack = cPageTrack - 1;
            $("#ohdFilterDBPageTrack").val(nPageTrack);
            var nPage = $("#ohdFilterDBPage").val();
            JStDBGetData(nPage,nPageTrack);
        }
    }

    function JSxDBNextPageTrack() {
        var cPageTrack = $("#ohdFilterDBPageTrack").val();
        var tPageTrack = $("#ohdTotalPageTrack").val();

        var nPageTrack = 0;
        if (cPageTrack < tPageTrack) {
            nPageTrack = parseInt(cPageTrack) + 1;
            $("#ohdFilterDBPageTrack").val(nPageTrack);
            var nPage = $("#ohdFilterDBPage").val();
            JStDBGetData(nPage,nPageTrack);
        }
    }

    function JSxDBGetPieChart(){
        const ctx = document.getElementById('ocvDBPieChart').getContext('2d');

        const labels = ['Requirement', 'Analysys & Design', 'Develop', 'SIT', 'UAT', 'Imprement', 'Golive']
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'ยอดเงิน',
                    data: [
                        '<?= $aTotalPoStatus['nCount3'] ?>',
                        '<?= $aTotalPoStatus['nCount1'] ?>',
                        '<?= $aTotalPoStatus['nCount2'] ?>',
                        '<?= $aTotalPoStatus['nCount4'] ?>',
                        '<?= $aTotalPoStatus['nCount5'] ?>',
                        '<?= $aTotalPoStatus['nCount6'] ?>',
                        '<?= $aTotalPoStatus['nCount7'] ?>'
                    ],
                    backgroundColor: [
                        'rgba(28, 200, 138, 0.5)',
                        'rgba(231, 74, 59, 0.5)',
                        'rgba(51, 204, 255, 0.5)',
                        'rgba(246, 194, 62, 0.5)',
                        'rgba(13, 30, 90, 0.5)',
                        'rgba(255, 136, 0, 0.5)',
                        'rgba(201, 60, 147, 0.5)'
                    ],
                    borderColor: [
                        'rgb(28, 200, 138)',
                        'rgb(231, 74, 59)',
                        'rgb(51, 204, 255)',
                        'rgb(246, 194, 62)',
                        'rgb(13, 30, 90)',
                        'rgb(255, 136, 0)',
                        'rgb(201, 60, 147)'
                    ],
                    borderWidth: 1,
                    barThickness: 40,
                }
            ]
        };

        const chart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                interaction: {
                    // เมาส์ hover จุดไหนบนกราฟ แสดง data ของแท่งนั้น
                    mode: 'index',
                    intersect: true, // true=off, false=on
                },
                responsive: true,
                plugins: {
                    legend: { 
                        display: false,
                        position: 'right',
                        labels: {
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const backgroundColor = data.datasets[0].backgroundColor[i];
                                        const borderColor = data.datasets[0].borderColor[i];
                                        const value = data.datasets[0].data[i];
                                        return {
                                            text: 'ยอดเงิน: '+value,
                                            fillStyle: backgroundColor,
                                            strokeStyle: borderColor,
                                            lineWidth: 1,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        enabled: true
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Bar Chart'
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                    },
                },
                animation: {
                    // แสดงข้อมูลบนกราฟแท่ง
                    onComplete: function () {
                        const chart = this;
                        const ctx = chart.ctx;
                        ctx.font = Chart.helpers.fontString(12, 'normal', Chart.defaults.font.family);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        chart.data.datasets.forEach(function (dataset, i) {
                            const meta = chart.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                const data = dataset.data[index];
                                ctx.fillText(
                                    // แปลง DataType เป็น numeric, กำหนดทศนิยม
                                    Number(data).toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }),
                                    bar.x, 
                                    bar.y - 5);
                            });
                        });
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    }
</script>