<?php
$mdlNm = "Self Service";
$ModuleName = $mdlNm;

$dfltPrvldgs = array("View Self-Service", "Administer Other's Inbox");

$vwtyp = "0";
$qstr = "";
$dsply = "";
$actyp = "";
$qActvOnly = "false";
$srchFor = "";
$srchIn = "";
$RoutingID = -1;
$qNonLgn = "false";

if (isset($_POST['qNonLgn'])) {
    $qNonLgn = cleanInputData($_POST['qNonLgn']);
}
if (isset($_POST['qActvOnly'])) {
    $qActvOnly = cleanInputData($_POST['qActvOnly']);
}
if (isset($_POST['RoutingID'])) {
    $RoutingID = cleanInputData($_POST['RoutingID']);
}
if (isset($_POST['qStrtDte'])) {
    $qStrtDte = cleanInputData($_POST['qStrtDte']);
    if (strlen($qStrtDte) == 11) {
        $qStrtDte = substr($qStrtDte, 0, 11) . " 00:00:00";
    } else {
        $qStrtDte = "";
    }
}

if (isset($_POST['qEndDte'])) {
    $qEndDte = cleanInputData($_POST['qEndDte']);
    if (strlen($qEndDte) == 11) {
        $qEndDte = substr($qEndDte, 0, 11) . " 23:59:59";
    } else {
        $qEndDte = "";
    }
}

if (isset($_POST['searchfor'])) {
    $srchFor = cleanInputData($_POST['searchfor']);
}

if (isset($_POST['searchIn'])) {
    $srchIn = cleanInputData($_POST['searchIn']);
}
if (strpos($srchFor, "%") === FALSE) {
    $srchFor = " " . $srchFor . " ";
    $srchFor = str_replace(" ", "%", $srchFor);
}


if (isset($_POST['q'])) {
    $qstr = cleanInputData($_POST['q']);
}

if (isset($_POST['vtyp'])) {
    $vwtyp = cleanInputData($_POST['vtyp']);
}

if (isset($_POST['actyp'])) {
    $actyp = cleanInputData($_POST['actyp']);
}

$isMaster = 0;
if (isset($_POST['qMaster'])) {
    $isMaster = cleanInputData($_POST['qMaster']);
}

if ($isMaster == 1) {
    if (test_prmssns($dfltPrvldgs[1], $mdlNm) == FALSE) {
        restricted();
        exit();
    }
}
$pageNo = isset($_POST['pageNo']) ? cleanInputData($_POST['pageNo']) : 1;
$lmtSze = isset($_POST['limitSze']) ? cleanInputData($_POST['limitSze']) : 10;
$sortBy = isset($_POST['sortBy']) ? cleanInputData($_POST['sortBy']) : "";
if (strpos($srchFor, "%") === FALSE) {
    $srchFor = " " . $srchFor . " ";
    $srchFor = str_replace(" ", "%", $srchFor);
}

$cntent = "<div>
				<ul class=\"breadcrumb\" style=\"$breadCrmbBckclr\">
					<li onclick=\"openATab('#home', 'grp=40&typ=1');\">
                                                <i class=\"fa fa-home\" aria-hidden=\"true\"></i>
						<span style=\"text-decoration:none;\">Home</span>
                                                <span class=\"divider\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></span>
					</li>";
