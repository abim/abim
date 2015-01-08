<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     API-animeindo.tv.
*/

//live: http://abimanyu.net/exp/anime/api-animeindo.tv.php?m=http://animeindo.tv/NS
//local: http://abim.dev/exp/anime/api-animeindo.tv.php?m=file:///Users/abim/_WWW/abimanyu-git/2015/abim/exp/anime/test/ns.html
$url = $_REQUEST["m"];

if(empty($_REQUEST["m"])) {
    $url = "http://animeindo.tv/NS";
}

$i = new AITV();
$mArr = array_change_key_case($i->getInfo($url), CASE_UPPER);

header('Content-type: application/json');
echo json_encode($mArr);

/**
	CLASS`
*/
class AITV
{
    /**

    */
    var $Url;
    var $LastUrl;
    var $Last_Eps;
    var $Last_Updates;

    function getInfo($Url)
    {
        $this->Url = $Url;
        
        $arr = array();
        $html = $this->geturl($Url);
        if(stripos($html, "<a href=\"http://animeindo.tv\" itemprop=\"url\">") !== false){
            $arr = $this->scrapeInfo($html);
        } else {
            $arr['error'] = "Error cuy!";
        }
        return $arr;
    }
    /**

    */
    function scrapeInfo($html)
    {
        $arr = array();
        $arr['last_episode'] = $this->match('/Latest Episode<\/h4>.*?<span>Episode (\d+)<\/span>/ms', $html, 1);
        $this->Last_Eps = $arr['last_episode'];

        //$LastPagesHtml = $this->geturl("file:///Users/abim/_WWW/abimanyu-git/2015/abim/exp/anime/".$this->Last_Eps.".html");
    	$LastPagesHtml = $this->geturl($this->Url."/".$this->Last_Eps."/");
        
        $arr['judul'] = $this->getJudul($LastPagesHtml);
        $arr['mirror'] = $this->getMirror($LastPagesHtml);
        $arr['last_updates'] = $this->Last_Updates;

        return $arr;
    }

    /**
    JUDUL
    */
    function getJudul($html) {
        $judul = $this->match('/<span itemprop="title">Episode '.$this->Last_Eps.': (.*?)<\/span>/ms', $html, 1);
        return $judul;
    }

    /**
    MIRROR
    */
    function getMirror($html) {
        $mirror = array();
        foreach ( $this->match_all ('/<div class="node(.*?)<\/i>/ms', $this->match ('/<div class="eps_lst_tbn">(.*?)<div class="clr">/ms', $html, 1), 0) as $inline_mirror) 
        {
            $name = $this->match('/<div>(.*?)<\/div>/ms', $inline_mirror, 1);
            $update = $this->match('/<i>(.*?)<\/i>/ms', $inline_mirror, 1);
            $url = $this->match('/href="(.*?)">/ms', $inline_mirror, 1);
            //$mirrorHtml = $this->geturl("file:///Users/abim/_WWW/abimanyu-git/2015/abim/exp/anime/393.html");
            $mirrorHtml = $this->geturl(trim($url));
            $iframe = $this->match ('/IFRAME SRC="(.*?)"/ms', $this->match ('/<div class="prw">(.*?)<div class="eps_ifo">/ms', $mirrorHtml, 1), 1);
            array_push($mirror, array(
                'name'=>trim(strip_tags($name)), 
                'update'=>trim(strip_tags($update)), 
                'iframe'=>trim(strip_tags($iframe)), 
                'url'=>trim(strip_tags($url))
            ));

            $this->Last_Updates = trim($update);
        }
        return $mirror;
    }

    /**

    CORE 

    */
    function geturl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $ip=rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/".rand(3,5).".".rand(0,3)." (Windows NT ".rand(3,5).".".rand(0,2)."; rv:2.0.1) Gecko/20100101 Firefox/".rand(3,5).".0.1");
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }
 
    function match_all($regex, $str, $i = 0){
        if(@preg_match_all($regex, $str, $matches) === false)
            return false;
        else
            return $matches[$i];
    }
 
    function match($regex, $str, $i = 0){
        if(@preg_match($regex, $str, $match) == 1)
            return $match[$i];
        else
            return false;
    }
}
?>