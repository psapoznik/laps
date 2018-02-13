<?php

namespace Rarst\Laps\Manager;

/**
 * Reorders plugin load to put Laps first and time this core boot stage.
 */
class Load_Order_Manager {

	public function __construct() {

		add_action( 'pre_update_option_active_plugins', [ $this, 'pre_update_option_active_plugins' ] );
		add_action( 'pre_update_site_option_active_sitewide_plugins', [ $this, 'pre_update_option_active_plugins' ] );
	}

	/**
	 * Reorder active plugins so Laps is first and starts timing load early.
	 *
	 * @param array $plugins
	 *
	 * @return array
	 */
	public function pre_update_option_active_plugins( $plugins ) {

		$plugin = plugin_basename( dirname( dirname( __DIR__ ) ) . '/laps.php' );
		$key    = array_search( $plugin, $plugins, true );

		if ( false !== $key && $key > 0 ) {

			unset( $plugins[ $key ] );
			array_unshift( $plugins, $plugin );
			$plugins = array_values( $plugins );
		}

		return $plugins;
	}
}