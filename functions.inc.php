<?php
	function html_list_apis($return = false) {
		$html = '<ul>';
		foreach($GLOBALS['apis'] as $api => $config) {
			$html .= '<li><a href="' . link_url($api) . '">' . $config['title']['de'] . ' (<i>' . $config['title']['en'] . '</i>)</li>';
		}
		$html .= '</ul>';
		if ($return) return $html; else echo $html;
	}

	function link_url($api, $function = '', $output = 'html') {
		$url = "index.php?api=$api&output=$output";
		if ($function) $url .= "&function=$function";
		return $url;
	}

	function current_api() {
		if (!isset($_GET['api'])) {
			return null;
		}
		if (isset($GLOBALS['apis'][$_GET['api']])) {
			return $_GET['api'];
		}
		return null;
	}

	function current_function() {
		if (!current_api()) {
			return null;
		}
		if (!isset($_GET['function'])) {
			return null;
		}
		if (in_array($_GET['function'], $GLOBALS['apis'][current_api()]['functions'])) {
			return $_GET['function'];
		}
		return null;
	}

	function display_api($api, $format, $function) {
		$funcname = preg_replace('/[^a-z0-9]/i', '_', $api) . '_' . $format;
		$dir = getcwd();
		chdir (dirname(__FILE__) . '/' . $api);
		call_user_func($funcname, $function);
		chdir ($dir);
	}

	function hed($s) {
		return html_entity_decode($s, ENT_QUOTES, 'UTF-8');
	}
