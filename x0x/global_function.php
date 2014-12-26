<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     function
*/

/**
 * IP detector
 */
function getIP(){
    if(getenv('HTTP_X_FORWARDED_FOR')){
        $ip = $_SERVER['REMOTE_ADDR'];
        if(preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", getenv('HTTP_X_FORWARDED_FOR'), $ip3)){
            $ip2 = array('/^0\./', '/^127\.0\.0\.1/', '/^192\.168\..*/', '/^172\.16\..*/', '/^10..*/', '/^224..*/', '/^240..*/');
            $ip = preg_replace($ip2, $ip, $ip3[1]);
        }
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    if($ip == ""){ $ip = "x.x.x.x"; }
    return $ip;
}

/**
Cek php session
 */
function cek_session(){
    global $sql, $SITE_CONF_AUTOLOAD;

    if(!$_COOKIE[$SITE_CONF_AUTOLOAD['cookie']] && !$_SESSION[$SITE_CONF_AUTOLOAD['cookie']]){
            define("USER", FALSE); define("ADMIN", FALSE); define("PENGUNJUNG", TRUE);
    } else {
        list($uid, $upw) = ($_COOKIE[$SITE_CONF_AUTOLOAD['cookie']] ? explode(".", $_COOKIE[$SITE_CONF_AUTOLOAD['cookie']]) : explode(".", $_SESSION[$SITE_CONF_AUTOLOAD['cookie']]));
        if(empty($uid) || empty($upw)){ // corrupt cookie? *wew~ ada heker!*
            isicookie($SITE_CONF_AUTOLOAD['cookie'], "", (time()-2592000));
            $_SESSION[$SITE_CONF_AUTOLOAD['cookie']] = "";
            @session_destroy();
            define("ADMIN", FALSE); define("USER", FALSE); define("U_LEVEL",""); 
            //define("TEKSLOGIN", "Terdeteksi Kesalahan cookie Pada Komputer anda - Keluar Account User.<br /><br />");
            return(FALSE);
        }
        if($sql -> db_Select("`3E_users` `U`", "U.*", "WHERE U.`ID`='$uid' AND U.`user_pass`='".md5($upw)."'")){
            $result = $sql -> db_Fetch(); extract($result);
            define("USER", TRUE);

            define("U_ID", $ID);
            define("U_NAME", $user_login);
            define("U_PASS", $user_pass);
            define("U_NICK", $user_nicename);
            define("U_EMAIL", $user_email);
            define("U_STATUS", $user_status);
            define("U_LEVEL", $user_level);
            define("U_CREATED", $user_registered);
            define("U_DISPLAYNAME", $display_name);

            $sql -> db_Select("`3E_meta_users` `M`", "M.`meta_key` `KEY`, M.`meta_value` `VAL`", "WHERE M.`user_id`='".U_ID."' AND M.meta_option='autoload' ");
            while($row = $sql-> db_Fetch()){
                define("$row[KEY]",$row['VAL']);
            }

            $NOWLOG = U_NOWLOG;

            if((U_NOWLOG + 7200) < time()){
                define("U_LASTLOG", U_NOWLOG);
                $NOWLOG = time();
                $sql -> db_Update("3E_meta_users", "meta_value='".$NOWLOG."' WHERE user_id='".U_ID."' AND meta_key='U_NOWLOG' ");                
                $sql -> db_Update("3E_meta_users", "meta_value='".$NOWLOG."' WHERE user_id='".U_ID."' AND meta_key='U_LASTLOG' ");
            }
            
            if(U_LEVEL > 99){
                define("ADMIN", TRUE);
            } else { 
                define("ADMIN", FALSE);
            }
        } else {
            define("USER", FALSE); define("ADMIN", FALSE);
            define("SALAH_COOKIE",TRUE); define("U_LEVEL","");
        }
    }
}

function isicookie($name, $value, $expire, $path="/", $domain="", $secure=0){
        setcookie($name, $value, $expire, $path, $domain, $secure);
}


function COMOT($table, $return, $value){
    global $sql;
    $sql -> db_Select($table, $return, $value);
    $result = $sql -> db_Fetch();
    return $result[0];
}

function createCode($panjangCode="2"){
    $code = '';
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
    $JumlahKarakter = strlen($chars)-1; 
    
    for($i = 0 ; $i < $panjangCode ; $i++){
        $code .= $chars[rand(0,$JumlahKarakter)];
    }
    return cekCode($code,1);
}

function cekCode($str,$create="") {
    global $sql;
    $sql -> db_Select("3E_codebank", "code", "WHERE code='{$str}'");
    if($sql -> db_Rows()) {
        //hanya ngecek
        if($create) { return createCode();}
        else {return false;}
    }else {return $str;}    
}

function removeAccent($str) {
    $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','Ā','ā','Ă','ă','Ą','ą','Ć','ć','Ĉ','ĉ','Ċ','ċ','Č','č','Ď','ď','Đ','đ','Ē','ē','Ĕ','ĕ','Ė','ė','Ę','ę','Ě','ě','Ĝ','ĝ','Ğ','ğ','Ġ','ġ','Ģ','ģ','Ĥ','ĥ','Ħ','ħ','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Į','į','İ','ı','Ĳ','ĳ','Ĵ','ĵ','Ķ','ķ','Ĺ','ĺ','Ļ','ļ','Ľ','ľ','Ŀ','ŀ','Ł','ł','Ń','ń','Ņ','ņ','Ň','ň','ŉ','Ō','ō','Ŏ','ŏ','Ő','ő','Œ','œ','Ŕ','ŕ','Ŗ','ŗ','Ř','ř','Ś','ś','Ŝ','ŝ','Ş','ş','Š','š','Ţ','ţ','Ť','ť','Ŧ','ŧ','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ų','ų','Ŵ','ŵ','Ŷ','ŷ','Ÿ','Ź','ź','Ż','ż','Ž','ž','ſ','ƒ','Ơ','ơ','Ư','ư','Ǎ','ǎ','Ǐ','ǐ','Ǒ','ǒ','Ǔ','ǔ','Ǖ','ǖ','Ǘ','ǘ','Ǚ','ǚ','Ǜ','ǜ','Ǻ','ǻ','Ǽ','ǽ','Ǿ','ǿ');
    $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
    return str_replace($a, $b, $str);
}

function createSlug($str) {
    return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), removeAccent($str)));
}

function _redirect ( $link ) {
    if ($link == "NYASAR") { 
        echo "<script type='text/javascript'>document.location.href='". x_BASE ."#SECURITY_WARNING/".USERNAME."=nyasar?'</script>\n";
    } else {
        echo "<script type='text/javascript'>document.location.href='". $link ."'</script>\n";
    }
}

?>