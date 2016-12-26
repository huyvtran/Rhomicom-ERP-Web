<?php
$canAddOrg = test_prmssns($dfltPrvldgs[14], $mdlNm);
$canEdtOrg = test_prmssns($dfltPrvldgs[15], $mdlNm);

$pageNo = isset($_POST['pageNo']) ? cleanInputData($_POST['pageNo']) : 1;
$lmtSze = isset($_POST['limitSze']) ? cleanInputData($_POST['limitSze']) : 10;
$sortBy = isset($_POST['sortBy']) ? cleanInputData($_POST['sortBy']) : "";

if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0 && $canview === true) {
        if ($qstr == "DELETE") {
            if ($actyp == 1) {
                
            }
        } else if ($qstr == "UPDATE") {
            if ($actyp == 1) {
                
            } else if ($actyp == 2) {
                
            }
        } else {
            if ($vwtyp == 0) {
                $pkID = isset($_POST['sbmtdOrgID']) ? $_POST['sbmtdOrgID'] : -1;
                echo $cntent . "<li onclick=\"openATab('#allmodules', 'grp=$group&typ=$type');\">
						<span style=\"text-decoration:none;\">Organization Setup Menu</span>
				</li>
                                <li>
                                    <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
                                    <span style=\"text-decoration:none;\">Organization Setup</span>
				</li>
                               </ul>
                              </div>";
                $total = get_OrgLstsTblrTtl($srchFor, $srchIn);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }

                $curIdx = $pageNo - 1;
                $result = get_OrgLstsTblr($srchFor, $srchIn, $curIdx, $lmtSze);
                $cntr = 0;
                $colClassType1 = "col-lg-2";
                $colClassType2 = "col-lg-3";
                $colClassType3 = "col-lg-4";
                ?>
                <form id='allOrgStpsForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row" style="margin-bottom:5px;">
                        <?php
                        if ($canAddOrg === true) {
                            ?> 
                            <div class="<?php echo $colClassType3; ?>" style="padding:0px 1px 0px 1px !important;"> 
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="getOneOrgStpForm(-1, 2);" style="width:100% !important;">
                                        <img src="cmn_images/add1-64.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                        New Organization
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="saveOrgStpForm();" style="width:100% !important;">
                                        <img src="cmn_images/FloppyDisk.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                        Save
                                    </button>
                                </div>
                            </div>
                            <?php
                        } else {
                            $colClassType1 = "col-lg-2";
                            $colClassType2 = "col-lg-5";
                        }
                        ?>
                        <div class="<?php echo $colClassType2; ?>" style="padding:0px 15px 0px 15px !important;">
                            <div class="input-group">
                                <input class="form-control" id="allOrgStpsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncOrgStps(event, '', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                <input id="allOrgStpsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllOrgStps('clear', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getAllOrgStps('', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="<?php echo $colClassType2; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="allOrgStpsSrchIn">
                                    <?php
                                    $valslctdArry = array("", "");
                                    $srchInsArrys = array("Organization Name", "Parent Organisation Name");

                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                        if ($srchIn == $srchInsArrys[$z]) {
                                            $valslctdArry[$z] = "selected";
                                        }
                                        ?>
                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="allOrgStpsDsplySze" style="min-width:70px !important;">                            
                                    <?php
                                    $valslctdArry = array("", "", "", "", "", "", "", "");
                                    $dsplySzeArry = array(1, 5, 10, 15, 30, 50, 100, 500, 1000);
                                    for ($y = 0; $y < count($dsplySzeArry); $y++) {
                                        if ($lmtSze == $dsplySzeArry[$y]) {
                                            $valslctdArry[$y] = "selected";
                                        } else {
                                            $valslctdArry[$y] = "";
                                        }
                                        ?>
                                        <option value="<?php echo $dsplySzeArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $dsplySzeArry[$y]; ?></option>                            
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="<?php echo $colClassType1; ?>">
                            <nav aria-label="Page navigation">
                                <ul class="pagination" style="margin: 0px !important;">
                                    <li>
                                        <a href="javascript:getAllOrgStps('previous', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:getAllOrgStps('next', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="row"  style="padding:1px 15px 1px 15px !important;"><hr style="margin:1px 0px 3px 0px;"></div>
                    <div class="row" style="padding:0px 15px 0px 15px !important"> 
                        <div  class="col-md-3" style="padding:0px 1px 0px 1px !important">
                            <fieldset class="basic_person_fs">                                        
                                <table class="table table-striped table-bordered table-responsive" id="allOrgStpsTable" cellspacing="0" width="100%" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Organization Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = loc_db_fetch_array($result)) {
                                            if ($pkID <= 0 && $cntr <= 0) {
                                                $pkID = $row[0];
                                            }
                                            $cntr += 1;
                                            ?>
                                            <tr id="allOrgStpsRow_<?php echo $cntr; ?>" class="hand_cursor">                                    
                                                <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                                <td><?php echo $row[1]; ?><input type="hidden" class="form-control" aria-label="..." id="allOrgStpsRow<?php echo $cntr; ?>_OrgID" value="<?php echo $row[0]; ?>"></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>                        
                            </fieldset>
                        </div>                        
                        <div  class="col-md-9" style="padding:0px 1px 0px 1px !important">
                            <fieldset class="basic_person_fs" style="padding-top:10px !important;">
                                <div class="container-fluid" id="orgStpsDetailInfo" style="padding:0px 3px 0px 3px !important;">
                                    <?php
                                    if ($pkID > 0) {
                                        $result1 = get_OrgStpsDet($pkID);
                                        $sbmtdOrgID = $pkID;
                                        while ($row1 = loc_db_fetch_array($result1)) {
                                            ?>
                                            <ul class="nav nav-tabs rho-hideable-tabs" style="margin-top:-5px !important;">
                                                <li class="active"><a data-toggle="tab" data-rhodata="&pg=1&vtyp=0&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgDetPage" id="orgDetPagetab">Organization</a></li>
                                                <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=3&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgDivsGrpsPage" id="orgDivsGrpsPagetab">Divisions/Groups</a></li>
                                                <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=4&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgSitesLocsPage" id="orgSitesLocsPagetab">Sites/Locations</a></li>
                                                <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=5&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgJobsPage" id="orgJobsPagetab">Jobs</a></li>
                                                <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=6&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgGradesPage" id="orgGradesPagetab">Grades</a></li>
                                                <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=7&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgPositionsPage" id="orgPositionsPagetab">Positions</a></li>
                                            </ul>
                                            <div class="row">                  
                                                <div class="col-md-12">
                                                    <div class="custDiv"> 
                                                        <div class="tab-content">
                                                            <div id="orgDetPage" class="tab-pane fadein active" style="border:none !important;"> 
                                                                <div class="row">
                                                                    <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                                        <fieldset class="basic_person_fs" style="padding:10px 3px 0px 3px !important;"> 
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetOrgNm" class="control-label col-lg-4">Organization's Name:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <input type="text" class="form-control" aria-label="..." id="orgDetOrgNm" name="orgDetOrgNm" value="<?php echo $row1[1]; ?>" style="width:100%">
                                                                                        <input type="hidden" class="form-control" aria-label="..." id="orgDetOrgID" name="orgDetOrgID" value="<?php echo $row1[0]; ?>">
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[1]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetPrntNm" class="control-label col-lg-4">Parent Organisation:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <div class="input-group">
                                                                                            <input type="text" class="form-control" aria-label="..." id="orgDetPrntNm" name="orgDetPrntNm" value="<?php echo $row1[4]; ?>" readonly="true">
                                                                                            <input type="hidden" class="form-control" aria-label="..." id="orgDetPrntOrgID" name="orgDetPrntOrgID" value="<?php echo $row1[3]; ?>">
                                                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Organisations', '', '', '', 'radio', true, '<?php echo $row1[3]; ?>', 'orgDetPrntOrgID', 'orgDetPrntNm', 'clear', 1, '');">
                                                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                                                            </label>
                                                                                        </div>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[4]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetResAdrs" class="control-label col-lg-4">Residential Address:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <textarea class="form-control" aria-label="..." id="orgDetResAdrs" name="orgDetResAdrs" style="width:100%" cols="3" rows="3"><?php echo $row1[5]; ?></textarea>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[5]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetPosAdrs" class="control-label col-lg-4">Postal Address:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <textarea class="form-control" aria-label="..." id="orgDetPosAdrs" name="orgDetPosAdrs" style="width:100%" cols="3" rows="3"><?php echo $row1[6]; ?></textarea>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[6]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetEmail" class="control-label col-lg-4">Email Addresses:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <input type="text" class="form-control" aria-label="..." id="orgDetEmail" name="orgDetEmail" value="<?php echo $row1[8]; ?>" style="width:100%">
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[7]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetWebsites" class="control-label col-lg-4">Websites:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <input type="text" class="form-control" aria-label="..." id="orgDetWebsites" name="orgDetWebsites" value="<?php echo $row1[8]; ?>" style="width:100%">
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[8]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetOrgTyp" class="control-label col-lg-4">Organization Type:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <div class="input-group">
                                                                                            <input type="text" class="form-control" aria-label="..." id="orgDetOrgTyp" name="orgDetOrgTyp" value="<?php echo $row1[11]; ?>" readonly="true">
                                                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Organisation Types', '', '', '', 'radio', true, '<?php echo $row1[11]; ?>', 'orgDetOrgTyp', '', 'clear', 1, '');">
                                                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                                                            </label>
                                                                                        </div>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[11]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetFuncCrncy" class="control-label col-lg-4">Functional Currency:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <div class="input-group">
                                                                                            <input type="text" class="form-control" aria-label="..." id="orgDetFuncCrncy" name="orgDetFuncCrncy" value="<?php echo $row1[14]; ?>" readonly="true">
                                                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Currencies', '', '', '', 'radio', true, '<?php echo $row1[14]; ?>', 'orgDetFuncCrncy', '', 'clear', 1, '');">
                                                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                                                            </label>
                                                                                        </div>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[14]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                    <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                                        <fieldset class = "basic_person_fs"><legend class = "basic_person_lg">Organization's Logo</legend>
                                                                            <div style="margin-bottom: 6px;">
                                                                                <?php
                                                                                //$radomNo = rand(1000000, 999999999);
                                                                                $ftp_src = $ftp_base_db_fldr . "/Org/" . $row1[2];
                                                                                $img_src = "dwnlds/$db_folder/Org/" . $row1[2];
                                                                                if ($row1[2] != "") {
                                                                                    if (file_exists($ftp_src) && !file_exists($fldrPrfx . $img_src)) {
                                                                                        copy("$ftp_src", "$fldrPrfx" . "$img_src");
                                                                                    }

                                                                                    if (!file_exists($fldrPrfx . $img_src)) {
                                                                                        $img_src = "cmn_images/tools_ipwhoislookup.png";
                                                                                    }
                                                                                } else {
                                                                                    $img_src = "cmn_images/tools_ipwhoislookup.png";
                                                                                }
                                                                                ?>
                                                                                <img src="<?php echo $img_src; ?>" alt="..." id="img1Test" class="img-rounded center-block img-responsive" style="height: 195px !important; width: auto !important;">                                            
                                                                            </div>
                                                                            <div class="form-group form-group-sm">
                                                                                <div class="col-md-12">
                                                                                    <div class="input-group">
                                                                                        <label class="btn btn-primary btn-file input-group-addon">
                                                                                            Browse... <input type="file" id="input1Test" name="input1Test" onchange="changeImgSrc(this, '#img1Test', '#img1SrcLoc');" class="btn btn-default"  style="display: none;">
                                                                                        </label>
                                                                                        <input type = "text" class = "form-control" aria-label = "..." id = "img1SrcLoc" value = "">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:3px 3px 0px 3px !important;">
                                                                                <label for="orgDetLogo" class="control-label col-lg-4">Logo Filename:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <input type="text" class="form-control" aria-label="..." id="orgDetLogo" name="orgDetLogo" value="<?php echo $row1[2]; ?>" style="width:100%" readonly="true">
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[2]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetCntctNums" class="control-label col-lg-4">Contact Numbers:</label>
                                                                                <div  class="col-lg-8">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <input type="text" class="form-control" aria-label="..." id="orgDetCntctNums" name="orgDetCntctNums" value="<?php echo $row1[9]; ?>" style="width:100%">
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[9]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>                                                       
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetIsEnabled" class="control-label col-lg-6">Is Enabled?:</label>
                                                                                <div class="col-lg-6">
                                                                                    <?php
                                                                                    $chkdYes = "";
                                                                                    $chkdNo = "checked=\"\"";
                                                                                    if ($row1[12] == "Yes") {
                                                                                        $chkdNo = "";
                                                                                        $chkdYes = "checked=\"\"";
                                                                                    }
                                                                                    ?>
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <label class="radio-inline"><input type="radio" name="orgDetIsEnabled" value="YES" <?php echo $chkdYes; ?>>YES</label>
                                                                                        <label class="radio-inline"><input type="radio" name="orgDetIsEnabled" value="NO" <?php echo $chkdNo; ?>>NO</label>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo ($row1[12] == "Yes" ? "YES" : "NO"); ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div  class="col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                        <fieldset class="basic_person_fs" style="padding:10px 3px 0px 3px !important;"> 
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetOrgDesc" class="control-label col-lg-2">Organization's Description:</label>
                                                                                <div  class="col-lg-10">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <textarea class="form-control" aria-label="..." id="orgDetOrgDesc" name="orgDetOrgDesc" style="width:100%" cols="9" rows="4"><?php echo $row1[15]; ?></textarea>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[15]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                                                <label for="orgDetOrgSlogan" class="control-label col-lg-2">Organization's Slogan:</label>
                                                                                <div  class="col-lg-10">
                                                                                    <?php if ($canEdtOrg === true) { ?>
                                                                                        <textarea class="form-control" aria-label="..." id="orgDetOrgSlogan" name="orgDetOrgSlogan" style="width:100%" cols="9" rows="4"><?php echo $row1[16]; ?></textarea>
                                                                                    <?php } else {
                                                                                        ?>
                                                                                        <span><?php echo $row1[16]; ?></span>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="orgDivsGrpsPage" class="tab-pane fade" style="border:none !important;"></div>
                                                            <div id="orgSitesLocsPage" class="tab-pane fade" style="border:none !important;"></div>    
                                                            <div id="orgJobsPage" class="tab-pane fade" style="border:none !important;"></div>    
                                                            <div id="orgGradesPage" class="tab-pane fade" style="border:none !important;"></div>      
                                                            <div id="orgPositionsPage" class="tab-pane fade" style="border:none !important;"></div> 
                                                        </div>                        
                                                    </div>                         
                                                </div>                
                                            </div>                                              
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <span>No Results Found</span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </form>
                <?php
            } else if ($vwtyp == 1) {
                $curIdx = 0;
                $pkID = isset($_POST['sbmtdOrgID']) ? $_POST['sbmtdOrgID'] : -1;
                if ($pkID > 0) {
                    $result1 = get_OrgStpsDet($pkID);
                    $sbmtdOrgID = $pkID;
                    while ($row1 = loc_db_fetch_array($result1)) {
                        ?>
                        <ul class="nav nav-tabs rho-hideable-tabs" style="margin-top:-5px !important;">
                            <li class="active"><a data-toggle="tab" data-rhodata="&pg=1&vtyp=0&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgDetPage" id="orgDetPagetab">Organization</a></li>
                            <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=3&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgDivsGrpsPage" id="orgDivsGrpsPagetab">Divisions/Groups</a></li>
                            <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=4&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgSitesLocsPage" id="orgSitesLocsPagetab">Sites/Locations</a></li>
                            <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=5&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgJobsPage" id="orgJobsPagetab">Jobs</a></li>
                            <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=6&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgGradesPage" id="orgGradesPagetab">Grades</a></li>
                            <li><a data-toggle="tabajxorg" data-rhodata="&pg=1&vtyp=7&sbmtdOrgID=<?php echo $sbmtdOrgID; ?>" href="#orgPositionsPage" id="orgPositionsPagetab">Positions</a></li>
                        </ul>
                        <div class="row">                  
                            <div class="col-md-12">
                                <div class="custDiv"> 
                                    <div class="tab-content">
                                        <div id="orgDetPage" class="tab-pane fadein active" style="border:none !important;"> 
                                            <div class="row">
                                                <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                    <fieldset class="basic_person_fs" style="padding:10px 3px 0px 3px !important;"> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetOrgNm" class="control-label col-lg-4">Organization's Name:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <input type="text" class="form-control" aria-label="..." id="orgDetOrgNm" name="orgDetOrgNm" value="<?php echo $row1[1]; ?>" style="width:100%">
                                                                    <input type="hidden" class="form-control" aria-label="..." id="orgDetOrgID" name="orgDetOrgID" value="<?php echo $row1[0]; ?>">
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[1]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetPrntNm" class="control-label col-lg-4">Parent Organisation:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" aria-label="..." id="orgDetPrntNm" name="orgDetPrntNm" value="<?php echo $row1[4]; ?>" readonly="true">
                                                                        <input type="hidden" class="form-control" aria-label="..." id="orgDetPrntOrgID" name="orgDetPrntOrgID" value="<?php echo $row1[3]; ?>">
                                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Organisations', '', '', '', 'radio', true, '<?php echo $row1[3]; ?>', 'orgDetPrntOrgID', 'orgDetPrntNm', 'clear', 1, '');">
                                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                                        </label>
                                                                    </div>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[4]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetResAdrs" class="control-label col-lg-4">Residential Address:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <textarea class="form-control" aria-label="..." id="orgDetResAdrs" name="orgDetResAdrs" style="width:100%" cols="3" rows="3"><?php echo $row1[5]; ?></textarea>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[5]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetPosAdrs" class="control-label col-lg-4">Postal Address:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <textarea class="form-control" aria-label="..." id="orgDetPosAdrs" name="orgDetPosAdrs" style="width:100%" cols="3" rows="3"><?php echo $row1[6]; ?></textarea>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[6]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetEmail" class="control-label col-lg-4">Email Addresses:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <input type="text" class="form-control" aria-label="..." id="orgDetEmail" name="orgDetEmail" value="<?php echo $row1[8]; ?>" style="width:100%">
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[7]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetWebsites" class="control-label col-lg-4">Websites:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <input type="text" class="form-control" aria-label="..." id="orgDetWebsites" name="orgDetWebsites" value="<?php echo $row1[8]; ?>" style="width:100%">
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[8]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetOrgTyp" class="control-label col-lg-4">Organization Type:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" aria-label="..." id="orgDetOrgTyp" name="orgDetOrgTyp" value="<?php echo $row1[11]; ?>" readonly="true">
                                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Organisation Types', '', '', '', 'radio', true, '<?php echo $row1[11]; ?>', 'orgDetOrgTyp', '', 'clear', 1, '');">
                                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                                        </label>
                                                                    </div>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[11]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetFuncCrncy" class="control-label col-lg-4">Functional Currency:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" aria-label="..." id="orgDetFuncCrncy" name="orgDetFuncCrncy" value="<?php echo $row1[14]; ?>" readonly="true">
                                                                        <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Currencies', '', '', '', 'radio', true, '<?php echo $row1[14]; ?>', 'orgDetFuncCrncy', '', 'clear', 1, '');">
                                                                            <span class="glyphicon glyphicon-th-list"></span>
                                                                        </label>
                                                                    </div>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[14]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                                    <fieldset class = "basic_person_fs"><legend class = "basic_person_lg">Organization's Logo</legend>
                                                        <div style="margin-bottom: 6px;">
                                                            <?php
                                                            //$radomNo = rand(1000000, 999999999);
                                                            $ftp_src = $ftp_base_db_fldr . "/Org/" . $row1[2];
                                                            $img_src = "dwnlds/$db_folder/Org/" . $row1[2];
                                                            if ($row1[2] != "") {
                                                                if (file_exists($ftp_src) && !file_exists($fldrPrfx . $img_src)) {
                                                                    copy("$ftp_src", "$fldrPrfx" . "$img_src");
                                                                }

                                                                if (!file_exists($fldrPrfx . $img_src)) {
                                                                    $img_src = "cmn_images/tools_ipwhoislookup.png";
                                                                }
                                                            } else {
                                                                $img_src = "cmn_images/tools_ipwhoislookup.png";
                                                            }
                                                            ?>
                                                            <img src="<?php echo $img_src; ?>" alt="..." id="img1Test" class="img-rounded center-block img-responsive" style="height: 195px !important; width: auto !important;">                                            
                                                        </div>
                                                        <div class="form-group form-group-sm">
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <label class="btn btn-primary btn-file input-group-addon">
                                                                        Browse... <input type="file" id="input1Test" name="input1Test" onchange="changeImgSrc(this, '#img1Test', '#img1SrcLoc');" class="btn btn-default"  style="display: none;">
                                                                    </label>
                                                                    <input type = "text" class = "form-control" aria-label = "..." id = "img1SrcLoc" value = "">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:3px 3px 0px 3px !important;">
                                                            <label for="orgDetLogo" class="control-label col-lg-4">Logo Filename:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <input type="text" class="form-control" aria-label="..." id="orgDetLogo" name="orgDetLogo" value="<?php echo $row1[2]; ?>" style="width:100%" readonly="true">
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[2]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetCntctNums" class="control-label col-lg-4">Contact Numbers:</label>
                                                            <div  class="col-lg-8">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <input type="text" class="form-control" aria-label="..." id="orgDetCntctNums" name="orgDetCntctNums" value="<?php echo $row1[9]; ?>" style="width:100%">
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[9]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>                                                       
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetIsEnabled" class="control-label col-lg-6">Is Enabled?:</label>
                                                            <div class="col-lg-6">
                                                                <?php
                                                                $chkdYes = "";
                                                                $chkdNo = "checked=\"\"";
                                                                if ($row1[12] == "Yes") {
                                                                    $chkdNo = "";
                                                                    $chkdYes = "checked=\"\"";
                                                                }
                                                                ?>
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <label class="radio-inline"><input type="radio" name="orgDetIsEnabled" value="YES" <?php echo $chkdYes; ?>>YES</label>
                                                                    <label class="radio-inline"><input type="radio" name="orgDetIsEnabled" value="NO" <?php echo $chkdNo; ?>>NO</label>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo ($row1[12] == "Yes" ? "YES" : "NO"); ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div  class="col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <fieldset class="basic_person_fs" style="padding:10px 3px 0px 3px !important;"> 
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetOrgDesc" class="control-label col-lg-2">Organization's Description:</label>
                                                            <div  class="col-lg-10">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <textarea class="form-control" aria-label="..." id="orgDetOrgDesc" name="orgDetOrgDesc" style="width:100%" cols="9" rows="4"><?php echo $row1[15]; ?></textarea>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[15]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                            <label for="orgDetOrgSlogan" class="control-label col-lg-2">Organization's Slogan:</label>
                                                            <div  class="col-lg-10">
                                                                <?php if ($canEdtOrg === true) { ?>
                                                                    <textarea class="form-control" aria-label="..." id="orgDetOrgSlogan" name="orgDetOrgSlogan" style="width:100%" cols="9" rows="4"><?php echo $row1[16]; ?></textarea>
                                                                <?php } else {
                                                                    ?>
                                                                    <span><?php echo $row1[16]; ?></span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="orgDivsGrpsPage" class="tab-pane fade" style="border:none !important;"></div>
                                        <div id="orgSitesLocsPage" class="tab-pane fade" style="border:none !important;"></div>    
                                        <div id="orgJobsPage" class="tab-pane fade" style="border:none !important;"></div>    
                                        <div id="orgGradesPage" class="tab-pane fade" style="border:none !important;"></div>      
                                        <div id="orgPositionsPage" class="tab-pane fade" style="border:none !important;"></div> 
                                    </div>                        
                                </div>                         
                            </div>                
                        </div>  
                        <?php
                    }
                } else {
                    ?>
                    <span>No Results Found</span>
                    <?php
                }
            } else if ($vwtyp == 2) {
                //New Org Form
                $curIdx = 0;
                $pkID = -1;
                if ($canAddOrg === true) {
                    
                } else {
                    exit();
                }
                ?>
                <div class="row">                  
                    <div class="col-md-12">
                        <div class="custDiv" style="border:none !important;"> 
                            <div class="tab-content">
                                <div id="orgDetPage" class="tab-pane fadein active" style="border:none !important;"> 
                                    <div class="row">
                                        <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                            <fieldset class="basic_person_fs" style="padding:10px 3px 0px 3px !important;"> 
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetOrgNm" class="control-label col-lg-4">Organization's Name:</label>
                                                    <div  class="col-lg-8">
                                                        <input type="text" class="form-control" aria-label="..." id="orgDetOrgNm" name="orgDetOrgNm" value="" style="width:100%">
                                                        <input type="hidden" class="form-control" aria-label="..." id="orgDetOrgID" name="orgDetOrgID" value="-1">                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetPrntNm" class="control-label col-lg-4">Parent Organization:</label>
                                                    <div  class="col-lg-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" aria-label="..." id="orgDetPrntNm" name="orgDetPrntNm" value="" readonly="true">
                                                            <input type="hidden" class="form-control" aria-label="..." id="orgDetPrntOrgID" name="orgDetPrntOrgID" value="-1">
                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Organisations', '', '', '', 'radio', true, '', 'orgDetPrntOrgID', 'orgDetPrntNm', 'clear', 1, '');">
                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetResAdrs" class="control-label col-lg-4">Residential Address:</label>
                                                    <div  class="col-lg-8">
                                                        <textarea class="form-control" aria-label="..." id="orgDetResAdrs" name="orgDetResAdrs" style="width:100%" cols="3" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetPosAdrs" class="control-label col-lg-4">Postal Address:</label>
                                                    <div  class="col-lg-8">
                                                        <textarea class="form-control" aria-label="..." id="orgDetPosAdrs" name="orgDetPosAdrs" style="width:100%" cols="3" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetEmail" class="control-label col-lg-4">Email Addresses:</label>
                                                    <div  class="col-lg-8">
                                                        <input type="text" class="form-control" aria-label="..." id="orgDetEmail" name="orgDetEmail" value="" style="width:100%">
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetWebsites" class="control-label col-lg-4">Websites:</label>
                                                    <div  class="col-lg-8">
                                                        <input type="text" class="form-control" aria-label="..." id="orgDetWebsites" name="orgDetWebsites" value="" style="width:100%">
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetOrgTyp" class="control-label col-lg-4">Organization Type:</label>
                                                    <div  class="col-lg-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" aria-label="..." id="orgDetOrgTyp" name="orgDetOrgTyp" value="" readonly="true">
                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Organisation Types', '', '', '', 'radio', true, '', 'orgDetOrgTyp', '', 'clear', 1, '');">
                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetFuncCrncy" class="control-label col-lg-4">Functional Currency:</label>
                                                    <div  class="col-lg-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" aria-label="..." id="orgDetFuncCrncy" name="orgDetFuncCrncy" value="" readonly="true">
                                                            <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Currencies', '', '', '', 'radio', true, '', 'orgDetFuncCrncy', '', 'clear', 1, '');">
                                                                <span class="glyphicon glyphicon-th-list"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div  class="col-md-6" style="padding:0px 3px 0px 3px !important;">
                                            <fieldset class = "basic_person_fs"><legend class = "basic_person_lg">Organization's Logo</legend>
                                                <div style="margin-bottom: 6px;">
                                                    <?php
                                                    $img_src = "cmn_images/tools_ipwhoislookup.png";
                                                    ?>
                                                    <img src="<?php echo $img_src; ?>" alt="..." id="img1Test" class="img-rounded center-block img-responsive" style="height: 195px !important; width: auto !important;">                                            
                                                </div>
                                                <div class="form-group form-group-sm">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <label class="btn btn-primary btn-file input-group-addon">
                                                                Browse... <input type="file" id="input1Test" name="input1Test" onchange="changeImgSrc(this, '#img1Test', '#img1SrcLoc');" class="btn btn-default"  style="display: none;">
                                                            </label>
                                                            <input type = "text" class = "form-control" aria-label = "..." id = "img1SrcLoc" value = "">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:3px 3px 0px 3px !important;">
                                                    <label for="orgDetLogo" class="control-label col-lg-4">Logo Filename:</label>
                                                    <div  class="col-lg-8">
                                                        <input type="text" class="form-control" aria-label="..." id="orgDetLogo" name="orgDetLogo" value="" style="width:100%" readonly="true">
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetCntctNums" class="control-label col-lg-4">Contact Numbers:</label>
                                                    <div  class="col-lg-8">
                                                        <input type="text" class="form-control" aria-label="..." id="orgDetCntctNums" name="orgDetCntctNums" value="" style="width:100%">
                                                    </div>
                                                </div>                                                       
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetIsEnabled" class="control-label col-lg-6">Is Enabled?:</label>
                                                    <div class="col-lg-6">
                                                        <?php
                                                        $chkdYes = "";
                                                        $chkdNo = "checked=\"\"";
                                                        ?>
                                                        <label class="radio-inline"><input type="radio" name="orgDetIsEnabled" value="YES" <?php echo $chkdYes; ?>>YES</label>
                                                        <label class="radio-inline"><input type="radio" name="orgDetIsEnabled" value="NO" <?php echo $chkdNo; ?>>NO</label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div  class="col-md-12" style="padding:0px 3px 0px 3px !important;">
                                            <fieldset class="basic_person_fs" style="padding:10px 3px 0px 3px !important;"> 
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetOrgDesc" class="control-label col-lg-2">Organization's Description:</label>
                                                    <div  class="col-lg-10">
                                                        <textarea class="form-control" aria-label="..." id="orgDetOrgDesc" name="orgDetOrgDesc" style="width:100%" cols="9" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-sm col-md-12" style="padding:0px 3px 0px 3px !important;">
                                                    <label for="orgDetOrgSlogan" class="control-label col-lg-2">Organization's Slogan:</label>
                                                    <div  class="col-lg-10">
                                                        <textarea class="form-control" aria-label="..." id="orgDetOrgSlogan" name="orgDetOrgSlogan" style="width:100%" cols="9" rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        </div>                         
                    </div>                
                </div>
                <?php
            } else if ($vwtyp == 3) {
                //echo "Divs/Grps";
                $curIdx = 0;
                $pkID = isset($_POST['sbmtdOrgID']) ? $_POST['sbmtdOrgID'] : -1;
                if ($pkID > 0) {
                    $total = get_DivsGrpsTtl($pkID, $srchFor, $srchIn);
                    if ($pageNo > ceil($total / $lmtSze)) {
                        $pageNo = 1;
                    } else if ($pageNo < 1) {
                        $pageNo = ceil($total / $lmtSze);
                    }

                    $curIdx = $pageNo - 1;
                    $result1 = get_DivsGrps($pkID, $srchFor, $srchIn, $curIdx, $lmtSze);
                    $colClassType1 = "col-lg-2";
                    $colClassType2 = "col-lg-3";
                    $colClassType3 = "col-lg-4";
                    ?>
                    <form id='divsGrpsForm' action='' method='post' accept-charset='UTF-8'> 
                        <div class="row">
                            <?php
                            if ($canEdtOrg === true) {
                                $nwRowHtml = urlencode("<tr id=\"divsGrpsRow__WWW123WWW\">"
                                        . "<td>New</td>"
                                        . "<td><div class=\"form-group form-group-sm col-md-12\">"
                                        . "<div class=\"input-group\"  style=\"width:100%\">"
                                        . "<input type=\"text\" class=\"form-control\" aria-label=\"...\" id=\"usrPrflEdtRow_WWW123WWW_RoleNm\" value=\"\">"
                                        . "<input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"usrPrflEdtRow_WWW123WWW_RoleID\" value=\"-1\">"
                                        . "<input type=\"hidden\" class=\"form-control\" aria-label=\"...\" id=\"usrPrflEdtRow_WWW123WWW_DfltRowID\" value=\"-1\">"
                                        . "<label class=\"btn btn-primary btn-file input-group-addon\" onclick=\"getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'User Roles', '', '', '', 'radio', true, '', 'usrPrflEdtRow_WWW123WWW_RoleID', 'usrPrflEdtRow_WWW123WWW_RoleNm', 'clear', 1, '');\">"
                                        . "<span class=\"glyphicon glyphicon-th-list\"></span>"
                                        . "</label>"
                                        . "</div>"
                                        . "</div>"
                                        . "</td>"
                                        . "<td><div class=\"form-group form-group-sm col-md-12\">
                                                                <div class=\"input-group date form_date_tme\" data-date=\"\" data-date-format=\"dd-M-yyyy hh:ii:ss\" data-link-field=\"dtp_input2\" data-link-format=\"yyyy-mm-dd hh:ii:ss\" style=\"width:100%\">
                                                                    <input class=\"form-control\" size=\"16\" type=\"text\" id=\"usrPrflEdtRow_WWW123WWW_StrtDte\" value=\"\" readonly=\"\">
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-remove\"></span></span>
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
                                                                </div>                                                                
                                                            </div></td>"
                                        . "<td><div class=\"form-group form-group-sm col-md-12\">
                                                                <div class=\"input-group date form_date_tme\" data-date=\"\" data-date-format=\"dd-M-yyyy hh:ii:ss\" data-link-field=\"dtp_input2\" data-link-format=\"yyyy-mm-dd hh:ii:ss\" style=\"width:100%\">
                                                                    <input class=\"form-control\" size=\"16\" type=\"text\" id=\"usrPrflEdtRow_WWW123WWW_EndDte\" value=\"\" readonly=\"\">
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-remove\"></span></span>
                                                                    <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
                                                                </div>                                                                
                                                            </div></td>"
                                        . "</tr>");
                                ?> 
                                <div class="<?php echo $colClassType1; ?>" style="padding:0px 1px 0px 15px !important;">     
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="insertNewRowBe4('userRolesTable', 0, '<?php echo $nwRowHtml; ?>');">
                                        <img src="cmn_images/add1-64.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                    </button>
                                    <button type="button" class="btn btn-default" style="margin-bottom: 5px;" onclick="saveUserNRoleForm();">
                                        <img src="cmn_images/FloppyDisk.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                    </button>
                                </div>
                                <?php
                            } else {
                                $colClassType1 = "col-lg-4";
                                $colClassType2 = "col-lg-4";
                                $colClassType3 = "col-lg-4";
                            }
                            ?>
                            <div class="<?php echo $colClassType3; ?>" style="padding:0px 15px 0px 15px !important;">
                                <div class="input-group">
                                    <input class="form-control" id="divsGrpsSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncAllSecPlcys(event, '', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <input id="divsGrpsPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllSecPlcys('clear', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </label>
                                    <label class="btn btn-primary btn-file input-group-addon" onclick="getAllSecPlcys('', '#allmodules', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </label> 
                                </div>
                            </div>
                            <div class="<?php echo $colClassType3; ?>">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="divsGrpsSrchIn">
                                        <?php
                                        $valslctdArry = array("", "");
                                        $srchInsArrys = array("Division Name", "Parent Division Name");

                                        for ($z = 0; $z < count($srchInsArrys); $z++) {
                                            if ($srchIn == $srchInsArrys[$z]) {
                                                $valslctdArry[$z] = "selected";
                                            }
                                            ?>
                                            <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                    <select data-placeholder="Select..." class="form-control chosen-select" id="divsGrpsDsplySze" style="min-width:70px !important;">                            
                                        <?php
                                        $valslctdArry = array("", "", "", "", "", "", "", "");
                                        $dsplySzeArry = array(1, 5, 10, 15, 30, 50, 100, 500, 1000);
                                        for ($y = 0; $y < count($dsplySzeArry); $y++) {
                                            if ($lmtSze == $dsplySzeArry[$y]) {
                                                $valslctdArry[$y] = "selected";
                                            } else {
                                                $valslctdArry[$y] = "";
                                            }
                                            ?>
                                            <option value="<?php echo $dsplySzeArry[$y]; ?>" <?php echo $valslctdArry[$y]; ?>><?php echo $dsplySzeArry[$y]; ?></option>                            
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="<?php echo $colClassType1; ?>">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination" style="margin: 0px !important;">
                                        <li>
                                            <a href="javascript:getOneUserForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'userRolesForm', 'View/Edit User', <?php echo $pkID; ?>, 1, 1,'previous');" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:getOneUserForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'userRolesForm', 'View/Edit User', <?php echo $pkID; ?>, 1, 1,'next');" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="row"> 
                            <div  class="col-md-12">
                                <table class="table table-striped table-bordered table-responsive" id="divsGrpsTable" cellspacing="0" width="100%" style="width:100%;min-width: 1200px !important;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Group Code/Name</th>
                                            <th>Parent Group</th>
                                            <th>Group Type</th>
                                            <th style="min-width: 300px !important;width: 300px !important;">Group Description</th>
                                            <th>Enabled?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cntr = 0;
                                        while ($row1 = loc_db_fetch_array($result1)) {
                                            $cntr += 1;
                                            ?>
                                            <tr id="divsGrpsRow_<?php echo $cntr; ?>">                                    
                                                <td class="lovtd"><span class="normaltd"><?php echo ($curIdx * $lmtSze) + ($cntr); ?></span></td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtOrg === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <input type="text" class="form-control" aria-label="..." id="divsGrpsRow<?php echo $cntr; ?>_GroupNm" value="<?php echo $row1[1]; ?>">
                                                            <input type="hidden" class="form-control" aria-label="..." id="divsGrpsRow<?php echo $cntr; ?>_GroupID" value="<?php echo $row1[0]; ?>">
                                                        </div>
                                                    <?php } else { ?>
                                                        <span class="normaltd"><?php echo $row1[1]; ?></span>
                                                    <?php } ?>                                                         
                                                </td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtOrg === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <div class="input-group"  style="width:100%">
                                                                <input type="text" class="form-control" aria-label="..." id="divsGrpsRow<?php echo $cntr; ?>_PrntNm" value="<?php echo $row1[3]; ?>">
                                                                <input type="hidden" class="form-control" aria-label="..." id="divsGrpsRow<?php echo $cntr; ?>_PrntID" value="<?php echo $row1[2]; ?>">
                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Divisions/Groups', '', '', '', 'radio', true, '<?php echo $row1[2]; ?>', 'divsGrpsRow<?php echo $cntr; ?>_PrntID', 'divsGrpsRow<?php echo $cntr; ?>_PrntNm', 'clear', 1, '');">
                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span class="normaltd"><?php echo $row1[3]; ?></span>
                                                    <?php } ?>                                                         
                                                </td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtOrg === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <div class="input-group"  style="width:100%">
                                                                <input type="text" class="form-control" aria-label="..." id="divsGrpsRow<?php echo $cntr; ?>_DivTypNm" value="<?php echo $row1[5]; ?>">
                                                                <input type="hidden" class="form-control" aria-label="..." id="divsGrpsRow<?php echo $cntr; ?>_DivTypID" value="<?php echo $row1[4]; ?>">
                                                                <label class="btn btn-primary btn-file input-group-addon" onclick="getLovsPage('myLovModal', 'myLovModalTitle', 'myLovModalBody', 'Divisions/Group Types', '', '', '', 'radio', true, '<?php echo $row1[4]; ?>', 'divsGrpsRow<?php echo $cntr; ?>_DivTypID', 'divsGrpsRow<?php echo $cntr; ?>_DivTypNm', 'clear', 1, '');">
                                                                    <span class="glyphicon glyphicon-th-list"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span class="normaltd"><?php echo $row1[5]; ?></span>
                                                    <?php } ?>                                                         
                                                </td>
                                                <td class="lovtd">
                                                    <?php if ($canEdtOrg === true) { ?>
                                                        <div class="form-group form-group-sm" style="width:100% !important;">
                                                            <textarea class="form-control" aria-label="..." id="divsGrpsRow<?php echo $cntr; ?>_GroupDesc" name="divsGrpsRow<?php echo $cntr; ?>_GroupDesc" style="width:100%" cols="7" rows="2"><?php echo $row1[7]; ?></textarea>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span class="normaltd"><?php echo $row1[7]; ?></span>
                                                    <?php } ?>                                                         
                                                </td>
                                                <td class="lovtd">
                                                    <?php
                                                    $isChkd = "";
                                                    if ($row1[8] == "Yes") {
                                                        $isChkd = "checked=\"true\"";
                                                    }
                                                    if ($canEdtOrg === true) {
                                                        ?>
                                                        <div class="form-group form-group-sm normaltd">
                                                            <div class="form-check" style="font-size: 12px !important;">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input" id="divsGrpsRow<?php echo $cntr; ?>_IsEnabled" <?php echo $isChkd ?>>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <span class="normaltd"><?php echo $row1[8]; ?></span>
                                                    <?php } ?>                                                         
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>                     
                        </div>     
                    </form>
                    <?php
                }
            } else if ($vwtyp == 4) {
                echo "Sites/Locs";
            } else if ($vwtyp == 5) {
                echo "Jobs";
            } else if ($vwtyp == 6) {
                echo "Grades";
            } else if ($vwtyp == 7) {
                echo "Positions";
            }
        }
    }
}    