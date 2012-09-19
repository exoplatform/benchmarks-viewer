<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>Benchmarks Viewer</title>
  <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap-combined.min.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/font-awesome/2.0/css/font-awesome.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/bootswatch/2.1.0/spacelab/bootstrap.min.css" rel="stylesheet">
  <link href="./main.less" type="text/css" rel="stylesheet/less" media="all"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.3.0/less-1.3.0.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/js/bootstrap.min.js"></script>
</head>
<body>
<!-- navbar
================================================== -->
<div id="navbar" class="navbar navbar-fixed-top" data-dropdown="dropdown">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="#">Benchmarks Viewer</a>
    </div>
  </div>
</div>
<!-- /navbar -->

<!-- Main
================================================== -->
<div id="wrap">
  <div id="main">

    <div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Benchmarks <small>- List</small></h1>
        </div>
        <div class="row">
					<div class="span12">
		        <table>
		          <thead>
		            <tr>
		              <th>Benchmark</th>
		            </tr>
		          </thead>
		          <tbody>
		            <?php
		          function getDirectoryList ($directory) {
		            // create an array to hold directory list
		            $results = array();
		            // create a handler for the directory
		            $handler = opendir($directory);
		            // open directory and walk through the filenames
		            while ($file = readdir($handler)) {
		              // if file isn't this directory or its parent, add it to the results
		              if (($file != ".") && ($file != "..") && (filetype($file) == "dir")) {
		                $results[] = $file;
		              }
		            }
		            // tidy up: close the handler
		            closedir($handler);
		            // done!
		            return $results;
		          }
		          //print each file name
		          $benchmarks = getDirectoryList($_SERVER['BENCHMARKS_DIR']);
		          sort($benchmarks);
							$benchmarks = array_reverse($benchmarks);
		          foreach( $benchmarks as $benchmark) {
		            ?>
		            <tr>
		              <td><?=$benchmark?></td>
		            </tr>
		            <?php 
		          } 
		          ?>
		          </tbody>
		        </table>						
					</div>
				</div>				
      </div>
    </div>
    <!-- /container -->

  </div>
</div>

<!-- Footer
================================================== -->
<div id="footer">Copyright © 2000-2012. All rights Reserved, eXo Platform SAS.</div></body>
</html>