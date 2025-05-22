$(document).ready(function () {
    $('.selectpicker').selectpicker();

    JStPJTGetData();
    /**
     * Functionality : Fetch data for updating dropdown options
     * Parameters : paParams (Object), ptType (String), sCallback (Function)
     * Creator : 20/11/2024 Sorawit
     * Last Modified :
     * Return : Callback with fetched data
     * ReturnType: void
     */
    function JSxPJTFetchDataOption(paParams, ptType, sCallback) {
        $.ajax({
            url: tApiUrl,
            type: 'GET',
            data: {
                ...paParams,
                tType: ptType
            },
            success: function (paResponse) {
                let aData = JSON.parse(paResponse);
                if (aData.rtStatus === 'success') {
                    sCallback(aData.rtData);
                } else {
                    sCallback([]);
                }
            },
            error: function () {
                sCallback([]);
            }
        });
    }

    /**
     * Functionality : Update Project dropdown options based on selected Developer, Team, and Release
     * Parameters : -
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Updates the Project dropdown options
     * ReturnType: void
     */
    function JSxPJTChangeOptionProject() {
        const aParams = {
            tDevCode: $('#ocmSearchDev').val(),
            tDevTeam: $('#ocmSearchDevTeam').val(),
            tRelease: $('#ocmSearchRelease').val()
        };
        const tSelectedProject = $('#ocmSearchProject').val(); // เก็บค่าที่เลือกไว้
        JSxPJTFetchDataOption(aParams, 'project', function (aProjects) {
            let oProjectSelect = $('#ocmSearchProject');
            oProjectSelect.empty().append('<option value="">ทั้งหมด</option>');
            $.each(aProjects, function (nIndex, oProject) {
                oProjectSelect.append(`<option value="${oProject.FTPrjCode}">${oProject.FTPrjName}</option>`);
            });
            if (tSelectedProject && aProjects.some(oProject => oProject.FTPrjCode === tSelectedProject)) {
                oProjectSelect.val(tSelectedProject);
            } else {
                oProjectSelect.val('');
            }
            oProjectSelect.selectpicker('refresh'); // รีเฟรช selectpicker
        });
    }


    /**
     * Functionality : Update Release dropdown options based on selected Developer, Team, and Project
     * Parameters : -
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Updates the Release dropdown options
     * ReturnType: void
     */
    function JSxPJTChangeOptionRelease() {
        const aParams = {
            tDevCode: $('#ocmSearchDev').val(),
            tDevTeam: $('#ocmSearchDevTeam').val(),
            tProjectCode: $('#ocmSearchProject').val()
        };
        const tSelectedRelease = $('#ocmSearchRelease').val(); // เก็บค่าที่เลือกไว้
        JSxPJTFetchDataOption(aParams, 'release', function (aReleases) {
            let oReleaseSelect = $('#ocmSearchRelease');
            oReleaseSelect.empty().append('<option value="">ทั้งหมด</option>');
            $.each(aReleases, function (nIndex, oRelease) {
                oReleaseSelect.append(`<option value="${oRelease.FTPrjRelease}">${oRelease.FTPrjRelease}</option>`);
            });
            if (tSelectedRelease && aReleases.some(oRelease => oRelease.FTPrjRelease === tSelectedRelease)) {
                oReleaseSelect.val(tSelectedRelease);
            } else {
                oReleaseSelect.val('');
            }
            oReleaseSelect.selectpicker('refresh'); // รีเฟรช selectpicker
        });
    }

    /**
     * Functionality : Update Developer dropdown options based on selected Release, Project, or Team
     * Parameters : -
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Updates the Developer dropdown options
     * ReturnType: void
     */
    function JSxPJTChangeOptionDeveloper() {
        const aParams = {
            tProjectCode: $('#ocmSearchProject').val(),
            tRelease: $('#ocmSearchRelease').val(),
            tDevTeam: $('#ocmSearchDevTeam').val()
        };
        const tSelectedDev = $('#ocmSearchDev').val(); // เก็บค่าที่เลือกไว้
        JSxPJTFetchDataOption(aParams, 'developer', function (aDevelopers) {
            let oDevSelect = $('#ocmSearchDev');
            oDevSelect.empty().append('<option value="">ทั้งหมด</option>');
            $.each(aDevelopers, function (nIndex, oDev) {
                oDevSelect.append(`<option value="${oDev.FTDevCode}" data-devgroup="${oDev.FTDevGrpTeam}">${oDev.FTDevName} (${oDev.FTDevNickName})</option>`);
            });
            if (tSelectedDev && aDevelopers.some(oDev => oDev.FTDevCode === tSelectedDev)) {
                oDevSelect.val(tSelectedDev); // ตั้งค่าเป็นค่าที่เลือกไว้ถ้ามีอยู่ในตัวเลือกใหม่
            } else {
                oDevSelect.val('');
            }
            oDevSelect.selectpicker('refresh'); // รีเฟรช selectpicker
        });
    }


    /**
     * Functionality : Update Team dropdown options based on selected Developer
     * Parameters : -
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Updates the Team dropdown options
     * ReturnType: void
     */
    function JSxPJTChangeOptionDevTeam() {
        const aParams = {
            tDevCode: $('#ocmSearchDev').val(),
            tProjectCode: $('#ocmSearchProject').val(),
            tRelease: $('#ocmSearchRelease').val()
        };
        const tSelectedTeam = $('#ocmSearchDevTeam').val(); // เก็บค่าที่เลือกไว้ก่อนหน้านี้
        const tSelectedDevGroup = $('#ocmSearchDev').find(':selected').data('devgroup'); // ดึงค่าทีมจากพนักงานที่ถูกเลือก

        JSxPJTFetchDataOption(aParams, 'team', function (aTeams) {
            let oTeamSelect = $('#ocmSearchDevTeam');
            oTeamSelect.empty().append('<option value="">ทั้งหมด</option>');
            $.each(aTeams, function (nIndex, oTeam) {
                oTeamSelect.append(`<option value="${oTeam.FTDevGrpTeam}">${oTeam.FTDevGrpTeam}</option>`);
            });

            // ตรวจสอบและตั้งค่าทีมจาก data-devgroup ถ้ามี
            if (tSelectedDevGroup && aTeams.some(oTeam => oTeam.FTDevGrpTeam === tSelectedDevGroup)) {
                oTeamSelect.val(tSelectedDevGroup);
            }
            // ถ้าไม่มีให้ใช้ค่าที่เลือกไว้ก่อนหน้านี้
            else if (tSelectedTeam && aTeams.some(oTeam => oTeam.FTDevGrpTeam === tSelectedTeam)) {
                oTeamSelect.val(tSelectedTeam);
            }
            // ถ้าไม่มีทั้งสองอย่างให้ตั้งค่าเป็นค่าว่าง
            else {
                oTeamSelect.val('');
            }

            oTeamSelect.selectpicker('refresh'); // รีเฟรช selectpicker
        });
    }


    /**
     * Functionality : Event listener for Developer change to update related dropdowns
     * Parameters : -
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Updates Team, Project, and Release dropdowns
     * ReturnType: void
     */
    $('#ocmSearchDev').on('change', function () {
        JSxPJTChangeOptionDevTeam();
        JSxPJTChangeOptionProject();
        JSxPJTChangeOptionRelease();
    });

    /**
     * Functionality : Event listener for Team change to update related dropdowns
     * Parameters : -
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Updates Developer, Project, and Release dropdowns
     * ReturnType: void
     */
    $('#ocmSearchDevTeam').on('change', function () {
        JSxPJTChangeOptionDeveloper();
        JSxPJTChangeOptionProject();
        JSxPJTChangeOptionRelease();
    });

    /**
     * Functionality : Event listener for Release change to update related dropdowns
     * Parameters : -
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Updates Developer and Project dropdowns
     * ReturnType: void
     */
    $('#ocmSearchRelease').on('change', function () {
        JSxPJTChangeOptionDeveloper();
        JSxPJTChangeOptionDevTeam();
        JSxPJTChangeOptionProject();
    });

    /**
     * Functionality : Event listener for Project change to update related dropdowns
     * Parameters : -
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Updates Developer and Release dropdowns
     * ReturnType: void
     */
    $('#ocmSearchProject').on('change', function () {
        JSxPJTChangeOptionDeveloper();
        JSxPJTChangeOptionDevTeam();
        JSxPJTChangeOptionRelease();
    });
});
/**
 * Functionality : Popup confirm delete data
 * Parameters : -
 * Creator : 19/11/2024 Sorawit
 * Last Modified :
 * Return : massage alert
 * Return Type : void
 */
