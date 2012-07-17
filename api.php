<?

	error_reporting(E_ALL | E_STRICT);	

	if (!file_exists('config.json')) {
		file_put_contents('config.json', '{}');
	}
	
	$config = json_decode(file_get_contents('config.json'), true);

	$GLOBALS['apis'] = array();

	if (isset($config['enabled-apis']) && is_array($config['enabled-apis'])) {
		foreach($config['enabled-apis'] as $api) {
			$GLOBALS['apis'][$api] = json_decode(file_get_contents('./' . $api . '/api.json'), true);
			$GLOBALS['apis'][$api]['init'] = require_once('./' . $api . '/api.php'); 
		}
	}


	require_once('functions.inc.php');
