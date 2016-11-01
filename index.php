<?php 
/*
The MIT License (MIT)

Copyright (c) 2014 - 2016 M ABD AZIZ ALFIAN (https://about.me/azizalfian)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

//============================================================

// Start Configuration
//Title website
$sitetitle = 'PHP File Index';

//Version PHP File Index
$version = '1.0';

//Author
$author = 'M ABD AZIZ ALFIAN';

//Change this to true if website using ssl
$ssl = false;

//Path folder always use forwardslash at the end, leave empty if You put on root domain
$folder = 'file/'; 

//Put Your namefile to be ignored showing in list
$ignored = array('.', '..', '.svn', '.htaccess','index.php','assets');

//Limit show items
$limitrow = 10;

//Show all error
error_reporting(E_ALL);

//Set display error, better to switch off for production
ini_set('display_errors','Off');
//End Configuration

//============================================================

//Start Library
$n = 1; 
$website = (($ssl)?'https://':'http://').$_SERVER['HTTP_HOST'].'/'.$folder;

function scan_dir($dir) {
    global $ignored,$limitrow;
    $i=1;
    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
        if ($i++ == $limitrow) break;
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

function filesize_format($size, $sizes = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'))
{
    if ($size == 0) return('n/a');
    return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $sizes[$i]);
}
//End Library
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/img/favicon.ico">

    <title><?=$sitetitle?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?=$sitetitle?></a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Contact</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="./">Default <span class="sr-only">(current)</span></a></li>
              <li><a href="#">Static top</a></li>
              <li><a href="#">Fixed top</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1><?=$sitetitle?></h1>
        <p><?=$sitetitle?>, is php script that useful to generate list latest modified file index to download for Your visitor.<br>CSS already using bootstrap 3.3.7, support minimum PHP 4.0.3, 5 and 7.<br>Just put in the folder on Your server, it doesn't need any database connections.</p>
        <p>
          <a class="btn btn-lg btn-success" href="https://github.com/aalfiann/PHPFileIndex" role="button">Download <?=$sitetitle?> ver.<?=$version?></a>
        </p>
      </div>

      <div class="panel panel-info">
        <!-- Default panel contents -->
        <div class="panel-heading"><b>Latest Modified Files</b></div>

            <!-- Table -->
            <table class="table">
                <thead> 
                    <tr> 
                        <th class="col-xs-1">#</th> 
                        <th>Filename</th> 
                        <th>Filesize</th>
                        <th>Filetype</th>
                        <th>Latest modified</th>
                    </tr> 
                </thead> 
                <tbody> 
                    <!-- Start Generate Files -->
                    <?php
                        foreach (scan_dir('.') as $name => $value) 
                        {
                            echo '
                            <tr> 
                                <th class="col-xs-1" scope=row>'.$n++.'</th> 
                                <td><a href="'.$website.$value.'" alt="'.$value.'" title="Download">'.$value.'</a></td> 
                                <td>'.filesize_format(filesize($value)).'</td>
                                <td>'.pathinfo($value, PATHINFO_EXTENSION).'</td>
                                <td>'.date ("d-m-Y H:i", filemtime($value)).'</td> 
                            </tr>';
                        }
                    ?>
                    <!-- End Generate Files -->
                </tbody>
            </table>
        </div>
      </div>

    </div> <!-- /container -->

    <footer class="footer">
      <div class="container">
      <hr>
        <p class="text-muted"><?=$sitetitle?> ver.<?=$version?> &copy; <?=date('Y')?> - <a href="https://about.me/azizalfian" target="_blank"><?=$author?></a>.</p>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
