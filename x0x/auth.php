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
//require_once(c_ADMINDIR."global/conf.php");
if(USER){
	
	if(x_QUERY == "keluar"){
		$opdata = (USER === TRUE) ? U_ID.".".U_PASS : "0";
		$sql -> db_Update("3E_meta_users", "meta_value='".time()."' WHERE user_id='".U_ID."' AND meta_key='U_LASTLOG' ");
		$sql -> db_Update("3E_meta_users", "meta_value='".getIP()."' WHERE user_id='".U_ID."' AND meta_key='U_IP' ");
	    
    	if($SITE_CONF_AUTOLOAD['tracking'] == "session"){ session_destroy(); $_SESSION[$SITE_CONF_AUTOLOAD['cookie']] = ""; }
    	isicookie($SITE_CONF_AUTOLOAD['cookie'], "", (time()-2592000));
    	echo "<script type='text/javascript'>document.location.href='".x_XELF."'</script>\n";
    	exit;
	}

}else{
	if(isset($_POST['LoginSubmit'])){
		$objek = new auth;

		$sandiuser = md5(md5(trim($_POST['authsandi'])));

		$row = $authresult = $objek -> authproses($_POST['authnama'], $sandiuser);
		if($row[0] == "salah"){
			echo "<script type='text/javascript'>document.location.href='?x'</script>\n";
		}else{
			$autolog = $_POST['autologin'];

			$cookiepass = md5(trim($_POST['authsandi']));
			$cookieval = $row['ID'].".".$cookiepass;

			$sql -> db_Insert("users_stat_login", "'0', '".$row['ID']."', NOW(), '".getIP()."', '".$_SERVER['HTTP_USER_AGENT']."','' ");
			$sql -> db_Update("3E_meta_users", "meta_value=meta_value+1 WHERE user_id='".$row['ID']."' AND meta_key='U_TOTAL_LOGIN' ");

			if($SITE_CONF_AUTOLOAD['tracking'] == "session"){
				$_SESSION[$SITE_CONF_AUTOLOAD['cookie']] = $cookieval;
				
			}else{
				if($autolog == 1){
						isicookie($SITE_CONF_AUTOLOAD['cookie'], $cookieval, ( time()+3600*24*30));
						
					}else{
						isicookie($SITE_CONF_AUTOLOAD['cookie'], $cookieval, ( time()+3600*3));
						
					}
			}
			// JANGAN_LUPA_FUNCTION_UPDATE_CACHE_STATISTIK()
			// blablabla

			echo "<script type='text/javascript'>document.location.href='".$_POST['redirect_to']."'</script>\n";
		}
	}
	
	$objek = new auth;

	if(x_QUERY == "x"){
		$isiteks = "Oops...";
		$objek -> tampilanlogin($isiteks);
		exit;
	}
	if(x_QUERY == "s"){
		$isiteks = "Pergantian Password SUKSES";
		$objek -> tampilanlogin($isiteks);
		exit;
	}

	if(USER == FALSE){
		$objek -> tampilanlogin();
		exit;
	}
}
/**

*/
class auth{

	function tampilanlogin($isiteks="Sign in to continue to 3E Labs"){
		global $SITE_CONF_AUTOLOAD;
		$NODE = "Sign In";
		@require (x_PATH."/header.php");
		@require (x_PATH."/login.php");
	}

/**

*/
	function authproses($authnama, $authsandi){
		global $sql;
		$authnama = ereg_replace("\sOR\s|\=|\#", "", $authnama);
		if($sql -> db_Select("3E_users", "ID", "WHERE `user_login`='".$authnama."' AND `user_pass`='".$authsandi."'")){
			$row = $sql -> db_Fetch();
			return $row;
		}else{
			$row = array("salah");
			return $row;
		}		
	}
}
?>