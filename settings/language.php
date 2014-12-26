<?php
/**
* @package      Abim 1.0
* @version      0.1.0
* @author       Rosi Abimanyu Yusuf <bima@abimanyu.net>
* @license      http://creativecommons.org/licenses/by-nc/3.0/ CC BY-NC 3.0
* @copyright    2015 underlegal PT. indobit.
* @since        File available since Release 1.0
* @category     product-usermanuals
*/
@include ("../x0x/render.php");
$NODE = "Language";
@include (x_PATH."/header.php");
@include (x_PATH."/nav.php");
/**
AUTH
*/
?>
<div class="page-header">
  <h1><?php echo $NODE;?> <small>Settings</small></h1>
</div>

<ul class="breadcrumb">
  <li><i class="icon-home"></i> <a href="../">Home</a> <span class="divider">/</span></li>
  <li><a href="./">Settings</a> <span class="divider">/</span></li>
  <li class="active"><?php echo $NODE;?></li>
</ul>

<ul class="nav nav-tabs">
  <li><a href="./"><i class="icon-globe"></i> Global</a></li>
  <li class="active"><a href="./language"><i class="icon-bullhorn"></i> <?php echo $NODE;?></a></li>
  <li><a href="./files-extentions"><i class="icon-folder-open"></i> Files</a></li>
</ul>

  <div class="row">
<?php /**
Kiri
*/?>
    <div class="span6" id="dashboard">
      <div class="page-header">
<?php
/**
add new
*/
if(isset($_POST['FormSubmit']) && !empty($_POST['key'])) {
  $sql -> db_Insert("3E_taxonomy", "'0', 'lang', '".$_POST['key']."', '".$_POST['value']."', '', '0' ");
  setcookie ("IN_input", $_POST['value'], (time()+100)); //add cookie
  return _redirect ( "?sip" );
}
if(x_QUERY == "sip"){
  echo "
    <div class=\"alert alert-success\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
      <strong>Success</strong>. <span class=\"label label-success\">{$_COOKIE['IN_input']}</span>
    </div>
    ";
    setcookie ("IN_input", $_POST['value'], (time()-100)); //delete cookie
}
?>
        
        <form class="form-horizontal clerfix" method='post' action='<?php echo x_SELF;?>'>
          <div class="control-group">
            <label class="control-label" for="value">Language</label>
            <div class="controls">
              <input class="span4" type="text" id="value" name="value" placeholder="Bahasa Indonesia">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="key">Slug</label>
            <div class="controls">
              <input type="text" id="key" name="key" placeholder="ID">
            </div>
          </div>
          <div class="control-group">
            <div class="controls"><p>&nbsp;</p>
              <button type="submit" name="FormSubmit" value="submit" class="btn btn-large btn-primary">Add <?php echo $NODE;?></button>
            </div>
          </div>
        </form>
      </div>

      <div class="page-header">
        <h4>Development Status</h4>
        <ul class="unstyled">
          <li><i class="icon-pencil"></i> edit</li>
          <li><i class="icon-remove"></i> delete</li>
        </ul>
      </div>

    </div>
<?php /**
Kanan
*/?>
    <div class="span6" id="dashboard">

      <h4><?php echo $NODE;?></h4>
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Slug</th>
            <th><?php echo $NODE;?></th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $sql -> db_Select("3E_taxonomy T", "T.key, T.value", "WHERE T.type='lang'");
          while($row = $sql-> db_Fetch())
          {
            echo "
          <tr>
            <td>{$row['key']}</td>
            <td>{$row['value']}</td>
          </tr>
          ";
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>
</section>
<?php
@include (x_PATH."/footer.php");
?> 