$(document).on('click', '.xWPjtDeleteData', function () {
    let tPrjCode = $(this).data('prjcode');
    let tDevCode = $(this).data('devcode');
    let tPrjRelease = $(this).data('prjrelease');
    let bIsConfirmed = confirm('คุณต้องการลบข้อมูลใช่หรือไม่?\nข้อมูลที่ถูกลบจะไม่สามารถกู้คืนได้!');
    if (bIsConfirmed) {
        JSxPJTDeleteData(tPrjCode, tDevCode, tPrjRelease);
    }
})

/**
 * Functionality : Select Pagination button click event
 * Parameters : -
 * Creator : 19/11/2024 Sorawit
 * Last Modified :
 * Return : Text in HTML format of table data
 * Return Type : string
 * */
function JSxPJTSelectPage(nPage) {
    $("#ohdFilterPage").val(nPage);
    JStPJTGetData(nPage);
}


/**
 * Functionality : Previous page button click event
 * Parameters : -
 * Creator : 19/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 * */
function JSxPJTPreviousPage() {
    let cPage = $("#ohdFilterPage").val();
    let nPage = 0;
    if (cPage > 1) {
        nPage = cPage - 1;
        $("#ohdFilterPage").val(nPage);
        JStPJTGetData(nPage);
    }
}

