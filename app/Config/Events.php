<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', function () {
	if (ENVIRONMENT !== 'testing') {
		if (ini_get('zlib.output_compression')) {
			throw FrameworkException::forEnabledZlibOutputCompression();
		}

		while (ob_get_level() > 0) {
			ob_end_flush();
		}

		ob_start(function ($buffer) {
			return $buffer;
		});
	}

	/*
	 * --------------------------------------------------------------------
	 * Debug Toolbar Listeners.
	 * --------------------------------------------------------------------
	 * If you delete, they will no longer be collected.
	 */
	if (ENVIRONMENT !== 'production') {
		Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
		Services::toolbar()->respond();
	}
});

Events::on('post_controller_constructor', function () {
	if (ENVIRONMENT !== 'development') {
		while (ob_get_level() > 0) {
			ob_end_flush();
		}
		ob_start(function ($buffer) {
			$search = array(
				'/\n/',      // replace end of line by a <del>space</del> nothing , if you want space make it down ' ' instead of ''
				'/\>[^\S ]+/s',    // strip whitespaces after tags, except space
				'/[^\S ]+\</s',    // strip whitespaces before tags, except space
				'/(\s)+/s',    // shorten multiple whitespace sequences
				'/<!--(.|\s)*?-->/' //remove HTML comments
			);

			$replace = array(
				'',
				'>',
				'<',
				'\\1',
				''
			);

			$watermark = "| |__   __ _ _ __ (_) | __  _ __ | |
| '_ \ / _` | '_ \| | |/ / | '_ \| |
| |_) | (_| | | | | |   < _| |_) | |
|_.__/ \__,_|_| |_|_|_|\_(_) .__/|_|
|_|      ";
	
			$buffer = preg_replace($search, $replace, $buffer);

			$buffer = "<!--\n$watermark\n-->\n$buffer\n<!--\n$watermark\n-->";

			return $buffer;
		});
	}
});
