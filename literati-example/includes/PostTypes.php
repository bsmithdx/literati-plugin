<?php

namespace Literati\Example;

class PostTypes
{
  /**
   * Init
   */
  public static function init()
  {
      add_action( 'init', [__CLASS__, 'register_promotions'] );
	  add_action( 'load-post.php', [__CLASS__, 'promotions_meta_boxes_setup'] );
	  add_action( 'load-post-new.php', [__CLASS__, 'promotions_meta_boxes_setup'] );
  }

  /**
   * Register the Promotions Custom Post Type
   */
  public static function register_promotions(): void
  {
      register_post_type( 'literati_promotion',
          [
                  'labels' =>
                      [
                              'name' => _x('Promotions', 'Post type general name', 'textdomain'),
                              'singular_name' => _x('Promotion', 'Post type singular name', 'textdomain'),
                              'menu_name'             => _x( 'Promotions', 'Admin Menu text', 'textdomain' ),
                              'name_admin_bar'        => _x( 'Promotion', 'Add New on Toolbar', 'textdomain' ),
                              'add_new'               => __( 'Add New', 'textdomain' ),
                              'add_new_item'          => __( 'Add New Promotion', 'textdomain' ),
                              'new_item'              => __( 'New Promotion', 'textdomain' ),
                              'edit_item'             => __( 'Edit Promotion', 'textdomain' ),
                  ],
                  'public' => true,
            'has_archive' => true,
            ]
    );
  }

    public static function promotions_meta_boxes_setup(): void {
      add_action( 'add_meta_boxes', [__CLASS__, 'promotions_add_meta_boxes'] );
      add_action( 'save_post', [__CLASS__, 'save_promotion_data'], 10, 2 );
    }

    public static function promotions_add_meta_boxes(): void {
        add_meta_box(
            'literati-promotion-data',
            esc_html__( 'Promotion Data' ),
            [__CLASS__, 'promotion_data_meta_box_html'],
            'literati_promotion',
            'normal',
            'default',
        );
    }

    public static function promotion_data_meta_box_html( $post ): void {
        ?>

        <?php wp_nonce_field( basename( __FILE__ ), 'literati_promotion_data_nonce' ); ?>

        <p>
            <label for="literati-promotion-header"><?php _e( "Add a header for your promotion"); ?></label>
            <br />
            <input class="widefat" type="text" name="literati-promotion-header" id="literati-promotion-header" value="<?php echo esc_attr( get_post_meta( $post->ID, 'literati_promotion_header', true ) ); ?>" size="30" />
            <label for="literati-promotion-header"><?php _e( "Add text for your promotion"); ?></label>
            <br />
            <textarea class="widefat" type="text" name="literati-promotion-text" id="literati-promotion-text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'literati_promotion_text', true ) ); ?>" size="30" ></textarea>
            <label for="literati-promotion-header"><?php _e( "Add button text for your promotion"); ?></label>
            <br />
            <input class="widefat" type="text" name="literati-promotion-button" id="literati-promotion-button" value="<?php echo esc_attr( get_post_meta( $post->ID, 'literati_promotion_button', true ) ); ?>" size="30" />
        </p>
        <?php
    }

	public static function save_promotion_data( $post_id, $post ) {
        //verify nonce
        if ( !isset( $_POST['literati_promotion_data_nonce'] ) || !wp_verify_nonce( $_POST['literati_promotion_data_nonce'], basename( __FILE__ ) ) ) {
            return $post_id;
        }

        /* Get the post type object. \*/
        $post_type = get_post_type_object( $post->post_type );

        /* Check if the current user has permission to edit the post. \*/
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
	        return $post_id;
        }
        //save header data
        self::handle_promotion_data('literati_promotion_header', $_POST['literati-promotion-header'], $post_id);
	}
    public static function handle_promotion_data($meta_key, $new_value, $post_id) {
        //sanitize new value
        $sanitized_value =( $new_value );

        //get existing metadata value
        $meta_value = get_post_meta( $post_id, $meta_key, true );

        //handle adding new value
        if ( $sanitized_value && '' == $meta_value ) {
            add_post_meta( $post_id, $meta_key, $sanitized_value, true );
        }

        //handle updating value
        elseif ( $sanitized_value && $sanitized_value != $meta_value ) {
		    update_post_meta( $post_id, $meta_key, $sanitized_value );
	    }

	    //handle deleting value
        elseif ( '' == $sanitized_value && $meta_value ) {
		    delete_post_meta( $post_id, $meta_key, $meta_value );
	    }
    }
}