<!DOCTYPE html>
<?php
$benchmarksDirectory=$_SERVER['BENCHMARKS_DIR'];
$benchmarksURL=$_SERVER['BENCHMARKS_URL'];
$benchmark = $_GET['benchmark'];
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
          <div class="span3 left-sidebar">
            <ul class="nav nav-list left-sidenav" data-spy="affix" data-offset-top="0" id="left-sidenav">
              <li><a href="#ResponseTimesOverTime"><i class="icon-chevron-right"></i> Response Times Over Time </a></li>
              <li><a href="#ResponseTimesVsThreads"><i class="icon-chevron-right"></i> Response Times Vs Threads </a></li>
              <li><a href="#ThreadsStateOverTime"><i class="icon-chevron-right"></i> Threads State Over Time </a></li>
              <li><a href="#ThroughputOverTime"><i class="icon-chevron-right"></i> Throughput Over Time </a></li>
              <li><a href="#ThroughputVsThreads"><i class="icon-chevron-right"></i> Throughput Vs Threads </a></li>
              <li><a href="#TransactionsPerSecond"><i class="icon-chevron-right"></i> Transactions Per Second </a></li>
            </ul>
          </div>
          <div class="span9">
            <section id="ResponseTimesOverTime">
              <div class="page-header">
                <h2>Response Times Over Time</h2>
              </div>
              <div class="row-fluid">
                <div class="span6">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesOverTime_Aggregated.png" alt="bench-ResponseTimesOverTime_Aggregated.png" />
                </div>
                <div class="span6">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesOverTime_Details.png" alt="bench-ResponseTimesOverTime_Details.png" />
                </div>
              </div>
            </section>
            <section id="ResponseTimesVsThreads">
              <div class="page-header">
                <h2>Response Times Vs Threads</h2>
              </div>
              <div class="row-fluid">
                <div class="span6">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesVsThreads_Aggregated.png" alt="bench-ResponseTimesVsThreads_Aggregated.png" />
                </div>
                <div class="span6">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesVsThreads_Details.png" alt="bench-ResponseTimesVsThreads_Details.png" />
                </div>
              </div>
            </section>
            <section id="ThreadsStateOverTime">
              <div class="page-header">
                <h2>Threads State Over Time</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThreadsStateOverTime_Aggregated.png" alt="bench-ThreadsStateOverTime_Aggregated.png" />
                </div>
              </div>
            </section>
            <section id="ThroughputOverTime">
              <div class="page-header">
                <h2>Throughput Over Time</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThroughputOverTime_Details.png" alt="bench-ThroughputOverTime_Details.png" />
                </div>
              </div>
            </section>
            <section id="ThroughputVsThreads">
              <div class="page-header">
                <h2>Throughput Vs Threads</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThroughputVsThreads_Details.png" alt="bench-ThroughputVsThreads_Details.png" />
                </div>
              </div>
            </section>
            <section id="TransactionsPerSecond">
              <div class="page-header">
                <h2>Transactions Per Second</h2>
              </div>
              <div class="row-fluid">
                <div class="span6">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-TransactionsPerSecond_Aggregated.png" alt="bench-TransactionsPerSecond_Aggregated.png" />
                </div>
                <div class="span6">
                  <img src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-TransactionsPerSecond_Details.png" alt="bench-TransactionsPerSecond_Details.png" />
                </div>
              </div>
            </section>
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
</body>
</html>
