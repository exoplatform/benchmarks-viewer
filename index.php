<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <title>Benchmarks Viewer</title>
  <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap-combined.min.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/font-awesome/2.0/css/font-awesome.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/bootswatch/2.1.0/spacelab/bootstrap.min.css" rel="stylesheet">
	<!-- DataTables CSS -->
	<link href="//ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.3/css/jquery.dataTables.css" rel="stylesheet" type="text/css">
  <link href="./main.less" type="text/css" rel="stylesheet/less" media="all"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.3.0/less-1.3.0.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<!-- DataTables -->
	<script src="//ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.3/jquery.dataTables.min.js" type="text/javascript" charset="utf8"></script>	
  <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	  /* Various customizations especially for bootstrap compatibility */
	  /* Probably to move somewhere else */

	  /* Default class modification */
	  $.extend($.fn.dataTableExt.oStdClasses, {
	    "sWrapper":"dataTables_wrapper form-inline"
	  });

	  // Customization for all tables
	  $.extend($.fn.dataTable.defaults, {
	    // Customization for bootstrap
	    "sPaginationType":"bootstrap",
	    "bSortClasses":false
	  });

	  /* API method to get paging information */
	  $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
	    return {
	      "iStart":oSettings._iDisplayStart,
	      "iEnd":oSettings.fnDisplayEnd(),
	      "iLength":oSettings._iDisplayLength,
	      "iTotal":oSettings.fnRecordsTotal(),
	      "iFilteredTotal":oSettings.fnRecordsDisplay(),
	      "iPage":Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
	      "iTotalPages":Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
	    };
	  }

	  /* Bootstrap style pagination control */
	  $.extend($.fn.dataTableExt.oPagination, {
	    "bootstrap":{
	      "fnInit":function (oSettings, nPaging, fnDraw) {
	        var oLang = oSettings.oLanguage.oPaginate;
	        var fnClickHandler = function (e) {
	          e.preventDefault();
	          if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
	            fnDraw(oSettings);
	          }
	        };

	        $(nPaging).addClass('pagination').append(
	            '<ul>' +
	                '<li class="prev disabled"><a href="#">&larr; ' + oLang.sPrevious + '</a></li>' +
	                '<li class="next disabled"><a href="#">' + oLang.sNext + ' &rarr; </a></li>' +
	                '</ul>'
	        );
	        var els = $('a', nPaging);
	        $(els[0]).bind('click.DT', { action:"previous" }, fnClickHandler);
	        $(els[1]).bind('click.DT', { action:"next" }, fnClickHandler);
	      },

	      "fnUpdate":function (oSettings, fnDraw) {
	        var iListLength = 5;
	        var oPaging = oSettings.oInstance.fnPagingInfo();
	        var an = oSettings.aanFeatures.p;
	        var i, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength / 2);

	        if (oPaging.iTotalPages < iListLength) {
	          iStart = 1;
	          iEnd = oPaging.iTotalPages;
	        }
	        else if (oPaging.iPage <= iHalf) {
	          iStart = 1;
	          iEnd = iListLength;
	        } else if (oPaging.iPage >= (oPaging.iTotalPages - iHalf)) {
	          iStart = oPaging.iTotalPages - iListLength + 1;
	          iEnd = oPaging.iTotalPages;
	        } else {
	          iStart = oPaging.iPage - iHalf + 1;
	          iEnd = iStart + iListLength - 1;
	        }

	        for (i = 0, iLen = an.length; i < iLen; i++) {
	          // Remove the middle elements
	          $('li:gt(0)', an[i]).filter(':not(:last)').remove();

	          // Add the new list items and their event handlers
	          for (j = iStart; j <= iEnd; j++) {
	            sClass = (j == oPaging.iPage + 1) ? 'class="active"' : '';
	            $('<li ' + sClass + '><a href="#">' + j + '</a></li>')
	                .insertBefore($('li:last', an[i])[0])
	                .bind('click', function (e) {
	                        e.preventDefault();
	                        oSettings._iDisplayStart = (parseInt($('a', this).text(), 10) - 1) * oPaging.iLength;
	                        fnDraw(oSettings);
	                      });
	          }

	          // Add / remove disabled classes from the static elements
	          if (oPaging.iPage === 0) {
	            $('li:first', an[i]).addClass('disabled');
	          } else {
	            $('li:first', an[i]).removeClass('disabled');
	          }

	          if (oPaging.iPage === oPaging.iTotalPages - 1 || oPaging.iTotalPages === 0) {
	            $('li:last', an[i]).addClass('disabled');
	          } else {
	            $('li:last', an[i]).removeClass('disabled');
	          }
	        }
	      }
	    }
	  });
	  /* Table initialisation */
	  $(document).ready(function () {
	    /* Activate tooltips */
	    $('body').tooltip({ selector:'[rel=tooltip]'});
	    /* Create table */
	    binariesTable = $('#benchmarks').dataTable(
	        {
	          // Customization for bootstrap
	          "oLanguage":{
	            "sLengthMenu":"_MENU_ " + i18n('datatables.sLengthMenu')
	          },
	          // Default sort
	          "aaSorting":[
	            [ 0, "desc" ]
	          ],
	          // Boostrap customization
	          "sDom":"<'row'<'span${ ((_width == null) ? '6' : _width)}'l><'span${ ((_width == null) ? '6' : _width)}'f>r>t<'row'<'span${ ((_width == null) ? '6' : _width)}'i><'span${ ((_width == null) ? '6' : _width)}'p>>"
	        });
	  });
	</script>	
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
        <ul class="breadcrumb">
          <li>
            <a href="#">Benchmarks</a>
          </li>
        </ul>
        <div class="row">
					<div class="span12">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="benchmarks">
		          <thead>
		            <tr>
		              <th>Date</th>
		              <th>Time</th>
		              <th>Lab</th>
		              <th>Product</th>
		              <th>AppServer</th>
		              <th>Scenario</th>
		              <th>VUs</th>
		              <th>Nodes</th>
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
		              if (($file != ".") && ($file != "..") && (filetype($directory."/".$file) == "dir")) {
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
								$matches = array();								
								if(preg_match("/([^\-]*)\-([^\-]*)\-([^\-]*)\-([^\-]*)\-([^\-]*)\-(.*.jmx)\-([^\-]*)\-([^\-]*)/", $benchmark, $matches))
								{
  		            ?>
	  	            <tr>
		                <td><?=$matches[1]?></td>
                    <td><?=$matches[2]?></td>
                    <td><?=$matches[3]?></td>
                    <td><?=$matches[4]?></td>
                    <td><?=$matches[5]?></td>
                    <td><?=$matches[6]?></td>
                    <td><?=$matches[7]?></td>
                    <td><?=$matches[8]?></td>																				
		              </tr>
		              <?php 
								}
								else
								{
			            ?>
			            <tr>
			              <td colspan="8"><?=$benchmark?> cannot be parsed</td>
			            </tr>
			            <?php 									
								}
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