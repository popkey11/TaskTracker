<style>
    .xSEmpDeleted{
        color:red!important;
    }
    .xSEmpActive{
        color:#000000!important;
    }
</style>
<div class="col-md-12">
    <table class="table table-sm">
        <thead>
            <tr>
                <th>รหัส</th>
                <th>ชื่อ</th>
                <th>ชื่อเล่น</th>
                <th>อีเมล</th>
                <th>แผนก</th>
                <th>ทีม</th>
                <th>ลบ</th>
                <th>แก้ไข</th>
            </tr>
        </thead>
        <tbody>
            <?php 
          
            if($EmployeeList['rtCode'] == '200') {
            foreach($EmployeeList["raItems"] as $key0=>$val0){ 
            $tEmpCode = $val0["FTDevCode"];
            $tDevGrpTeam = $val0["FTDevGrpTeam"];
            if($tDevGrpTeam == 'DELETE'){
               $tDeleted = "xSEmpDeleted";
            }else{
               $tDeleted = "xSEmpActive";
            }
            ?>
            <tr class="<?=$tDeleted?>">
                <td><?=$val0["FTDevCode"]?></td>
                <td><?=$val0["FTDevName"]?></td>
                <td><?=$val0["FTDevNickName"]?></td>
                <td><?=$val0["FTDevEmail"]?></td>
                <td><?=$val0["FTDepName"]?></td>
                <td><?=$val0["FTDevGrpTeam"]?></td>
                <td>
                <?php if($tDevGrpTeam != 'DELETE'){  ?>
                <img src="<?php echo base_url('/assets/bin.png');?>" style="margin-top:7px; width:12px;cursor:pointer"
                        onclick="DeleteEmployee('<?=$tEmpCode?>')">
                <?php } ?>
                </td>
                <td>
                <?php if($tDevGrpTeam != 'DELETE'){  ?>    
                <img src="<?php echo base_url('/assets/edit.jpg');?>" style="width:30px;cursor:pointer"
                        onclick="EditEmployee('<?=$tEmpCode?>')"> 
                <?php } ?>
                </td>
            </tr>
            <?php
                 } 
             }else{
             ?>
            <tr>
                <td colspan="8">ไม่พบข้อมูลพนักงาน</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- การแบ่งหน้า -->
<div class="col-md-6 ">
    พบข้อมูล <?php echo $EmployeeList["total_record"];?> รายการ
    แสดงหน้า <?php echo $EmployeeList["current_page"];?>/ <label><?php echo $EmployeeList["total_pages"];?></label>
    <input type="hidden" id="oetTotalPage" value="<?php echo $EmployeeList['total_pages'];?>">
</div>
<div class="col-md-6 ">
    <nav>
        <ul class="pagination justify-content-end">
            <?php if($EmployeeList["current_page"] == 0 or $EmployeeList["current_page"]== 1){?>
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php } else { ?>
            <li class="page-item">
                <a class="page-link" href="#" onclick="PreviousPage()" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php } ?>
            <?php 
               $cPage = $EmployeeList["current_page"];
               $tPage = $EmployeeList["total_pages"];

               if($tPage > 2 and $cPage == $tPage){
                  
                  $ldPage = $tPage;
                  $fdPage =  $tPage - 3;

               }else{
                  $fdPage =  $cPage - 2;
                  $ldPage = $cPage  + 2;
               }
 
              
               for($n = 1; $n<=$EmployeeList["total_pages"];$n++) {
            ?>
            <?php  if($n >= $fdPage and $n <=$ldPage) { ?>
            <?php if($EmployeeList["current_page"] == $n){ ?>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#" onclick="SelectPage('<?=$n?>')"><?=$n?></a>
            </li>
            <? } else { ?>
            <li class="page-item" aria-current="page">
                <a class="page-link" href="#" onclick="SelectPage('<?=$n?>')"><?=$n?></a>
            </li>
            <?php } ?>
            <!-- <li class="page-item active" aria-current="page">
                        <a class="page-link" href="#"><?=$n?></a>
                    </li> -->
            <?php } ?>
            <?php  } ?>
            <li class="page-item">
                <a class="page-link" href="#" onclick="NextPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>



<script>
function SelectPage(nPage) {
    $("#oetFilterEmpPage").val(nPage);
    GetEmployeeList();
}

function PreviousPage() {

    var cPage = $("#oetFilterEmpPage").val()
    var nPage = 0;
    if (cPage > 1) {
        nPage = cPage - 1;
        $("#oetFilterEmpPage").val(nPage)

        GetEmployeeList();
    }
}

function NextPage() {

    var cPage = $("#oetFilterEmpPage").val()
    var tPage = $("#oetTotalPage").val()

    var nPage = 0;
    if (cPage < tPage) {
        nPage = parseInt(cPage) + 1;
        $("#oetFilterEmpPage").val(nPage)

        GetEmployeeList();
    }
}
</script>