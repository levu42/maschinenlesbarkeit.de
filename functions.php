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

	function path_to_api() {
		return './' . current_api();
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

	function set_api_cache($api, $function, $parameter, $data) {
		$dir = getcwd();
		chdir(dirname(__FILE__).'/cache/');
		$filename = md5($api.'/'.$function.'/'.serialize($parameter));
		file_put_contents($filename, serialize($data));
		chdir($dir);
	}
	function get_api_cache($api, $function, $parameter) {
		$dir = getcwd();
		chdir(dirname(__FILE__).'/cache/');
		$filename = md5($api.'/'.$function.'/'.serialize($parameter));
		$data = unserialize(file_get_contents($filename));
		chdir($dir);
		return $data;
	}
	function age_of_api_cache($api, $function, $parameter) {
		$dir = getcwd();
		chdir(dirname(__FILE__).'/cache/');
		$filename = md5($api.'/'.$function.'/'.serialize($parameter));
		$time = filemtime($filename);
		if ($time !== false) {
			$time = time() - $time;
		}
		chdir($dir);
		return $time;
	}

	function current_api_has_field($name) {
		return api_has_field(current_api(), $name);
	}

	function current_api_field($name) {
		return api_field(current_api(), $name);
	}

	function api_has_field($api, $name) {
		return isset($GLOBALS['apis'][$api][$name]);
	}

	function api_field($api, $name) {
		return $GLOBALS['apis'][$api][$name];
	}

