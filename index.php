<?php
	require_once('api.php');
	if (isset($_GET['output'])) {
		if (in_array($_GET['output'], array('xml', 'json'))) {
			display_api(current_api(), $_GET['output'], current_function());
			die;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Maschinenlesbarkeit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="OpenData project by levu">
    <meta name="author" content="levu <levu@levu.org> http://levu.org">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style>
      #padding-top {
				width: 100%;
				height: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
		<link rel="stylesheet" href="app.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
		<div class="visible-desktop" id="padding-top"></div>
<?php
	if (current_api()) {
		if (current_api_has_field('github-url')) {
			?><a class="visible-desktop" href="<?php echo current_api_field('github-url') ?>"><img style="position: fixed; top: 40px; right: 0; border: 0; z-index: 1000;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a><?php
		}
	} else {
		?><a class="visible-desktop" href="https://github.com/levu42/maschinenlesbarkeit.de"><img style="position: fixed; top: 40px; right: 0; border: 0; z-index: 1000;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a><?php
	}
?>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href=".">Maschinenlesbarkeit</a>
          <div class="nav-collapse">
            <ul class="nav">
						<?php if (current_api()) { ?>
							<li><a href="index.php">Home</a></li>
              <li><a href="about.html">About</a></li>
							<li class="active"><a href="#"><?php echo $GLOBALS['apis'][current_api()]['title']['de']; ?></a></li>					
						<? } else { ?>
							<li class="active"><a href="#">Home</a></li>
              <li><a href="about.html">About</a></li>
						<? } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
			<div class="notice">This site is work in progress, please report any bugs you encounter to levu@levu.org or @levudev on twitter, thanks!</div>
			<div>&nbsp;</div>
			<?php if (current_api()) {
				display_api(current_api(), 'html', current_function());
			} else { ?>
					<h1>APIs</h1>
					<?php html_list_apis(); ?> 
			<?php } ?>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
