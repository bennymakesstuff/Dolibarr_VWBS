<?php
/* Copyright (C) 2020 Benjamin Broad
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \file    wbs/css/wbs.css.php
 * \ingroup wbs
 * \brief   CSS file for module WBS.
 */

//if (! defined('NOREQUIREUSER')) define('NOREQUIREUSER','1');	// Not disabled because need to load personalized language
//if (! defined('NOREQUIREDB'))   define('NOREQUIREDB','1');	// Not disabled. Language code is found on url.
if (! defined('NOREQUIRESOC'))    define('NOREQUIRESOC', '1');
//if (! defined('NOREQUIRETRAN')) define('NOREQUIRETRAN','1');	// Not disabled because need to do translations
if (! defined('NOCSRFCHECK'))     define('NOCSRFCHECK', 1);
if (! defined('NOTOKENRENEWAL'))  define('NOTOKENRENEWAL', 1);
if (! defined('NOLOGIN'))         define('NOLOGIN', 1);          // File must be accessed by logon page so without login
//if (! defined('NOREQUIREMENU'))   define('NOREQUIREMENU',1);  // We need top menu content
if (! defined('NOREQUIREHTML'))   define('NOREQUIREHTML', 1);
if (! defined('NOREQUIREAJAX'))   define('NOREQUIREAJAX', '1');

// Load Dolibarr environment
$res=0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (! $res && ! empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res=@include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp=empty($_SERVER['SCRIPT_FILENAME'])?'':$_SERVER['SCRIPT_FILENAME'];$tmp2=realpath(__FILE__); $i=strlen($tmp)-1; $j=strlen($tmp2)-1;
while($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i]==$tmp2[$j]) { $i--; $j--; }
if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/main.inc.php")) $res=@include substr($tmp, 0, ($i+1))."/main.inc.php";
if (! $res && $i > 0 && file_exists(substr($tmp, 0, ($i+1))."/../main.inc.php")) $res=@include substr($tmp, 0, ($i+1))."/../main.inc.php";
// Try main.inc.php using relative path
if (! $res && file_exists("../../main.inc.php")) $res=@include "../../main.inc.php";
if (! $res && file_exists("../../../main.inc.php")) $res=@include "../../../main.inc.php";
if (! $res) die("Include of main fails");

require_once DOL_DOCUMENT_ROOT.'/core/lib/functions2.lib.php';

session_cache_limiter('public');
// false or '' = keep cache instruction added by server
// 'public'  = remove cache instruction added by server and if no cache-control added later, a default cache delay (10800) will be added by PHP.

// Load user to have $user->conf loaded (not done by default here because of NOLOGIN constant defined) and load permission if we need to use them in CSS
/*if (empty($user->id) && ! empty($_SESSION['dol_login']))
{
    $user->fetch('',$_SESSION['dol_login']);
	$user->getrights();
}*/


// Define css type
header('Content-type: text/css');
// Important: Following code is to cache this file to avoid page request by browser at each Dolibarr page access.
// You can use CTRL+F5 to refresh your browser cache.
if (empty($dolibarr_nocache)) header('Cache-Control: max-age=10800, public, must-revalidate');
else header('Cache-Control: no-cache');

?>

.vwbsOuter {
	position: relative;
}

#vwbsBox {
	    position: fixed;
	    top: calc(50vh - 200px);
	    left: calc(50vw - 300px);
	    width: 600px;
	    height: 400px;
	    background-color: #ffffff;
	    border: 1px solid #ffffff;
	    border-radius: 0.25rem;
	    padding: 1rem;
	    z-index: 100;
	    box-shadow: 1px 2px 7px #888888;}

#vwbsButton {background-color: #800000;
					    color: #ffffff;
					    border: 0;
					    padding: 0.5rem 1rem;
					    cursor: pointer;}

#wbsButton {background-color: #800000;
					    color: #ffffff;
					    border: 0;
					    padding: 0.5rem 1rem;
					    cursor: pointer;}

#vwbsClose {position: absolute;
						top: 0px;
						right: 10px;
						cursor: pointer;
						color: #6b6b6b;
						font-size: 1.5rem;
    				font-family: verdana;
						}

#vwbsClose:hover {color: #2f2f2f;}

#vwbsTitle {width: 100%;margin-bottom: 1rem;font-weight: 600;}

#vwbsMiddle {width: 100%;
						}

.vwbsListTitle {display: inline-block;
    vertical-align: top;
    background-color: #fdfdfd;
    height: 40px;
    width: 197px;
    border: 1px solid #eaeaea;
    border-right: 0;
		border-bottom: 0;
		line-height: 40px;
		text-align: center;}

.vwbsListTitle:last-child {border-right: 1px solid #eaeaea;}
.lastTitle {border-right: 1px solid #eaeaea;}

.itemselected {background-color: #800000 !important;
					    color: #ffffff !important;}

.vwbsList {display: inline-block;
    vertical-align: top;
    background-color: #fdfdfd;
    height: 320px;
    width: 197px;
    border: 1px solid #eaeaea;
    border-right: 0;
		overflow-y: scroll;
		overflow-x: hidden;}

.vwbsListItem {height: 30px;
							width: 100%;
							line-height: 30px;
							padding: 5px;
							cursor: pointer;
							white-space: nowrap;
						  overflow: hidden;
						  text-overflow: ellipsis;}

.vwbsListItem:nth-child(odd) {background-color: #ffffff;}

.vwbsListItem:hover {background-color: #ddeffb;}

.vwbsList:last-child {border-right: 1px solid #eaeaea;}

#vwbsBottom {width: 100%;}

.hidden {display: none;}
.shown {display: block;}

.lds-facebook {
  display: inline-block;
  position: relative;
  width: 20px;
  height: 20px;
}
.lds-facebook div {
  display: inline-block;
  position: absolute;
  left: 8px;
  width: 16px;
  background: rgba(#810303, 0.49);
  animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
}
.lds-facebook div:nth-child(1) {
  left: 8px;
  animation-delay: -0.24s;
}
.lds-facebook div:nth-child(2) {
  left: 32px;
  animation-delay: -0.12s;
}
.lds-facebook div:nth-child(3) {
  left: 56px;
  animation-delay: 0;
}
@keyframes lds-facebook {
  0% {
    top: 8px;
    height: 20px;
  }
  50%, 100% {
    top: 24px;
    height: 8px;
  }
}
