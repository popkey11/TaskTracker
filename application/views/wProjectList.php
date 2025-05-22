<div class="col-md-12">
    <table class="table table-sm">
        <thead>
            <tr>
                <th>รหัส</th>
                <th>ชื่อโครงการ</th>
                <th>แผนก</th>
                <!-- <th class="text-center">ใบสั่งซื้อ</th> -->
                <th>ลบ</th>
                <th>แก้ไข</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if ($ProjectList['rtCode'] == '200') {
                foreach ($ProjectList["raItems"] as $key0 => $val0) {
                    $tPrjCode = $val0["FTPrjCode"];
            ?>
                    <tr>
                        <td><?php echo $val0["FTPrjCode"]; ?></td>
                        <td><?php echo $val0["FTPrjName"]; ?></td>
                        <td><?php echo $val0["FTDepName"]; ?></td>
                        <!-- <td class="text-center"><a href="<?php echo base_url('index.php/docPOPageListView/' . $val0["FTPrjCode"] . ''); ?>"><?php echo 'จัดการ'; ?></a></td> -->
                        <td><img src="<?php echo base_url('/assets/bin.png'); ?>" style="width:12px;cursor:pointer" onclick="DeleteProject('<?= $tPrjCode ?>')"></td>
                        <td><img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer" onclick="EditProject('<?= $tPrjCode ?>')"> </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">ไม่พบข้อมูลโปรเจ็ค</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="col-md-6">
    พบข้อมูล <?php echo $ProjectList["total_record"]; ?> รายการ
    แสดงหน้า <?php echo $ProjectList["current_page"]; ?>/ <label><?php echo $ProjectList["total_pages"]; ?></label>
    <input type="hidden" id="oetTotalPage" value="<?php echo $ProjectList['total_pages']; ?>">
</div>
<div class="col-md-6">
    <nav>
        <ul class="pagination justify-content-end">
            <?php if ($ProjectList["current_page"] == 0 or $ProjectList["current_page"] == 1) { ?>
                <li class="page-item disabled">
                    <a class="page-link xCNCursorPointer" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="page-item">
                    <a class="page-link xCNCursorPointer" onclick="PreviousPage()" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php }
            $cPage = $ProjectList["current_page"];
            $tPage = $ProjectList["total_pages"];

            if ($tPage > 2 && $cPage == $tPage) {
                $ldPage = $tPage;
                $fdPage =  $tPage - 3;
            } else {
                $fdPage =  $cPage - 2;
                $ldPage = $cPage + 2;
            }

            for ($n = 1; $n <= $ProjectList["total_pages"]; $n++) {
                if ($n >= $fdPage && $n <= $ldPage) {
                    if ($ProjectList["current_page"] == $n) {
                        echo '<li class="page-item active" aria-current="page">
                                <a class="page-link xCNCursorPointer" onclick="SelectPage(' . $n . ')">' . $n . '</a>
                              </li>';
                    } else {
                        echo '<li class="page-item" aria-current="page">
                                <a class="page-link xCNCursorPointer" onclick="SelectPage(' . $n . ')">' . $n . '</a>
                              </li>';
                    }
                }
            }
            ?>
            <li class="page-item">
                <a class="page-link xCNCursorPointer" onclick="NextPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>



<script>
    function SelectPage(nPage) {
        $("#oetFilterProjectPage").val(nPage);
        GetProject();
    }

    function PreviousPage() {

        var cPage = $("#oetFilterProjectPage").val()
        var nPage = 0;
        if (cPage > 1) {
            nPage = cPage - 1;
            $("#oetFilterProjectPage").val(nPage)

            GetProject();
        }
    }

    function NextPage() {

        var cPage = $("#oetFilterProjectPage").val()
        var tPage = $("#oetTotalPage").val()

        var nPage = 0;
        if (cPage < tPage) {
            nPage = parseInt(cPage) + 1;
            $("#oetFilterProjectPage").val(nPage)

            GetProject();
        }
    }
</script>