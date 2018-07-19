<?php
/*
* Adding a user id column to the users overview in the WordPress admin
*/
function rd_user_id_column( $columns ) {
	$columns['user_id'] = 'ID';

	return $columns;
}

add_filter( 'manage_users_columns', 'rd_user_id_column' );

/*
* Column content (the user id)
*/
function rd_user_id_column_content( $value, $column_name, $user_id ) {
	if ( 'user_id' == $column_name ) {
		return $user_id;
	}

	return $value;
}

add_action( 'manage_users_custom_column', 'rd_user_id_column_content', 10, 3 );

/*
* Column style
*/
function rd_user_id_column_style() {
	echo '<style>.column-user_id{width: 5%}</style>';
}

add_action( 'admin_head-users.php', 'rd_user_id_column_style' );


/*
* This is where you can will decide what to show on which
*/

function hide_menu() {
	global $current_user;
	$user_id = get_current_user_id();

	// Put your own user ID below here. You can find it in the user overview in the WordPress admin
	if ( $user_id != '1' ) {

		// Some items can only be 'removed' with css, for example with display none. This doesn't mean they can't access it though.
		echo '<style>
	  
	  </style>';

		// To remove the whole Appearance admin menu you would use;
		//remove_menu_page( 'themes.php' );

		// To remove the theme editor and theme options submenus from
		// the Appearance admin menu, as well as the main 'Themes'
		// submenu you would use

		remove_menu_page( 'index.php' );
		remove_submenu_page( 'index.php', 'update-core.php' );
		remove_submenu_page( 'index.php', 'customize.php' );
		remove_submenu_page( 'themes.php', 'themes.php' );
		remove_submenu_page( 'themes.php', 'theme-editor.php' );
		remove_submenu_page( 'themes.php', 'theme_options' );

		//remove_menu_page( 'users.php' );
		//remove_submenu_page( 'users.php', 'user-new.php' );
		//remove_submenu_page( 'users.php', 'profile.php' );

		//remove_menu_page( 'upload.php' );
		//remove_submenu_page( 'upload.php', 'media-new.php' );
		//remove_submenu_page( 'upload.php', 'upload.php?page=wp-smush-bulk' );

		// Remove ACF from admin
		remove_menu_page( 'edit.php?post_type=acf-field-group' );

		// Remove Polylang from admin
		remove_menu_page( 'edit.php' );
		remove_submenu_page( 'edit.php', 'post-new.php' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );


		// Remove Page menu Items
		//remove_menu_page( 'edit.php?post_type=page' );
		remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' );


		// Remove Comments Menu
		remove_menu_page( 'edit-comments.php' );

		//// Remove LMS Menu
		remove_menu_page( 'admin.php?page=parent' );

		remove_menu_page( 'tools.php' );                  //Tools
		remove_menu_page( 'options-general.php' );        //Settings

		remove_menu_page( 'plugins.php' );        //Plugins

		remove_menu_page( 'edit.php?post_type=product' );


		// Hide customize sub page of appearance menu item
		$customize_url_arr   = array();
		$customize_url_arr[] = 'customize.php'; // 3.x
		$customize_url       = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
		$customize_url_arr[] = $customize_url; // 4.0 & 4.1
		if ( current_theme_supports( 'custom-header' ) && current_user_can( 'customize' ) ) {
			$customize_url_arr[] = add_query_arg( 'autofocus[control]', 'header_image', $customize_url ); // 4.1
			$customize_url_arr[] = 'custom-header'; // 4.0
		}
		if ( current_theme_supports( 'custom-background' ) && current_user_can( 'customize' ) ) {
			$customize_url_arr[] = add_query_arg( 'autofocus[control]', 'background_image', $customize_url ); // 4.1
			$customize_url_arr[] = 'custom-background'; // 4.0
		}
		foreach ( $customize_url_arr as $customize_url ) {
			remove_submenu_page( 'themes.php', $customize_url );
		}
	}
}


add_action( 'admin_head', 'hide_menu' );