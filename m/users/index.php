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
@include ("../../x0x/render.php");
$NODE = "Users";
$nav="m";
@include (x_PATH."/header.php");
@include (x_PATH."/nav.php");
?>

<div class="page-header">
  <h1><?php echo $NODE;?> <small>Management</small></h1>
</div>

<ul class="breadcrumb">
  <li><i class="icon-home"></i> <a href="../">Home</a> <span class="divider">/</span></li>
  <li class="active">Users Management</li>
</ul>

<ul class="nav nav-tabs">
  <li class="dropdown active"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> Users <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li class="active"><a href="./"><i class="icon-user"></i> Users Lists</a></li>
      <li><a href="./badges"><i class="icon-tags"></i> Badges</a></li>
    </ul>
  </li>
  <li><a href="./#"><i class="icon-bullhorn"></i> Statistics</a></li>
  <li><a href="./#"><i class="icon-folder-open"></i> Files</a></li>
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