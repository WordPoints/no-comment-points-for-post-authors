<?php

/**
 * Main file of the extension.
 *
 * ---------------------------------------------------------------------------------|
 * Copyright 2018  J.D. Grimes  (email : jdg@codesymphony.co)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or later, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * ---------------------------------------------------------------------------------|
 *
 * @package WordPoints_NCPFPA
 * @version 1.0.0
 * @author  J.D. Grimes <jdg@codesymphony.co>
 * @license GPLv2+
 */

WordPoints_Modules::register(
	'
		Extension Name: No Comment Points For Post Authors
		Author:         J.D. Grimes
		Author URI:     https://wordpoints.org/
		Extension URI:  https://wordpoints.org/modules/no-comment-points-for-post-authors/
		Version:        1.0.0
		License:        GPLv2+
		Description:    Prevents post authors from being awarded points when they comment on their own posts.
		Text Domain:    wordpoints-no-comment-points-for-post-authors
		Domain Path:    /languages
		Server:         wordpoints.org
		ID:             1414
		Namespace:      NCPFPA
	'
	, __FILE__
);

WordPoints_Class_Autoloader::register_dir( dirname( __FILE__ ) . '/classes/' );

/**
 * Register hook extension when the extension registry is initialized.
 *
 * @since 1.0.0
 *
 * @WordPress\action wordpoints_init_app_registry-hooks-extensions
 *
 * @param WordPoints_Class_Registry_Persistent $extensions The extension registry.
 */
function wordpoints_ncpfpa_hook_extensions_init( $extensions ) {

	$extensions->register( 'ncpfpa', 'WordPoints_NCPFPA_Hook_Extension' );
}
add_action(
	'wordpoints_init_app_registry-hooks-extensions'
	, 'wordpoints_ncpfpa_hook_extensions_init'
);

// EOF