/**
 * Functionality : Next page button click event
 * Parameters : -
 * Creator : 19/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 */
function JSxPJTNextPage() {
    let cPage = $("#ohdFilterPage").val();
    let tPage = $("#ohdTotalPage").val();
    let nPage = 0;
    if (parseInt(cPage) < parseInt(tPage)) {
        nPage = parseInt(cPage) + 1;
        $("#ohdFilterPage").val(nPage);
        JStPJTGetData(nPage);
    }
}

/**
 * Functionality : Filter data
 * Parameters : -
 * Creator : 19/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 */
function JSxPJTFilterData() {
    $("#ohdFilterPage").val(1);
    JStPJTGetData()
}

/**
 * Functionality : Get Data from server
 * Parameters : -
 * Creator : 19/11/2024 Sorawit
 * Last Modified :
 * Return : Text in HTML format of table data
 * Return Type : string
 */
function JStPJTGetData(pnPage = 1) {
    let tSearch = $("#oetSearch").val();
    let nSearchProject = $("#ocmSearchProject").val();
    let tSearchRelease = $('#ocmSearchRelease').val();
    let nSearchDev = $("#ocmSearchDev").val();
    let nSearchDevTeam = $('#ocmSearchDevTeam').val();
    $.ajax({
        type: "POST",
        url: tUrlMasPJTGetData,
        data: {
            "tSearch": tSearch,
            "nSearchProject": nSearchProject,
            'tSearchRelease': tSearchRelease,
            "nSearchDev": nSearchDev,
            "nSearchDevTeam": nSearchDevTeam,
            "nPage": pnPage
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            $("#odvPjtList").html(tResult);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
        }
    });
}

/**
 * Functionality : Delete data
 * Parameters : PrjCode
 * Creator : 19/11/2024 Sorawit
 * Last Modified :
 * Return : -
 * Return Type : void
 * */
function JSxPJTDeleteData(ptPrjCode, ptDevCode, ptPrjRelease) {
    $.ajax({
        type: "POST",
        url: tUrlMasPRJDeleteData,
        data: {
            'tPrjCode': ptPrjCode,
            'tDevCode': ptDevCode,
            'tPrjRelease': ptPrjRelease
        },
        success: function (paResponse) {
            let aRes = JSON.parse(paResponse);
            if (aRes.rtStatus === 'success') {
                alert(aRes.rtMessage);
                JStPJTGetData()
            } else {
                alert('เกิดข้อผิดพลาด: ' + aRes.rtMessage);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('เกิดข้อผิดพลาด: ' + errorThrown);
        }
    });
}