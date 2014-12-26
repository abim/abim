<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     settings
*/
@include ("../x0x/render.php");
$NODE = "Global";
@include (x_PATH."/header.php");
@include (x_PATH."/nav.php");
?>

<div class="page-header">
  <h1><?php echo $NODE;?> <small>Settings</small></h1>
</div>

<ul class="breadcrumb">
  <li><i class="icon-home"></i> <a href="../">Home</a> <span class="divider">/</span></li>
  <li class="active">Settings</li>
</ul>

<ul class="nav nav-tabs">
  <li class="active"><a href="./"><i class="icon-globe"></i> Global</a></li>
  <li><a href="./language"><i class="icon-bullhorn"></i> Language</a></li>
  <li><a href="./files-extentions"><i class="icon-folder-open"></i> Files</a></li>
</ul>

<div class="row">

  <div class="span4" id="dashboard">
    <p></p>
  </div>

  <div class="span4" id="products">
    <p></p>
  </div>

  <div class="span4" id="new">
    <p></p>
  </div>

</div>
<?php
@include (x_PATH."/footer.php");
?> 