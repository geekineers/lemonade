<?php
function ci_app_path($path = null) {
	return APPPATH.$path;
}

function ci_dd() {
	$data = func_get_args();
	foreach ($data as $item) {
		echo '<pre style="border: 1px solid #666; border-radius: 1px; padding: 10px;">';
			var_dump($item);
		echo '</pre>';
	}
}
