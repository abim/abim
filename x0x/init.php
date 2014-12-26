<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     init_user_auth
*/

if(x_QUERY == "keluar"){
    $ip = lacakIP();
	$opdata = (OP === TRUE) ? OPID.".".OPNAMA : "0";
	$catat_last_login = $sql -> db_Update("users", "hit=hit+1, lastlog='".time()."', ip='".lacakIP()."' WHERE id_user = '".U_ID."'");
    if($catat_last_login){
    	if($SITE_CONF_AUTOLOAD['tracking'] == "session"){ session_destroy(); $_SESSION[$SITE_CONF_AUTOLOAD['cookie']] = ""; }
    	isicookie($SITE_CONF_AUTOLOAD['cookie'], "", (time()-2592000));
    	//echo "<script type='text/javascript'>document.location.href='".x_ADMINDIR."'</script>\n";
    	exit;
    }
}

?>