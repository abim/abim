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
?>
<nav class="navbar navbar-static-top navbar-inverse navbar-embossed" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-6">
        <span class="sr-only">Toggle navigation</span>
      </button>
      <a class="navbar-brand" href="<?php echo x_BASE;?>/">3E Labs</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse-6">
      <ul class="nav navbar-nav">
        <li class="ds"><a href="<?php echo x_BASE;?>/">Dashboard</a></li>
        <li class="dropdown sites">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sites <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li class="blog"><a href="#<?php echo x_BASE;?>/blog/">Blogs</a></li>
            <li class="code"><a href="<?php echo x_BASE;?>/code/">Code Site</a></li>
            <li class="portfolio"><a href="#<?php echo x_BASE;?>/portfolio/">Portfolios Site</a></li>
            <li class="cv"><a href="#<?php echo x_BASE;?>/cv/">CV Site</a></li>
          </ul>
        </li>
        <li class"projects"><a href="#">Projects</a></li>
        <li class="dropdown exp">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Experiments <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li class="anime"><a href="<?php echo x_BASE;?>/exp/anime/">Anime</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown settings">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="visible-md visible-sm visible-xs"><span class="fui-gear"></span><b class="caret"></b></span><span class="visible-lg"><span class="fui-gear"></span> Settings <b class="caret"></b></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo x_BASE;?>/m/users">Users</a></li>
          </ul>
        </li>
        <li class="dropdown users">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Abim <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">Profile</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo x_XELF;?>?keluar"><span class="fui-power"></span> Logout</a></li>
          </ul>
        </li>        
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">