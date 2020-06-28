<?php

// This file gets the VWBS Name based on a passed in number.

/* Copyright (C) 2001-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2015      Jean-François Ferry	<jfefe@aternatik.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *	\file       openprospects/loadDoliUsers.php
 *	\ingroup    openprospects
 *	\brief      This file loads the Dolibarr users for use in this module / DOM.
 */

// Load Dolibarr environment
$res=0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (! $res && ! empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res=@include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp=empty($_SERVER['SCRIPT_FILENAME'])?'':$_SERVER['SCRIPT_FILENAME'];$tmp2=realpath(__FILE__); $i=strlen($tmp)-1; $j=strlen($tmp2)-1;
while($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i]==$tmp2[$j]) { $i--; $j--; }
if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/main.inc.php")) $res=@include substr($tmp, 0, ($i+1))."/main.inc.php";
if (! $res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i+1)))."/main.inc.php")) $res=@include dirname(substr($tmp, 0, ($i+1)))."/main.inc.php";
// Try main.inc.php using relative path
if (! $res && file_exists("../main.inc.php")) $res=@include "../main.inc.php";
if (! $res && file_exists("../../main.inc.php")) $res=@include "../../main.inc.php";
if (! $res && file_exists("../../../main.inc.php")) $res=@include "../../../main.inc.php";
if (! $res) die("Include of main fails");

//require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';



//Create the data return object.
$object = new stdClass();

if(isset($_POST['wbs_parent'])){

  $vwbscode = $_POST['wbs_parent'];

  //This query just selects the users by those who are in groups

  if($_POST['wbs_checkFirst']=="true"){
    $sql = "SELECT * FROM doli_wbs_wbs_fields WHERE vwbs_parent='1' ORDER BY rowid ASC";
  }
  else{
    $sql = "SELECT * FROM doli_wbs_wbs_fields WHERE vwbs_parent='".$vwbscode."' ORDER BY rowid ASC";
  }


  $vwbsTypes = null;

   $object->payload = [$sql];

  $response=$db->query($sql);
  if ($response)
  {
  	$num = $db->num_rows($response);
  	$i = 0;
    //$object->payload = [$num];
  	if ($num)
  	{
      if($num != 0){
        // Rows exist
        while($i < $num){

    		    $object->payload[$i] = $db->fetch_object($vwbsTypes);

        $i++;
        }
      }
      else{
        // No Rows
        $object->payload = "No Rows";
      }
    }
  	else{
  		$vwbsTypes = "FAILURE: SQL Returned ".$num." results";
  	}
    $vwbsTypes = "FAILURE: SQL Request Success";
  }
  else{
  	$vwbsTypes = "FAILURE: SQL Request Failed";
  }

  $object->result = true;
  $object->request = $_POST['wbs_parent'];
  $object->first = $_POST['wbs_checkFirst'];
  //$object->payload = $vwbscode;
  $result = $object;
}
else {
  $object->result = false;
  $result = $object;
}


print json_encode($result);

/*

$list = [
  ['100','Mechanical'],
  ['200','Paintwork'],
  ['300','Some other thing'],
  ['400','Rear End Works'],
  ['500','Electrical work'],
  ];


if(isset($_POST['wbs_parent'])){

  if($_POST['wbs_parent']==0){
    $list = [
      ['100','Mechanical'],
      ['200','Paintwork'],
      ['300','Some other thing'],
      ['400','Rear End Works'],
      ['500','Electrical work'],
      ['600','Mechanical'],
      ['700','Paintwork'],
      ['800','Some other thing'],
      ['900','Rear End Works'],
      ];
  }
  else if($_POST['wbs_parent']==100){
    $list = [
      ['110','Front End'],
      ['120','Steering'],
      ['130','Back End'],
      ['140','Interior'],
      ];
  }
  else if($_POST['wbs_parent']==200){
    $list = [
      ['210','Preperation'],
      ['220','Paint Work'],
      ['230','Finish'],
      ];
  }
  else if($_POST['wbs_parent']==300){
    $list = [
      ['310','Mechanical'],
      ['320','Paintwork'],
      ['330','Some other thing'],
      ['340','Rear End Works'],
      ['350','Electrical work'],
      ['360','Mechanical'],
      ['370','Paintwork'],
      ['380','Some other thing'],
      ['390','Rear End Works'],
      ];
  }
  else if($_POST['wbs_parent']==110){
    $list = [
      ['111','Front Suspension'],
      ['112','Differential'],
      ['113','Lights'],
      ['114','Radiator'],
      ];
  }
  else if($_POST['wbs_parent']==120){
    $list = [
      ['121','Steering Column'],
      ['122','Anti Sway Bar'],
      ['123','Steering Wheel'],
      ['124','Power Steering Unit'],
      ];
  }
  else {
    $list = [
      ['100','Mechanical'],
      ['200','Paintwork'],
      ['300','Some other thing'],
      ['400','Rear End Works'],
      ['500','Electrical work'],
      ['600','Mechanical'],
      ['700','Paintwork'],
      ['800','Some other thing'],
      ['900','Rear End Works'],
      ];
  }


  $object->result = true;
  $object->request = $_POST['wbs_parent'];
  $object->payload = $list;
  $response = $object;
}
else {
  $object->result = false;
  $response = $object;
}


echo json_encode($response);*/
 ?>
