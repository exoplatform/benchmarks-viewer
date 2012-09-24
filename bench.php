<!DOCTYPE html>
<?php
$benchmarksDirectory=$_SERVER['BENCHMARKS_DIR'];
$benchmarksURL=$_SERVER['BENCHMARKS_URL'];
$benchmark = $_GET['benchmark'];
/*
 No cache!!
*/
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// always modified
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
/*
 End of No cache
*/
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
        <a class="brand" href="./index.php">Benchmarks Viewer</a>
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
              <li><a href="#Info"><i class="icon-chevron-right"></i> Informations </a></li>
              <li><a href="#bench.csv"><i class="icon-chevron-right"></i> bench.csv </a></li>
              <li><a href="#bench-AggregateReport_Aggregated.csv"><i class="icon-chevron-right"></i> bench-AggregateReport_Aggregated.csv </a></li>
              <li><a href="#ResponseTimesOverTime"><i class="icon-chevron-right"></i> Response Times Over Time </a></li>
              <li><a href="#ResponseTimesVsThreads"><i class="icon-chevron-right"></i> Response Times Vs Threads </a></li>
              <li><a href="#ThreadsStateOverTime"><i class="icon-chevron-right"></i> Threads State Over Time </a></li>
              <li><a href="#ThroughputOverTime"><i class="icon-chevron-right"></i> Throughput Over Time </a></li>
              <li><a href="#ThroughputVsThreads"><i class="icon-chevron-right"></i> Throughput Vs Threads </a></li>
              <li><a href="#TransactionsPerSecond"><i class="icon-chevron-right"></i> Transactions Per Second </a></li>
            </ul>
          </div>
          <div class="span9">
            <section id="Info">
              <div class="page-header">
                <h2>Informations</h2>
              </div>
              <div class="row-fluid">
                <div class="span6">
                  <?php
                  function displayDate ($date_as_string) {
              	$date = DateTime::createFromFormat('Ymd-His', $date_as_string);
              	return $date->format('Y/M/d - H:i:s');
              }
              $matches = array();
              if(preg_match("/([^\-]*)\-([^\-]*)\-([^\-]*)\-([^\-]*)\-([^\-]*)\-(.*.jmx)\-([^\-]*)\-([^\-]*)/", $benchmark, $matches))
              {
              	?>
                  <div class="row">
                    <div class="span3">
                      <strong>End Date (UTC)</strong>
                    </div>
                    <div class="span6">
                      <?=displayDate($matches[1]."-".$matches[2])?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="span3">
                      <strong>Lab</strong>
                    </div>
                    <div class="span6">
                      <?=$matches[3]?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="span3">
                      <strong>Product</strong>
                    </div>
                    <div class="span6">
                      <?=$matches[4]?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="span3">
                      <strong>AppServer</strong>
                    </div>
                    <div class="span6">
                      <?=$matches[5]?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="span3">
                      <strong>Scenario</strong>
                    </div>
                    <div class="span6">
                      <?=$matches[6]?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="span3">
                      <strong>VUs</strong>
                    </div>
                    <div class="span6">
                      <?=$matches[7]?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="span3">
                      <strong>Nodes</strong>
                    </div>
                    <div class="span6">
                      <?=$matches[8]?>
                    </div>
                  </div>
                  <?php }?>
                  <div class="row">
                    <div class="span3">
                      <strong>JTL</strong>
                    </div>
                    <div class="span6">
                      <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench.jtl.gz"><i class="icon-chevron-right"></i> Download</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="span3">
                      <strong>Logs</strong>
                    </div>
                    <div class="span6">
                      <a href="<?=$benchmarksURL."/".$benchmark?>/logs/"><i class="icon-chevron-right"></i> Browse</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="span3">
                      <strong>Configuration</strong>
                    </div>
                    <div class="span6">
                      <a href="<?=$benchmarksURL."/".$benchmark?>/conf/"><i class="icon-chevron-right"></i> Browse</a>
                    </div>
                  </div>
                </div>
                <div class="span6">
                  <?php
                  function viewinfo($filename) {
                	$fp = fopen($filename,"r");
                	$file = fread($fp,65535);
                	$replaced = eregi_replace(":", "</strong></div><div class='span3'>", $file);
                	$replaced2 = eregi_replace("\n", "</div></div><div class='row'><div class='span6'><strong>", $replaced);
                	$replaced3 = eregi_replace("\r", "</div></div><div class='row'><div class='span6'><strong>", $replaced2);
                	fclose($fp);
                	return substr("<div class='row'><div class='span6'><strong>".$replaced3,0,-44);
                }
                ?>
                  <?=viewinfo($benchmarksDirectory."/".$benchmark."/jmeter-results/bench.jtl.info.txt")?>
                  <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench.jtl.info.txt"><i class="icon-chevron-right"></i> Download</a>
                </div>
              </div>
            </section>
            <?php
            function viewsemicoloncsv($filename) {
              	$fp = fopen($filename,"r");
              	$file = ";" . fread($fp,65535);
              	$replaced = eregi_replace(";", "</td><td>", $file);
              	$replaced2 = eregi_replace("\n", "</td></tr><tr><td>", $replaced);
              	$replaced3 = eregi_replace("\r", "</td></tr><tr><td>", $replaced2);
              	fclose($fp);
              	return "<tr>".substr($replaced3,5,-8);
              }
              function viewcommacsv($filename) {
              	$fp = fopen($filename,"r");
              	$file = "," . fread($fp,65535);
              	$replaced = eregi_replace(",", "</td><td>", $file);
              	$replaced2 = eregi_replace("\n", "</td></tr><tr><td>", $replaced);
              	$replaced3 = eregi_replace("\r", "</td></tr><tr><td>", $replaced2);
              	fclose($fp);
              	return "<tr>".substr($replaced3,5,-8);
              }
              ?>
            <section id="bench.csv">
              <div class="page-header">
                <h2>bench.csv</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <table class="table table-striped table-bordered table-hover">
                    <?=viewsemicoloncsv($benchmarksDirectory."/".$benchmark."/jmeter-results/bench.jtl.csv")?>
                  </table>
                  <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench.jtl.csv"><i class="icon-chevron-right"></i> Download</a>
                </div>
              </div>
            </section>
            <section id="bench-AggregateReport_Aggregated.csv">
              <div class="page-header">
                <h2>bench-AggregateReport_Aggregated.csv</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <table class="table table-striped table-bordered table-hover">
                    <?=viewcommacsv($benchmarksDirectory."/".$benchmark."/jmeter-results/bench-AggregateReport_Aggregated.csv")?>
                  </table>
                  <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-AggregateReport_Aggregated.csv"><i class="icon-chevron-right"></i> Download</a>
                </div>
              </div>
            </section>
            <section id="ResponseTimesOverTime">
              <div class="page-header">
                <h2>Response Times Over Time</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <ul class="thumbnails">
                    <li class="span6">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesOverTime_Aggregated.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesOverTime_Aggregated.png" alt="Response Times Over Time Aggregated"> </a>
                        <h3>Response Times Over Time Aggregated</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-ResponseTimesOverTime_Aggregated.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesOverTime_Aggregated.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                    <li class="span6">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesOverTime_Details.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesOverTime_Details.png" alt="Response Times Over Time Details"> </a>
                        <h3>Response Times Over Time Details</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-ResponseTimesOverTime_Details.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesOverTime_Details.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </section>
            <section id="ResponseTimesVsThreads">
              <div class="page-header">
                <h2>Response Times Vs Threads</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <ul class="thumbnails">
                    <li class="span6">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesVsThreads_Aggregated.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesVsThreads_Aggregated.png" alt="Response Times Vs Threads Aggregated"> </a>
                        <h3>Response Times Vs Threads Aggregated</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-ResponseTimesVsThreads_Aggregated.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesVsThreads_Aggregated.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                    <li class="span6">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesVsThreads_Details.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesVsThreads_Details.png" alt="Response Times Vs Threads Details"> </a>
                        <h3>Response Times Vs Threads Details</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-ResponseTimesVsThreads_Details.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ResponseTimesVsThreads_Details.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </section>
            <section id="ThreadsStateOverTime">
              <div class="page-header">
                <h2>Threads State Over Time</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <ul class="thumbnails">
                    <li class="span12">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThreadsStateOverTime_Aggregated.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThreadsStateOverTime_Aggregated.png" alt="Threads State Over Time Aggregated"> </a>
                        <h3>Threads State Over Time Aggregated</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-ThreadsStateOverTime_Aggregated.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThreadsStateOverTime_Aggregated.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </section>
            <section id="ThroughputOverTime">
              <div class="page-header">
                <h2>Throughput Over Time</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <ul class="thumbnails">
                    <li class="span12">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThroughputOverTime_Details.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThroughputOverTime_Details.png" alt="Throughput Over Time Details"> </a>
                        <h3>Throughput Over Time Details</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-ThroughputOverTime_Details.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThroughputOverTime_Details.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </section>
            <section id="ThroughputVsThreads">
              <div class="page-header">
                <h2>Throughput Vs Threads</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <ul class="thumbnails">
                    <li class="span12">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThroughputVsThreads_Details.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThroughputVsThreads_Details.png" alt="Throughput Vs Threads Details"> </a>
                        <h3>Throughput Vs Threads Details</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-ThroughputVsThreads_Details.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-ThroughputVsThreads_Details.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </section>
            <section id="TransactionsPerSecond">
              <div class="page-header">
                <h2>Transactions Per Second</h2>
              </div>
              <div class="row-fluid">
                <div class="span12">
                  <ul class="thumbnails">
                    <li class="span6">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-TransactionsPerSecond_Aggregated.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-TransactionsPerSecond_Aggregated.png" alt="Transactions Per Second Aggregated"> </a>
                        <h3>Transactions Per Second Aggregated</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-TransactionsPerSecond_Aggregated.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-TransactionsPerSecond_Aggregated.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                    <li class="span6">
                      <div class="thumbnail">
                        <a href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-TransactionsPerSecond_Details.png"><img
                          src="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-TransactionsPerSecond_Details.png" alt="Transactions Per Second Details"> </a>
                        <h3>Transactions Per Second Details</h3>
                        <p>
                          CSV : <a href="csv.php?benchmark=<?=$benchmark?>&file=bench-TransactionsPerSecond_Details.csv"><i class="icon-chevron-right"></i> View</a><a
                            href="<?=$benchmarksURL."/".$benchmark?>/jmeter-results/bench-TransactionsPerSecond_Details.csv"><i class="icon-chevron-right"></i> Download</a>
                        </p>
                      </div>
                    </li>
                  </ul>
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
  <div id="footer">Copyright © 2000-2012. All rights Reserved, eXo Platform SAS.</div>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
