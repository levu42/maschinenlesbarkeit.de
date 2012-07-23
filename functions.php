<?php

	$is_in_api_function = false;	
	$filename = dirname(__FILE__) . '/dict.' . get_user_lang() . '.json';
	$dict = array();
	if (file_exists($filename)) {
		$dict = json_decode(file_get_contents($filename), true);
	}

	function html_list_apis($return = false) {
		$html = '<ul>';
		foreach($GLOBALS['apis'] as $api => $config) {
			if (isset($config['title'][get_user_lang()])) {
				$title = $config['title'][get_user_lang()];
			} else {
				$title = $config['title']['en'];
			}
			$html .= '<li><a href="' . link_url($api) . '">' . htmlspecialchars($title) . '</li>';
		}
		$html .= '</ul>';
		if ($return) return $html; else echo $html;
	}

	function link_url($api, $function = '', $output = 'html') {
		$url = "index.php?api=$api&output=$output";
		if ($function) $url .= "&function=$function";
		return $url;
	}

	function path_to_api($api = null) {
		if ($api === null) $api = current_api();
		return './' . $api;
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
		is_in_api_function(true);
		call_user_func($funcname, $function);
		is_in_api_function(false);
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

	function tr($default, $id = null) {
		$dict = get_current_dict();
		if (is_null($id)) {
			if (isset($dict[$default])) {
				return $dict[$default];
			} else {
				return $default;
			}
		} else {
			if (isset($dict[$id])) {
				return $dict[$id];
			} else {
				return $default;
			}
		}
	}

	function is_in_api_function($new = null) {
		global $is_in_api_function;
		if ($new !== null) {
			$is_in_api_function = ($new === true);
		}
		return ($is_in_api_function === true);
	}

	function get_current_dict() {
		if (is_in_api_function()) {
			return get_current_api_dict();
		}
		return $GLOBALS['dict'];
	}

	function get_current_api_dict() {
		return get_api_dict(current_api());
	}

	function get_api_dict($api) {
		if (!isset($GLOBALS['apis'][$api]['dict'])) {
			$dir = getcwd();
			chdir(dirname(__FILE__));
			$GLOBALS['apis'][$api]['dict'] = array();
			if (api_has_field($api, 'dicts')) {
				$f = api_field($api, 'dicts');
				if (isset($f[get_user_lang()])) {
					$GLOBALS['apis'][$api]['dict'] = json_decode(file_get_contents(path_to_api() . '/' . $f[get_user_lang()]), true);
				}
			}
			chdir($dir);
		}
		return $GLOBALS['apis'][$api]['dict'];
	}

	function get_user_lang() {
		static $lang;
		if (!isset($lang)) {
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			if (isset($_GET['force-ui-lang'])) {
				$lang = substr($_GET['force-ui-lang'], 0, 2);
			}
		}
		return $lang;
	}

	function list_available_langs() {
		$langs = array('en');
		$dir = getcwd();
		chdir(dirname(__FILE__));
		foreach(glob('./dict.*.json') as $filename) {
			if (preg_match('/dict\.(.+)\.json/i', $filename, $pat) !== false) {
				$langs[] = $pat[1];
			}
		}
		return $langs;
	}

