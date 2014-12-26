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
@include ("../../x0x/render.php");
if(U_LEVEL < 90) { _redirect("NYASAR");}

$NODE = "Badges";
$nav="m";
@include (x_PATH."/header.php");
@include (x_PATH."/nav.php");
/**
AUTH
*/
?>
<div class="page-header">
  <h1><?php echo $NODE;?> <small>Management</small></h1>
</div>

<ul class="breadcrumb">
  <li><i class="icon-home"></i> <a href="../">Home</a> <span class="divider">/</span></li>
  <li><a href="./">Users Management</a> <span class="divider">/</span></li>
  <li class="active"><?php echo $NODE;?></li>
</ul>

<ul class="nav nav-tabs">
  <li class="dropdown active"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user"></i> Users <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="./"><i class="icon-user"></i> Users Lists</a></li>
      <li class="active"><a href="./badges"><i class="icon-tags"></i> Badges</a></li>
    </ul>
  </li>
  <li><a href="./#"><i class="icon-bullhorn"></i> Statistics</a></li>
  <li><a href="./#"><i class="icon-folder-open"></i> Files</a></li>
</ul>

  <div class="row">
<?php /**
Kiri
*/?>
    <div class="span6" id="dashboard">

      <h4><?php echo $NODE;?></h4>
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th><?php echo $NODE;?> Name</th>
            <th>Group</th>
            <th>Poin</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $sql -> db_Select("users_badges UB", "UB.*", "ORDER BY `group`");
          while($row = $sql-> db_Fetch())
          {
            echo "
          <tr>
            <td><span class=\"label label-{$row['label']}\">{$row['name']}</span>
            <p>{$row['descriptions']}</p></td>
            <td>{$row['group']}</td>
            <td>{$row['poin_bonus']}</td>
          </tr>
          ";
          }
          ?>
        </tbody>
      </table>
    </div>

<?php /**
Kanan
*/?>
    <div class="span6" id="dashboard">
      <div class="page-header">
        <h4><?php echo $NODE;?></h4>
<?php
/**
add new
*/
if(isset($_POST['FormSubmit']) && !empty($_POST['name'])) {
  $sql -> db_Insert("users_badges", "'0', '".$_POST['name']."', '".$_POST['desc']."', '".$_POST['poin']."', '".$_POST['group']."', '".$_POST['label']."','".$_POST['icons']."' ");
  setcookie ("IN_input", $_POST['name'], (time()+100)); //add cookie
  return _redirect ( "?sip" );
}
if(x_QUERY == "sip"){
  echo "
    <div class=\"alert alert-success\">
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
      <strong>Success</strong>. <span class=\"label label-success\">{$_COOKIE['IN_input']}</span>
    </div>
    ";
    setcookie ("IN_input", $_POST['name'], (time()-100)); //delete cookie
}
?>
        
        <form class="form-horizontal clerfix" method='post' action='<?php echo x_SELF;?>'>
          <div class="control-group">
            <label class="control-label" for="name">Badges</label>
            <div class="controls">
              <input class="span4" type="text" id="name" name="name" placeholder="Email Verified">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="value">Descriptions</label>
            <div class="controls">
              <textarea class="span4" id="desc" name="desc"  placeholder="Account verified by email"></textarea>
            </div>
          </div>          

          <div class="control-group">
            <label class="control-label" for="poin">Poin Bonus</label>
            <div class="controls">
              <input type="text" id="poin" name="poin" placeholder="10"><span class="help-inline">10 POIN = Rp.1000,- / $0.1</span>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="group">Group</label>
            <div class="controls">
              <select id="group" name="group">
                <option value="Accomplishments">Accomplishments</option>
                <option value="Staff">Staff</option>
                <option value="Community">Community</option>
                <option value="Events">Events</option>
                <option value="Poins">Poins</option>
                <option value="Cash">Cash Payments</option>
                <option value="Referrals">Referrals</option>
              </select>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="label">Label</label>
            <div class="controls">
              <label class="radio inline">
                <input type="radio" name="label" id="label" value="grey" checked><span class="label label-grey">grey</span>
              </label>
              <label class="radio inline">
                <input type="radio" name="label" id="label" value="info"><span class="label label-info">blue</span>
              </label>
              <label class="radio inline">
                <input type="radio" name="label" id="label" value="success"><span class="label label-success">green</span>                
              </label>              
            </div>
            <div class="controls">
              <label class="radio inline">
                <input type="radio" name="label" id="label" value="warning"><span class="label label-warning">orange</span>
              </label>
              <label class="radio inline">
                <input type="radio" name="label" id="label" value="important"><span class="label label-important">red</span>
              </label>
              <label class="radio inline">
                <input type="radio" name="label" id="label" value="inverse"><span class="label label-inverse">black</span>
              </label>
            </div>
          </div>         

          <div class="control-group">
            <label class="control-label" for="icons">Flags Icon</label>
            <div class="controls">
              <input type="text" id="icons" name="icons" placeholder="poin.png">
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
          <li><i class="icon-signal"></i> Syarat Level : 90</li>
          <li><i class="icon-pencil"></i> edit</li>
          <li><i class="icon-remove"></i> delete</li>
        </ul>
      </div>

    </div>


  </div>
</section>
<?php
@include (x_PATH."/footer.php");
?> 