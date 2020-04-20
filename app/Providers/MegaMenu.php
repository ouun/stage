<?php

namespace Stage\Providers;

use Roots\Acorn\ServiceProvider;
use WP_Term;

class MegaMenu extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		add_action( 'wp_nav_menu_item_custom_fields', [$this, 'stage_mega_menu_custom_fields'], 10, 2 );
		add_action( 'wp_update_nav_menu_item', [$this, 'stage_mega_menu_nav_update'], 10, 2 );
		add_filter( 'wp_get_nav_menu_items',  [$this, 'stage_mega_menu_items'] , 10 , 3);
	}

	/**
	 * Add custom fields to menu item
	 *
	 * This will allow us to play nicely with any other plugin that is adding the same hook
	 *
	 * @param  int $item_id
	 * @params obj $item - the menu item
	 * @params array $args
	 */
	public function stage_mega_menu_custom_fields( $item_id, $item ) {
		wp_nonce_field( 'stage_mega_menu_meta_nonce', '_stage_mega_menu_meta_nonce_name' );
		$stage_mega_menu_meta = get_post_meta( $item_id, '_stage_mega_menu_meta', true );
		$checked = $stage_mega_menu_meta === 'mega-menu' ? 'checked' : '';
		?>

		<input type="hidden" name="custom-menu-meta-nonce" value="<?php echo wp_create_nonce( 'custom-menu-meta-name' ); ?>" />

		<p class="field-mega_menu description description-wide">
			<label for="custom-menu-meta-for-<?php echo $item_id; ?>" class="widefat edit-menu-item-description">
				<input type="checkbox" name="stage_mega_menu_meta[<?php echo $item_id; ?>]" id="custom-menu-meta-for-<?php echo $item_id; ?>" value="<?php echo esc_attr( $stage_mega_menu_meta ); ?>" <?php echo $checked; ?>>
				<?php _e('Activate Mega Menu', 'stage'); ?>
			</label>
		</p>

		<?php
	}

	/**
	 * Save the menu item meta
	 *
	 * @param int $menu_id
	 * @param int $menu_item_db_id
	 *
	 * @return int
	 */
	public function stage_mega_menu_nav_update( $menu_id, $menu_item_db_id ) {
		// Verify this came from our screen and with proper authorization.
		if ( ! isset( $_POST['_stage_mega_menu_meta_nonce_name'] ) || ! wp_verify_nonce( $_POST['_stage_mega_menu_meta_nonce_name'], 'stage_mega_menu_meta_nonce' ) ) {
			return $menu_id;
		}

		if ( isset( $_POST['stage_mega_menu_meta'][$menu_item_db_id] ) ) {
			update_post_meta( $menu_item_db_id, '_stage_mega_menu_meta', 'mega-menu' );
		} else {
			delete_post_meta( $menu_item_db_id, '_stage_mega_menu_meta' );
		}

		return $menu_id;
	}

	/**
	 * Add 'mega-menu' class to menu items
	 *
	 * @param array $items
	 * @param WP_Term $menu
	 * @param array $args
	 *
	 * @return array
	 */
	public static function stage_mega_menu_items( $items, $menu, $args ) {

		if( get_nav_menu_locations()['primary_navigation'] !== $menu->term_id) {
			return $items;
		}

		foreach ($items as $item) {
			if ( is_object( $item ) && isset( $item->ID ) ) {
				$stage_mega_menu_meta = get_post_meta( $item->ID, '_stage_mega_menu_meta', true );

				if ( $stage_mega_menu_meta === 'mega-menu' ) {
					$item->classes[] = 'mega-menu';
				}
			}
		}

		return $items;
	}
}
