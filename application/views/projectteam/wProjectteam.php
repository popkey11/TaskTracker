<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $tTitle ?></title>
    <?php include(APPPATH . 'views/wHeader.php') ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/localcss/ada.titlebar.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/localcss/projectteam/ada.projectteam.css'); ?>" />
</head>

<body>
    <img class="xCNWorkingBg" src="<?= base_url('/assets/WorkingBg.png'); ?>"> </img>
    <?php include(APPPATH . 'views/menu/wMenu.php') ?>

    <div class="container-fluid" style="margin-top:10px">
        <div id="odvCardPO" class="container-fluid" style="margin-top:10px">
            <div class="row align-items-end" style="margin-top:15px">
                <div class="col-12 col-md-10">
                    <div class="row">
                        <div class="col-sm-6 col-md-2 p-0" style="padding-right:2px !important">
                            <label for="oetSearch">ค้นหา</label>
                            <div class="input-group">
                                <input type="text" name="oetSearch" id="oetSearch" class="form-control" placeholder="กรอกคำค้นหา">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-2 p-0" style="padding-right:2px !important">
                            <label for="ocmSearchDev">พนักงาน</label>
                            <div class="input-group">
                                <select name="ocmSearchDev" id="ocmSearchDev" class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($aDevList as $aDev) { ?>
                                        <option value="<?= $aDev['FTDevCode']; ?>" data-devgroup="<?= $aDev['FTDevGrpTeam'] ?>">
                                            <?= $aDev['FTDevName'] . ' (' . $aDev['FTDevNickName'] . ')' ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-1 p-0" style="padding-right:2px !important">
                            <label for="ocmSearchDevTeam">ทีม</label>
                            <div class="input-group">
                                <select name="ocmSearchDevTeam" id="ocmSearchDevTeam" class="form-control form-select ">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($aDevGroupTeamList as $aDevGroupTeam) { ?>
                                        <option value="<?= $aDevGroupTeam['FTDevGrpTeam']; ?>">
                                            <?= $aDevGroupTeam['FTDevGrpTeam']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 p-0" style="padding-right:2px !important">
                            <label for="ocmSearchProject">โครงการ</label>
                            <div class="input-group">
                                <select name="ocmSearchProject" id="ocmSearchProject" class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php foreach ($aProjectList as $aProject) { ?>
                                        <option value="<?= $aProject['FTPrjCode']; ?>">
                                            <?= $aProject['FTPrjName']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3 p-0" style="padding-right:2px !important">
                            <label for="ocmSearchRelease">Release</label>
                            <div class="input-group">
                                <select name="ocmSearchRelease" id="ocmSearchRelease" class="form-control form-select selectpicker" data-live-search="true">
                                    <option value="">ทั้งหมด</option>
                                    <?php
                                    foreach ($aReleaseList as $aRelease) {
                                    ?>
                                        <option value="<?= $aRelease['FTPrjRelease']; ?>"><?= $aRelease['FTPrjRelease']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-1 p-0 d-flex align-items-end mt-1">
                            <button class="btn btn-primary w-auto" type="button" onclick="JSxPJTFilterData()">ค้นหา</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-2 text-end">
                    <a href="<?= base_url('index.php/masPJTPageAdd') ?>" type="button" class="btn btn-primary"
                        id="oahPJTAdd">+ เพิ่มแผนพนักงาน</a>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:10px" id="odvPjtList"></div>

        <div>
            <input type="hidden" id="ohdFilterPage" value="1">
        </div>
    </div>

    <script>
        var tUrlMasPJTGetData = '<?= base_url('/index.php/masPJTGetData') ?>';
        var tUrlMasPRJDeleteData = '<?= base_url('/index.php/masPJTEventDelete') ?>';
        var aDevList = JSON.parse('<?= json_encode($aDevList) ?>');
        var aDevGroupTeamList = JSON.parse('<?= json_encode($aDevGroupTeamList) ?>');
        var aReleaseList = JSON.parse('<?= json_encode($aReleaseList) ?>');
        var aProjectList = JSON.parse('<?= json_encode($aProjectList) ?>');
        var tApiUrl = '<?= base_url('/index.php/masPJTEventFilterOption') ?>';
    </script>
    <script src="<?= base_url('assets\js\localjs\projectteam\jProjectteam.js') ?>"></script>
</body>

</html>