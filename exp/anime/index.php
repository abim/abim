<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     template-landing
*/
@include ("../../x0x/render.php");

$NODE = "Dashboard";
@include ("con.php");
@include (x_PATH."/header.php");
@include (x_PATH."/nav.php");
?>

<div class="page-header">
  <h3><div><img src="logo.svg" alt="" style="max-width:1.5em;" /> <?php echo $NODE_PARENT." <small>".$NODE."</small>";?></div></h3>
</div>

<section id="tables">
  <div class="row">
    <div class="col-md-2">
      <ul class="nav nav-list">
        <li class="nav-header">Menus</li>
        <li class="active"><a href="./">List Anime<span class="badge pull-right">2</span></a></li>
        <li><a href="#post">Sites<span class="badge pull-right">add</span></a></li>
        <li class="divider"></li>
        <li class="nav-header">Attribute</li>
        <li><a href="#fakelink">Settings<span class="fui-gear pull-right"></span></a></li>
      </ul>
    </div> <!-- /nav-list -->

    <div class="col-md-10">
      <h6>List Anime</h6>
      <form class="form-horizontal" method='post' action='<?php echo x_SELF;?>'>
      <fieldset>
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Last Episode</th>
                  <th>Updates</th>
                  <th>Mirror</th>
                  <th>Titles</th>
                  <th>Provider</th>
                </tr>
              </thead>
              <tbody>
              <?php

              //$NS_JSON = geturl("http://abim.dev/exp/anime/api-animeindo.tv.php?m=file:///Users/abim/_WWW/abimanyu-git/2015/abim/exp/anime/ns.html");
              $NS_JSON = geturl("http://abimanyu.net/exp/anime/api-animeindo.tv.php?m=http://animeindo.tv/NS");
              $NS = json_decode($NS_JSON, true);
              echo "
                <tr>
                  <td>Naruto Shippunden</td>
                  <td>".$NS['LAST_EPISODE']."</td>
                  <td>".$NS['LAST_UPDATES']."</td>
                  <td>
                    <div class=\"mbl\">
                      <div class=\"btn-group btn-group-sm\">
                        <button class=\"btn btn-success\">Mirror</button>
                        <button class=\"btn btn-success dropdown-toggle\" data-toggle=\"dropdown\">
                          <span class=\"caret\"></span>
                        </button>
                        <ul class=\"dropdown-menu dropdown-inverse\">";
                foreach ($NS['MIRROR'] as $key=>$value){
                  echo "
                      <li><a href=\"".$value['iframe']."\" target=\"_blank\">".$value['name']." - ".$value['update']."</a></li>           
                        ";
                }
              echo "    </ul>
                      </div>
                    </div>
                  </td>
                  <td>".$NS['JUDUL']."</td>
                  <td>animeindo.tv</td>
                </tr>
              ";

              $OP_JSON = geturl("http://abimanyu.net/exp/anime/api-animeindo.tv.php?m=http://animeindo.tv/OP");
              $OP = json_decode($OP_JSON, true);
              echo "
                <tr>
                  <td>One Piece</td>
                  <td>".$OP['LAST_EPISODE']."</td>
                  <td>".$OP['LAST_UPDATES']."</td>
                  <td>
                    <div class=\"mbl\">
                      <div class=\"btn-group btn-group-sm\">
                        <button class=\"btn btn-success\">Mirror</button>
                        <button class=\"btn btn-success dropdown-toggle\" data-toggle=\"dropdown\">
                          <span class=\"caret\"></span>
                        </button>
                        <ul class=\"dropdown-menu dropdown-inverse\">";
                foreach ($OP['MIRROR'] as $key=>$value){
                  echo "
                      <li><a href=\"".$value['iframe']."\" target=\"_blank\">".$value['name']." - ".$value['update']."</a></li>           
                        ";
                }
              echo "    </ul>
                      </div>
                    </div>
                  </td>
                  <td>".$OP['JUDUL']."</td>
                  <td>animeindo.tv</td>
                </tr>
              ";
              ?>
              <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>
              <tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td></tr>
              </tbody>
            </table>
          </div>      
        </div>
        </fieldset>
      </form>
    
    </div>
  </div>
</section>
<?php
/**

*/

/**
jquery
*/
$SCRIPT_FOOTER = "
";

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

@include (x_PATH."/footer.php");
?> 