<!DOCTYPE html>
<?php
$benchmarksDirectory=$_SERVER['BENCHMARKS_DIR'];
$benchmarksURL=$_SERVER['BENCHMARKS_URL'];
$benchmark = $_GET['benchmark'];
function getImagesList ($directory) {
  // create an array to hold the list
  $results = array();
  // create a handler for the directory
  $handler = opendir($directory);
  // open directory and walk through the filenames
  while ($file = readdir($handler)) {
    // if file isn't this directory or its parent, add it to the results
    if (($file != ".") && ($file != "..") && (filetype($directory."/".$file) == "file") && preg_match("/.*\.png/", $file)) {
      $results[] = $file;
    }
  }
  // tidy up: close the handler
  closedir($handler);
  // done!
  return $results;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Benchmarks Viewer</title>
<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap-combined.min.css" type="text/css" rel="stylesheet" media="all">
<link href="//netdna.bootstrapcdn.com/bootswatch/2.1.0/spacelab/bootstrap.min.css" type="text/css" rel="stylesheet" media="all">
<link href="./main.css" type="text/css" rel="stylesheet" media="all" />
</head>
<body data-spy="scroll" data-target=".left-sidenav">
  <!-- navbar ================================================== -->
  <div id="navbar" class="navbar navbar-fixed-top" data-dropdown="dropdown">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#">Benchmarks Viewer</a>
      </div>
    </div>
  </div>
  <!-- /navbar -->
  <!-- Main ================================================== -->
  <div id="wrap">
    <div id="main">
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span12">
            <ul class="breadcrumb">
              <li><a href="./index.php">Benchmarks</a> <span class="divider">/</span></li>
              <li class="active"><?=$benchmark?></li>
            </ul>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span3 left-sidebar">
            <ul class="nav nav-list left-sidenav">
              <?php
              $images = getImagesList($benchmarksDirectory."/".$benchmark."/jmeter-results");
              foreach( $images as $image) {
                ?>
              <li><a href="#<?=$image?>"><i class="icon-chevron-right"></i> <?=$image?> </a></li>
              <?php
              }
              ?>
            </ul>
          </div>
          <div class="span9">
            <?php
            $images = getImagesList($benchmarksDirectory."/".$benchmark."/jmeter-results");
            foreach( $images as $image) {
              ?>
            <section id="<?=$image?>">
              <div class="page-header">
                <h1>
                  <?=$image?>
                </h1>
              </div>
              <img src="https://qaf-reports.exoplatform.org/archives/gateinuxp/<?=$benchmark?>/jmeter-results/<?=$image?>" alt="<?=$image?>" />
            </section>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
      <!-- /container -->
    </div>
  </div>
  <!-- Footer ================================================== -->
  <div id="footer">Copyright ¬© 2000-2012. All rights Reserved, eXo Platform SAS.</div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/js/bootstrap.min.js" type="text/javascript"></script>
  <script type="text/javascript">

!function ($) {

  $(function(){

    var $window = $(window)

    // side bar
    $('.left-sidenav').affix({
      offset: { top: 0 , bottom: 0 }
    })
  })
}(window.jQuery)
  </script>
</body>
</html>