if (array_key_exists('lgn_num', get_defined_vars())) {
    if ($lgn_num > 0) {
        if ($qstr == "DELETE") {
            if ($actyp == 1) {
                
            }
        } else if ($qstr == "UPDATE") {
            if ($actyp == 1) {
                $usrID = $_SESSION['USRID'];
                $arry1 = explode(";", $actyp);
                for ($r = 0; $r < count($arry1); $r++) {
                    if ($arry1[$r] !== "") {
                        actOnMsgSQL($RoutingID, $usrID, $arry1[$r]);
                    }
                }
            } else if ($actyp == 2) {
                
            }
        } else {
            if ($vwtyp == "0") {
                $cntent .= "
					<li>
						<span style=\"text-decoration:none;\">My Inbox</span>
					</li>
                                       </ul>
                                     </div>";
                echo $cntent;
                $total = get_MyInbxTtls($srchFor, $srchIn);
                if ($pageNo > ceil($total / $lmtSze)) {
                    $pageNo = 1;
                } else if ($pageNo < 1) {
                    $pageNo = ceil($total / $lmtSze);
                }

                $curIdx = $pageNo - 1;
                $result = get_MyInbx($srchFor, $srchIn, $curIdx, $lmtSze);
                ?>
                <form id='myInbxForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row " style="margin-bottom:5px;padding:0px 15px 0px 15px !important;">
                        <div class="col-md-2" style="padding:0px 1px 0px 1px !important;">
                            <div class="input-group">
                                <input class="form-control" id="myInbxSrchFor" type = "text" placeholder="Search For" value="<?php echo trim(str_replace("%", " ", $srchFor)); ?>" onkeyup="enterKeyFuncMyInbx(event, '', '#myinbox', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                <input id="myInbxPageNo" type = "hidden" value="<?php echo $pageNo; ?>">
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getMyInbx('clear', '#myinbox', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </label>
                                <label class="btn btn-primary btn-file input-group-addon" onclick="getMyInbx('', '#myinbox', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>')">
                                    <span class="glyphicon glyphicon-search"></span>
                                </label> 
                            </div>
                        </div>
                        <div class="col-md-3" style="padding:0px 1px 0px 1px !important;">
                            <div class="input-group">
                                <span class="input-group-addon">In</span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="myInbxSrchIn">
                                    <?php
                                    $valslctdArry = array("", "", "", "", "");
                                    $srchInsArrys = array("Status", "Source App", "Subject", "Person From", "Message Type");

                                    for ($z = 0; $z < count($srchInsArrys); $z++) {
                                        if ($srchIn == $srchInsArrys[$z]) {
                                            $valslctdArry[$z] = "selected";
                                        }
                                        ?>
                                        <option value="<?php echo $srchInsArrys[$z]; ?>" <?php echo $valslctdArry[$z]; ?>><?php echo $srchInsArrys[$z]; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="input-group-addon" style="max-width: 1px !important;padding:0px !important;width:1px !important;border:none !important;"></span>
                                <select data-placeholder="Select..." class="form-control chosen-select" id="myInbxDsplySze" style="min-width:65px !important;">                            
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
                        <div class="col-md-5" style="padding:0px 1px 0px 1px !important;">
                            <div class="col-xs-6" style="padding:0px 1px 0px 0px !important;">
                                <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                    <input class="form-control" size="16" type="text" id="myInbxStrtDate" name="myInbxStrtDate" value="<?php echo substr($qStrtDte, 0, 11); ?>" placeholder="Start Date">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div></div>
                            <div class="col-xs-6" style="padding:0px 1px 0px 0px !important;">
                                <div class="input-group date form_date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                    <input class="form-control" size="16" type="text"  id="myInbxEndDate" name="myInbxEndDate" value="<?php echo substr($qEndDte, 0, 11); ?>" placeholder="End Date">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div></div>                            
                        </div>
                        <div class="col-md-2" style="padding:0px 1px 0px 1px !important;">
                            <nav aria-label="Page navigation">
                                <ul class="pagination" style="margin: 0px !important;">
                                    <li>
                                        <a  style="padding: 8px 20px 7px 20px !important;" href="javascript:getMyInbx('previous', '#myinbox', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a  style="padding: 8px 20px 7px 20px !important;" href="javascript:getMyInbx('next', '#myinbox', 'grp=<?php echo $group; ?>&typ=<?php echo $type; ?>&pg=<?php echo $pgNo; ?>&vtyp=<?php echo $vwtyp; ?>');" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="row " style="margin-bottom:2px;padding:2px 15px 2px 15px !important">   
                        <div class="col-md-12" style="padding:2px 1px 2px 1px !important;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">
                            <div class="col-md-6" style="padding:0px 1px 0px 1px !important;">
                                <button type="button" class="btn btn-default btn-sm" onclick="checkAllBtns('myInbxTblForm');">
                                    <img src="cmn_images/check_all.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    Check All
                                </button>
                                <button type="button" class="btn btn-default btn-sm" onclick="unCheckAllBtns('myInbxTblForm');">
                                    <img src="cmn_images/selection_delete.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    UnCheck All
                                </button>
                                <button type="button" class="btn btn-default btn-sm" onclick="">
                                    <img src="cmn_images/reassign_users.png" style="left: 0.5%; padding-right: 5px; height:20px; width:auto; position: relative; vertical-align: middle;">
                                    RE-ASSIGN SELECTED LINES
                                </button>
                            </div>
                            <div class="col-md-2" style="padding:5px 1px 0px 1px !important;">
                                <div class="form-check" style="font-size: 12px !important;">
                                    <label class="form-check-label">
                                        <?php
                                        $actvChekd = "";
                                        if ($qActvOnly == "true") {
                                            $actvChekd = "checked=\"true\"";
                                        }
                                        $noLgnChekd = "";
                                        if ($qNonLgn == "true") {
                                            $noLgnChekd = "checked=\"true\"";
                                        }
                                        ?>
                                        <input type="checkbox" class="form-check-input" id="myInbxShwActvNtfs" name="myInbxShwActvNtfs" <?php echo $actvChekd; ?>>
                                        Active Notifications
                                    </label>
                                </div>                            
                            </div>
                            <div class="col-md-2" style="padding:5px 1px 0px 1px !important;">
                                <div class="form-check" style="font-size: 12px !important;">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" id="myInbxShwNonLgnNtfs" name="myInbxShwNonLgnNtfs"  <?php echo $noLgnChekd; ?>>
                                        Non-Logon Notifications
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">&nbsp;</div>
                        </div>
                    </div>
                </form>
                <form id='myInbxTblForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row"> 
                        <div  class="col-md-12">
                            <table class="table table-striped table-bordered table-responsive" id="myInbxTable" cellspacing="0" width="100%" style="width:100%;min-width: 800px;">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>No.</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>Subject</th>
                                        <th>Source App</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Date Sent</th>
                                        <th>Status</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cntr = 0;
                                    while ($row = loc_db_fetch_array($result)) {
                                        $cntr += 1;
                                        ?>
                                        <tr id="myInbxRow<?php echo $cntr; ?>">
                                            <td><input type="checkbox" name="myInbxChkbx<?php echo $cntr; ?>" value="<?php echo $row[0] . ";" . $row[1]; ?>"></td>
                                            <td><?php echo ($curIdx * $lmtSze) + ($cntr); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Details" onclick="getOneMyInbxForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'myInbxDetForm', 'View Message (ID: <?php echo $row[0]; ?> - <?php echo $row[2]; ?>)', <?php echo $row[0]; ?>, 1, <?php echo $pgNo ?>);" style="padding:2px !important;" style="padding:2px !important;">
                                                    <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                    <img src="cmn_images/kghostview.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Approve" onclick="" style="padding:2px !important;" style="padding:2px !important;">
                                                    <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                    <img src="cmn_images/thumbsUp28.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Reject" onclick="" style="padding:2px !important;" style="padding:2px !important;">
                                                    <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                    <img src="cmn_images/thumbsDown28.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Request for Information" onclick="" style="padding:2px !important;" style="padding:2px !important;">
                                                    <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                    <img src="cmn_images/info.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
                                            </td>
                                            <?php if ($row[10] == "1") { ?>
                                                <td><a href="javascript:getOneMyInbxForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'myInbxDetForm', 'View Message (ID: <?php echo $row[0]; ?> - <?php echo $row[2]; ?>)', <?php echo $row[0]; ?>, 1, <?php echo $pgNo ?>);" style="font-weight:normal;color:#0000FF;"><?php echo $row[2]; ?></a></td>
                                            <?php } else { ?>                                                
                                                <td><a href="javascript:getOneMyInbxForm('myFormsModalLg', 'myFormsModalBodyLg', 'myFormsModalTitleLg', 'myInbxDetForm', 'View Message (ID: <?php echo $row[0]; ?> - <?php echo $row[2]; ?>)', <?php echo $row[0]; ?>, 1, <?php echo $pgNo ?>);" style="font-weight:bold;"><?php echo $row[2]; ?></a></td>
                                            <?php } ?>
                                            <td><?php echo $row[11]; ?></td>
                                            <td><?php echo $row[3]; ?></td>
                                            <td><?php echo $row[13]; ?></td>
                                            <td><?php echo $row[5]; ?></td>
                                            <td><?php echo $row[8]; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Attachments" onclick="" style="padding:2px !important;" style="padding:2px !important;">
                                                    <!--<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>-->
                                                    <img src="cmn_images/adjunto.png" style="height:20px; width:auto; position: relative; vertical-align: middle;">
                                                </button>
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
            } else if ($vwtyp == "1") {
                //Get My Inbox Detail
                $result = get_MyInbxDetl($RoutingID);
                ?>
                <form id='myInbxDetForm' action='' method='post' accept-charset='UTF-8'>
                    <div class="row"> 
                        <div  class="col-md-12">
                            <table class="gridtable" id="myInbxDetTable" cellspacing="0" width="100%" style="width:100%;min-width: 400px;">
                                <?php
                                $output = "";
                                $cmpID="";
                                $i = 0;
                                $b = 0;
                                $colsCnt = loc_db_num_fields($result);
                                $msgID = -1;
                                while ($row = loc_db_fetch_array($result)) {
                                    $style = "";
                                    $msgID = $row[1];
                                    for ($d = 0; $d < $colsCnt; $d++) {
                                        $style = "";
                                        $style2 = "";
                                        if (trim(loc_db_field_name($result, $d)) == "mt") {
                                            $style = "style=\"display:none;\"";
                                        }
                                        if ($row[$d] == 'No') {
                                            $style2 = "style=\"color:red;font-weight:bold;\"";
                                        } else if ($row[$d] == 'Yes') {
                                            $style2 = "style=\"color:#32CD32;font-weight:bold;\"";
                                        }
                                        $indx = $i - 1;
                                        $hrf1 = "";
                                        $hrf2 = "";
                                        $labl = ucwords(str_replace("_", " ", loc_db_field_name($result, $d)));
                                        if ($d == 2 || $d == 3 || $d == 4) {
                                            continue;
                                        } else {
                                            $output .= "<tr $style>";
                                            $output .= "<td width=\"20%\" class=\"likeheader\">" . $labl . ":</td>";
                                        }
                                        if ($d == 14 && $row[15] == '0') {
                                            $arry1 = explode(";", $row[$d]);
                                            $output .= "<td $style>";
                                            for ($r = 0; $r < count($arry1); $r++) {
                                                if ($arry1[$r] !== "" && $arry1[$r] != "None") {
                                                    $isadmnonly = getActionAdminOnly($row[0], $arry1[$r]);
                                                    if ($isadmnonly == '0' || $isMaster == 1) {
                                                        $webUrlDsply = getActionUrlDsplyTyp($row[0], $arry1[$r]);
                                                        $hrf1 = "<div style=\"padding:2px;float:left;\">"
                                                                . "<button type=\"button\" class=\"btn btn-primary\""  
                                                                . " onclick=\"actionProcess('$cmpID', '$row[0]','$arry1[$r]','$webUrlDsply','$row[24]','$row[5]','$row[8]','$row[7]');\">";
                                                        $hrf2 = "</button></div>";
                                                        $output .= "$hrf1" . $arry1[$r] . "$hrf2";
                                                    }
                                                }

                                                if ($r == count($arry1) - 1) {
                                                    $webUrlDsply = "";
                                                    $hrf1 = "<div style=\"padding:2px;float:left;\">"
                                                            . "<button type=\"button\" class=\"btn btn-primary\" "
                                                            . "onclick=\"actionProcess('$cmpID', '$row[0]','View Attachments','$webUrlDsply','$row[24]','$row[5]','$row[8]','$row[7]');\">";
                                                    $hrf2 = "</button></div>";
                                                    $output .= "$hrf1" . 'View Attachments' . "$hrf2";
                                                }
                                            }

                                            $output .= "</td>";
                                        } else if ($d == 14 && $row[15] != '0') {
                                            $output .= "<td width=\"70%\" $style2>$hrf1<span style=\"font-weight:bold;font-size:12px;color:green;\">NONE</span>$hrf2</td>";
                                        } else if ($d == 8) {
                                            $output .= "<td width=\"70%\" $style2>$hrf1<span style=\"font-weight:bold;font-size:12px;color:blue;\">" . strtoupper($row[$d]) . "</span>$hrf2</td>";
                                        } else {
                                            $output .= "<td width=\"70%\" $style2>$hrf1" . $row[$d] . "$hrf2</td>";
                                        }
                                        $output .= "</tr>";
                                    }

                                    $i++;
                                    $b++;
                                }
                                echo $output;
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="row"> 
                        <div  class="col-md-12">
                            <table class="gridtable" id="myInbxActionsTable" cellspacing="0" cellpadding="0" width="100%" style="width:100%;min-width: 400px;">   
                                <?php
                                $result1 = get_ActionHistory($msgID);
                                $colsCnt1 = loc_db_num_fields($result1);
                                $output = "
            <caption>ACTION HISTORY</caption>";
                                $output .= "<thead><tr>";
                                $output .= "<th width=\"170px\" style=\"font-weight:bold;\">No.</th>";
                                $output .= "<th width=\"250px\" style=\"font-weight:bold;\">Approvers/Reviewers</th>";
                                $output .= "<th width=\"250px\" style=\"font-weight:bold;\">Action Date</th>";
                                $output .= "<th width=\"250px\" style=\"font-weight:bold;\">Action Performed</th>";
                                $output .= "</tr></thead>";
                                $output .= "<tbody>";
                                while ($row = loc_db_fetch_array($result1)) {
                                    $style = "";
                                    $style2 = "";
                                    $hrf1 = "";
                                    $hrf2 = "";
                                    $output .= "<tr>";
                                    for ($d = 0; $d < $colsCnt1; $d++) {
                                        if (trim(loc_db_field_name($result1, $d)) == "mt") {
                                            continue;
                                        }
                                        $output .= "<td $style>$hrf1" . $row[$d] . "$hrf2</td>";
                                    }
                                    $output .= "</tr>";
                                }
                                $output .= "</tbody>";
                                echo $output;
                                ?>                                
                            </table>
                        </div>
                    </div>
                </form>

                <?php
            } else if ($vwtyp == "2") {
                
            }
        }
    } else {
        sessionInvalid();
    }
}

function get_ActionHistory($msgID) {
    $selSQL = "SELECT row_number() OVER (ORDER BY (CASE WHEN TBL2.date_action_ws_prfmd='' or tbl1.level=-999 THEN 
       TBL2.date_sent
       ELSE 
       TBL2.date_action_ws_prfmd
       END) DESC) AS \"No.  \", 
tbl1.apprvrs AS \"Approvers/Reviewers\",
 (CASE WHEN TBL2.date_action_ws_prfmd='' or tbl1.level=-999 THEN 
       TBL2.date_sent
       ELSE 
       TBL2.date_action_ws_prfmd
       END) mt,
 CASE WHEN TBL2.date_action_ws_prfmd='' or tbl1.level=-999 THEN 
       to_char(to_timestamp(TBL2.date_sent,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS')
       ELSE 
       to_char(to_timestamp(TBL2.date_action_ws_prfmd,'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS')
       END Action_Date,
tbl1.action_performed
 FROM (SELECT a.msg_id, 
string_agg(prs.get_prsn_name(a.to_prsn_id)||' ('||prs.get_prsn_loc_id(a.to_prsn_id)||')', ', ') apprvrs, 
       MAX(a.routing_id) routing_id, 
       CASE WHEN a.status_aftr_action='' THEN
       'Pending'
       ELSE
       a.status_aftr_action
       END action_performed, 
       a.to_prsns_hrchy_level AS \"level\"
  FROM wkf.wkf_actual_msgs_routng a, 
  wkf.wkf_actual_msgs_hdr b
  where a.msg_id=b.msg_id and b.msg_id=" . $msgID . "
  and (a.who_prfmd_action=a.to_prsn_id or a.who_prfmd_action<=0)   
  GROUP BY 1,4,5
  UNION
  SELECT a.msg_id, 
string_agg(prs.get_prsn_name(a.from_prsn_id)||' ('||prs.get_prsn_loc_id(a.from_prsn_id)||')', ', ') apprvrs, 
       MIN(a.routing_id) routing_id, 
       'Initiated' action_performed, 
       -999 AS \"level\"
  FROM wkf.wkf_actual_msgs_routng a, 
  wkf.wkf_actual_msgs_hdr b
  where a.msg_id=b.msg_id and b.msg_id=" . $msgID . "
  and a.routing_id=(SELECT MIN(z.routing_id) FROM wkf.wkf_actual_msgs_routng z WHERE z.msg_id=" . $msgID . ")  
  GROUP BY 1,4,5) tbl1,
  wkf.wkf_actual_msgs_routng tbl2
  WHERE TBL1.routing_id=TBL2.routing_id
  ORDER BY (CASE WHEN TBL2.date_action_ws_prfmd='' or tbl1.level=-999 THEN 
       TBL2.date_sent
       ELSE 
       TBL2.date_action_ws_prfmd
       END) DESC";
    $result = executeSQLNoParams($selSQL);
    return $result;
}

function get_MyInbx($searchFor, $searchIn, $offset, $limit_size) {

    global $user_Name;
    global $qStrtDte;
    global $qEndDte;
    global $qActvOnly;
    global $qNonLgn;
    global $isMaster;
    $user_Name = $_SESSION['UNAME'];

    $prsnID = getUserPrsnID($user_Name);
    $wherecls = "";

    if ($searchIn === "Status") {
        $wherecls = " AND (CASE WHEN a.is_action_done='0' THEN a.msg_status ELSE a.status_aftr_action END ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn === "Source App") {
        $wherecls = " AND ((c.app_name ilike '%" . loc_db_escape_string($searchFor) . "%')"
                . " or (c.source_module ilike '%" . loc_db_escape_string($searchFor) . "%'))";
    } else if ($searchIn === "Subject") {
        $wherecls = " AND (b.msg_hdr ilike '%" . loc_db_escape_string($searchFor) . "%')";
    } else if ($searchIn === "Person From") {
        $wherecls = " AND ((prs.get_prsn_name(a.from_prsn_id) || ' (' || prs.get_prsn_loc_id(a.from_prsn_id) || ')') ilike '%" . loc_db_escape_string($searchFor) . "%')";
    } else if ($searchIn === "Message Type") {
        $wherecls = " AND (b.msg_typ ilike '%" . loc_db_escape_string($searchFor) . "%')";
    }

    if ($qStrtDte != "") {
        $wherecls .= " AND (a.date_sent >= '" . loc_db_escape_string(cnvrtDMYTmToYMDTm($qStrtDte)) . "')";
    }
    if ($qEndDte != "") {
        $wherecls .= " AND (a.date_sent <= '" . loc_db_escape_string(cnvrtDMYTmToYMDTm($qEndDte)) . "')";
    }
    if ($qActvOnly == "true") {
        $wherecls .= " AND (a.is_action_done = '0')";
    }
    if ($qNonLgn == "true") {
        $wherecls .= " AND (lower(c.app_name) NOT like lower('Login'))";
    }
    $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    if ($isMaster == 2) {
        $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    } else if ($isMaster == 1) {
        $extrWhr = "";
    }
    $sqlStr = "SELECT  a.routing_id mt, a.msg_id mt, b.msg_hdr message_header, "
            . "CASE WHEN a.from_prsn_id<=0 THEN 'System Administrator' 
        ELSE prs.get_prsn_name(a.from_prsn_id) || ' (' || prs.get_prsn_loc_id(a.from_prsn_id) || ')' 
        END \"from\", a.to_prsn_id mt, to_char(to_timestamp(a.date_sent,
        'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') \"Date_sent\", a.created_by mt, a.creation_date mt, 
      CASE WHEN a.is_action_done='0' THEN a.msg_status ELSE a.status_aftr_action END message_status,  
      CASE WHEN a.is_action_done='0' THEN a.action_to_perform ELSE a.nxt_action_to_prfm END \"Action(s) To Perform\", 
      a.is_action_done mt, c.app_name mt, c.source_module mt, 
      CASE WHEN a.to_prsn_id<=0 THEN 'System Administrator' 
        ELSE prs.get_prsn_name(a.to_prsn_id) || ' (' || prs.get_prsn_loc_id(a.to_prsn_id) || ')' 
        END \"to\", b.msg_typ message_type, prs.get_prsn_loc_id(a.from_prsn_id) locid 
  FROM wkf.wkf_actual_msgs_routng a, wkf.wkf_actual_msgs_hdr b, wkf.wkf_apps c
WHERE ((c.app_id=b.app_id) AND (a.msg_id=b.msg_id)" . $extrWhr . "$wherecls) ORDER BY a.date_sent DESC LIMIT " . $limit_size . " OFFSET " . abs($offset * $limit_size);

    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function get_MyInbxTtls($searchFor, $searchIn) {
    global $user_Name;
    global $qStrtDte;
    global $qEndDte;
    global $qActvOnly;
    global $qNonLgn;
    global $isMaster;

    $user_Name = $_SESSION['UNAME'];

    $prsnID = getUserPrsnID($user_Name);
    $wherecls = "";

    if ($searchIn === "Status") {
        $wherecls = " AND (CASE WHEN a.is_action_done='0' THEN a.msg_status ELSE a.status_aftr_action END ilike '" . loc_db_escape_string($searchFor) . "')";
    } else if ($searchIn === "Source App") {
        $wherecls = " AND ((c.app_name ilike '%" . loc_db_escape_string($searchFor) . "%')"
                . " or (c.source_module ilike '%" . loc_db_escape_string($searchFor) . "%'))";
    } else if ($searchIn === "Subject") {
        $wherecls = " AND (b.msg_hdr ilike '%" . loc_db_escape_string($searchFor) . "%')";
    } else if ($searchIn === "Person From") {
        $wherecls = " AND (prs.get_prsn_name(a.from_prsn_id) ilike '%" . loc_db_escape_string($searchFor) . "%')";
    } else if ($searchIn === "Message Type") {
        $wherecls = " AND (b.msg_typ ilike '%" . loc_db_escape_string($searchFor) . "%')";
    }

    if ($qStrtDte != "") {
        $wherecls .= " AND (a.date_sent >= '" . loc_db_escape_string(cnvrtDMYTmToYMDTm($qStrtDte)) . "')";
    }
    if ($qEndDte != "") {
        $wherecls .= " AND (a.date_sent <= '" . loc_db_escape_string(cnvrtDMYTmToYMDTm($qEndDte)) . "')";
    }
    if ($qActvOnly == "true") {
        $wherecls .= " AND (a.is_action_done = '0')";
    }
    if ($qNonLgn == "true") {
        $wherecls .= " AND (lower(c.app_name) NOT like lower('Login'))";
    }
    $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    if ($isMaster == 2) {
        $extrWhr = " AND (a.to_prsn_id = " . $prsnID . ")";
    } else if ($isMaster == 1) {
        $extrWhr = "";
    }
    $sqlStr = "SELECT count(1) 
  FROM wkf.wkf_actual_msgs_routng a, wkf.wkf_actual_msgs_hdr b, wkf.wkf_apps c
WHERE ((c.app_id=b.app_id) AND (a.msg_id=b.msg_id)" . $extrWhr . "$wherecls)";
    $result = executeSQLNoParams($sqlStr);
    while ($row = loc_db_fetch_array($result)) {
        return $row[0];
    }
    return 0;
}

function get_MyInbxDetl($routingID) {
    $wherecls = "";
    $wherecls = " AND (a.routing_id = " . loc_db_escape_string($routingID) . ")";

    $sqlStr = "SELECT  a.routing_id mt, a.msg_id mt, 
        c.app_name source_app_name, c.source_module, b.msg_typ message_type,
        CASE WHEN a.from_prsn_id<0 THEN 'System Administrator' 
        ELSE prs.get_prsn_name(a.from_prsn_id) 
        END \"from\", prs.get_prsn_name(a.to_prsn_id) \"to\", to_char(to_timestamp(a.date_sent,
        'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') \"Date_sent\", b.msg_hdr message_header, 
       a.action_comments, 
        b.msg_body message_body,  a.created_by mt, a.creation_date mt, 
       a.msg_status message_status, a.action_to_perform \"Action(s) To Perform\", a.is_action_done mt, 
       CASE WHEN a.is_action_done='1' THEN 'Yes' ELSE 'No' END \"Has Message Been Acted On?\", 
       prs.get_prsn_name(a.who_prfmd_action) \"Action Performed By\", 
       CASE WHEN a.date_action_ws_prfmd='' THEN '' ELSE to_char(to_timestamp(a.date_action_ws_prfmd,
        'YYYY-MM-DD HH24:MI:SS'),'DD-Mon-YYYY HH24:MI:SS') END date_action_was_performed, 
       a.status_aftr_action new_message_status_after_action, 
       a.nxt_action_to_prfm next_action_to_perform, 
       a.who_prfms_next_action \"Who Performes Next Action\", 
       a.last_update_by mt, a.last_update_date mt,
       prs.get_prsn_loc_id(a.from_prsn_id) mt
  FROM wkf.wkf_actual_msgs_routng a, wkf.wkf_actual_msgs_hdr b, wkf.wkf_apps c
WHERE ((c.app_id=b.app_id) AND (a.msg_id=b.msg_id)$wherecls)";

    $result = executeSQLNoParams($sqlStr);
    return $result;
}

function saveReassignForm() {
    global $usrID;
    global $user_Name;
    global $formArray;

    $inptSlctdRtngs = isset($formArray['routingIDs']) ? cleanInputData($formArray['routingIDs']) : "";
//$formName = isset($formArray['formNme']) ? cleanInputData($formArray['formNme']) : "";
    $nwPrsnLocID = isset($formArray['prsnLocID']) ? cleanInputData($formArray['prsnLocID']) : "";
    $raCmmnts = isset($formArray['noticeDetails']) ? cleanInputData($formArray['noticeDetails']) : "";

    $fromPrsnID = getUserPrsnID($user_Name);
    $usrFullNm = getPrsnFullNm($fromPrsnID);

    $nwPrsnID = getPersonID($nwPrsnLocID);
    $nwPrsnFullNm = getPrsnFullNm($nwPrsnID);
    $arry1 = preg_split('/\|/', $inptSlctdRtngs, -1, PREG_SPLIT_NO_EMPTY); //explode("|", $inptSlctdRtngs);
    $affctd = 0;
    $affctd1 = 0;
    $datestr = getFrmtdDB_Date_time();
    for ($i = 0; $i < count($arry1); $i++) {
        $slctRtngID = (float) $arry1[$i];

        $orgPrsnID = (float) getGnrlRecNm("wkf.wkf_actual_msgs_routng", "routing_id", "to_prsn_id", $slctRtngID);
        $orgPrsnNm = getPrsnFullNm($orgPrsnID);
        $rtngMsgID = (float) getGnrlRecNm("wkf.wkf_actual_msgs_routng", "routing_id", "msg_id", $slctRtngID);
        $isActionDone = getGnrlRecNm("wkf.wkf_actual_msgs_routng", "routing_id", "is_action_done", $slctRtngID);

        if ($isActionDone == '0') {
            $affctd += updtWkfMsgReasgnRtng($slctRtngID, $fromPrsnID, $nwPrsnID, $usrID);
            $msgbodyAddOn = "";
            $msgbodyAddOn .= "RE-ASSIGNMENT ON $datestr:- This document has been re-assigned from " . $orgPrsnNm . "'s Inbox to $nwPrsnFullNm" . "'s Inbox by $usrFullNm with the ff Message:<br/>";
            $msgbodyAddOn .= $raCmmnts . "<br/><br/>";
            $affctd1 += updtWkfMsgRtngCmnts($slctRtngID, $msgbodyAddOn, $usrID);
        }
    }

    $msg = "";
    $dsply = "";
    $res = "";
    if ($affctd > 0) {
        $dsply .= "<br/>$affctd Workflow Document(s) Successfully Re-routed to $nwPrsnFullNm!";
        $dsply .= "<br/>$affctd1 Workflow Document(s) Message Comments Successfully Updated!";
        /* if ($formName == "myInbxForm") {
          $dsply.="<br/>Please <a name=\"finishBtn\" id=\"finishBtn\" class=\"button\" onclick=\"getMyInbxPage('nav_inbx', 'first',0,'refresh');\">Click Here to finish!</a>";
          } else {
          $dsply.="<br/>Please <a name=\"finishBtn\" id=\"finishBtn\" class=\"button\" onclick=\"closeMydialog();\">Click Here to finish!</a>";
          } */
        $msg = "<p style = \"text-align:left; color:#32CD32;\"><b><i>$dsply</i></b></p>"; //#32CD32
    } else {
        $dsply .= "<br/>Update Failed! No Workflow Document(s) Re-routed";
        /* if ($formName == "myInbxForm") {
          $dsply.="<br/>Please <a name=\"finishBtn\" id=\"finishBtn\" class=\"button\" onclick=\"getMyInbxPage('nav_inbx', 'first',0,'refresh');\">Click Here to Close!</a>";
          } else {
          $dsply.="<br/>Please <a name=\"finishBtn\" id=\"finishBtn\" class=\"button\" onclick=\"closeMydialog();\">Click Here to Close!</a>";
          } */
        $msg = "<p style = \"text-align:left; color:#ff0000;\"><b><i>$dsply</i></b></p>";
    }
    $res .= $msg;
    return $res;
}

function actOnMsgSQL($routingID, $usr_ID, $actyp) {
    $dsply = "";
    if ($routingID > 0) {
        /*
         * 1. Get sql_behind_action_to_be_performed 
         * E.g. "select wkf.action_sql_for_login({:routing_id},{:userID});"
         * 2. Replace {:routing_id} with $routingID and {:userID} with $usr_ID
         * 3. execute this new sql statement
         * 4. if return is |SUCCESS| display success msg and echo table or detail view
         */
        $sql = getActionSQL($routingID, $actyp);
        $sql = str_replace("{:routing_id}", "$routingID", $sql);
        $sql = str_replace("{:userID}", "$usr_ID", $sql);
        $sql = str_replace("{:actToPrfm}", "$actyp", $sql);
//echo $sql;{:actToPrfm}
        $rtrn_msg = executeActionOnMsg($sql);
        $dsply = str_replace("|SUCCESS|", "", $rtrn_msg);
        $dsply = str_replace("|ERROR|", "", $rtrn_msg);
        if (strpos($rtrn_msg, "|SUCCESS|") === FALSE) {
            $dsply = "<p style=\"text-align:left;font-weight:bold;font-style:italic; color:red;\">$dsply</p>";
        } else {
            $dsply = "<p style=\"text-align:left;font-weight:bold;font-style:italic; color:green;\">$dsply</p>";
        }
        echo $dsply;
    }
}

function downloadForm() {
    global $RoutingID;
    global $smplTokenWord1;

    $msgID = getGnrlRecNm("wkf.wkf_actual_msgs_routng", "routing_id", "msg_id", $RoutingID);
    $attchmnts = getGnrlRecNm("wkf.wkf_actual_msgs_hdr", "msg_id", "attchments", $msgID);
    $attchments_desc = getGnrlRecNm("wkf.wkf_actual_msgs_hdr", "msg_id", "attchments_desc", $msgID);

    $output = "<!-- Form Code Start -->
<div id='rho_form222'>";
    $output .= "<table style=\"width:100%;border-collapse: collapse;border-spacing: 0;margin-top:10px;\" class=\"gridtable\"><tbody>";
    $arry1 = explode(";", $attchmnts);
    $arry2 = explode(";", $attchments_desc);
    for ($r = 0; $r < count($arry1); $r++) {
        if ($arry1[$r] !== "") {
            $arry1[$r] = encrypt1($arry1[$r], $smplTokenWord1);
            $hrf1 = "<tr><td><div style=\"padding:2px;float:none;\">"
                    . "<a class=\"x-btn-default-small\" style=\"color:#fff;text-decoration:none;\" "
                    . "href=\"javascript: dwnldAjxCall('grp=1&typ=11&q=Download&fnm=$arry1[$r]','FileNo$r');\">" . "File No." . ($r + 1) . "-" . $arry2[$r] . " ";
            $hrf2 = "</a></div></td><td><div id=\"FileNo$r\"></div></td></tr>";
            $output .= "$hrf1" . "" . "$hrf2";
        }
    }
    $output .= "</tbody></table>";
    echo $output;
}
?>
