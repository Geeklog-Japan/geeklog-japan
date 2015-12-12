<?php

// +---------------------------------------------------------------------------+
// | CAPTCHA v3.5 Plugin                                                       |
// +---------------------------------------------------------------------------+
// | Qaptcha.jquery.php                                                        |
// +---------------------------------------------------------------------------|
// | Copyright (C) 2009-2010 by the following authors:                         |
// |                                                                           |
// | ben           cordiste AT free DOT fr                                     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//

// Prevent PHP from reporting uninitialized variables
error_reporting( E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR );
require_once('../../lib-common.php');

$aResponse['error'] = false;

$vars = array('action' => 'text',
              'qaptcha_key' => 'text',
			  'csid'        => 'alpha');
			  
CAPTCHA_filterVars($vars, $_POST);
	
if(isset($_POST['action']) && isset($_POST['qaptcha_key']))
{
	
	if(htmlentities($_POST['action'], ENT_QUOTES, 'UTF-8') == 'qaptcha' && $_POST['csid'] !='' )
	{
		
		$sql = "UPDATE {$_TABLES['cp_sessions']} SET validation='" . $_POST['qaptcha_key'] . "' WHERE session_id='" . $_POST['csid'] . "'";
		if ($_CP_CONF['debug'] == 1) CAPTCHA_errorLog("Debug: qaptcha ajax " . $sql, 1);
        DB_query($sql);
		
		echo json_encode($aResponse);
	}
	else
	{
		$aResponse['error'] = true;
		echo json_encode($aResponse);
	}
}
else
{
	$aResponse['error'] = true;
	echo json_encode($aResponse);
}