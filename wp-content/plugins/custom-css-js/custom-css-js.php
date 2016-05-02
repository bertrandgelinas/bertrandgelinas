<?php
/**
 * Plugin Name: Simple Custom CSS and JS 
 * Plugin URI: https://wordpress.org/plugins/custom-css-js/
 * Description: Easily add Custom CSS or JS to your website with an awesome editor.
 * Version: 2.1 
 * Author: Diana Burduja
 * Author URI: http://www.silkypress.com/
 * License: GPL2
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'CustomCSSandJS' ) ) :
/**
 * Main CustomCSSandJS Class
 *
 * @class CustomCSSandJS 
 */
final class CustomCSSandJS {
    public $version = '2.1';
    public $plugins_url = '';
    public $plugin_dir_path = '';
    public $plugin_file = __FILE__;
    public $search_tree = false;
    public $upload_dir = '';
    public $upload_url = '';
    protected static $_instance = null; 


    /**
     * Main CustomCSSandJS Instance
     *
     * Ensures only one instance of CustomCSSandJS is loaded or can be loaded
     *
     * @static
     * @return CustomCSSandJS - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
      * Cloning is forbidden.
      */
    public function __clone() {
         _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0' );
    }

    /**
     * Unserializing instances of this class is forbidden.
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0' );
    }

    /**
     * CustomCSSandJS Constructor
     * @access public
     */
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
        $this->plugins_url = plugins_url( '/', __FILE__ );
        $this->plugin_dir_path = plugin_dir_path( __FILE__ );
        $wp_upload_dir = wp_upload_dir();
        $this->upload_dir = $wp_upload_dir['basedir'] . '/custom-css-js';
        $this->upload_url = $wp_upload_dir['baseurl'] . '/custom-css-js';
         if ( is_admin() ) {
            include_once( 'includes/admin-screens.php' );
         }

        $this->search_tree = get_option( 'custom-css-js-tree' );

        if ( ! $this->search_tree || count( $this->search_tree ) == 0 ) {
            return false;
        }

        $this->print_code_actions();

    }

    /**
     * Add the appropriate wp actions
     */
    function print_code_actions() {
        foreach( $this->search_tree as $_key => $_value ) {
            $action = '';
            switch( $_key ) {
                case 'admin-css-header-external' :
                case 'admin-js-header-external' :
                case 'admin-css-header-internal' :
                case 'admin-js-header-internal' :
                    $action = 'admin_head';
                    break;

                case 'admin-css-footer-external' :
                case 'admin-js-footer-external' :
                case 'admin-css-footer-internal' :
                case 'admin-js-footer-internal' :
                    $action = 'admin_footer';
                    break;

                case 'frontend-css-header-external' :
                case 'frontend-css-footer-external' :
                case 'frontend-css-header-internal' :
                case 'frontend-js-header-internal' :
                case 'frontend-js-header-external' :
                    $action = 'wp_head';
                    break;
                case 'frontend-css-footer-internal' :
                case 'frontend-js-footer-internal' :
                case 'frontend-js-footer-external' :
                    $action = 'wp_footer';
                    break;
            }

            if ( $action == '' ) {
                continue;
            }

            add_action( $action, array( $this, 'print_' . $_key ) );
        }
    }

    /**
     * Print the custom code.
     */
    public function __call( $function, $args ) {

        if ( strstr( $function, 'print_' ) == false ) {
            return false;
        }

        $function = str_replace( 'print_', '', $function );

        if ( ! isset( $this->search_tree[ $function ] ) ) {
            return false;
        } 

        $args = $this->search_tree[ $function ];

        if ( ! is_array( $args ) || count( $args ) == 0 ) {
            return false;
        }

        // print the `internal` code
        if ( strstr( $function, 'internal' ) ) {

            $before = '<!-- start Simple Custom CSS and JS -->' . PHP_EOL; 
            $after = '<!-- end Simple Custom CSS and JS -->' . PHP_EOL;
            if ( strstr( $function, 'css' ) ) {
                $before .= '<style type="text/css">' . PHP_EOL;
                $after = '</style>' . PHP_EOL . $after;
            }
            if ( strstr( $function, 'js' ) ) {
                $before .= '<script type="text/javascript">' . PHP_EOL;
                $after = '</script>' . PHP_EOL . $after;
            }


            foreach( $args as $_post_id ) {
                if ( strstr( $_post_id, 'css' ) || strstr( $_post_id, 'js' ) ) {
                    @include_once( $this->upload_dir . '/' . $_post_id );
                } else {
                    $post = get_post( $_post_id );
                    echo $before . $post->post_content . $after;
                }
            }            
        }

        // link the `external` code
        if ( strstr( $function, 'external' ) ) {
            $in_footer = false;
            if ( strstr( $function, 'footer' ) ) {
                $in_footer = true;
            }
            
            if ( strstr( $function, 'js' ) ) {
                foreach( $args as $_filename ) {
                    echo PHP_EOL . "<script type='text/javascript' src='".$this->upload_url . '/' . $_filename."'></script>" . PHP_EOL;
                }
            }

            if ( strstr( $function, 'css' ) ) {
                foreach( $args as $_filename ) {
                    $shortfilename = preg_replace( '@\.css\?v=.*$@', '', $_filename );
                    echo PHP_EOL . "<link rel='stylesheet' id='".$shortfilename ."-css'  href='".$this->upload_url . '/' . $_filename ."' type='text/css' media='all' />" . PHP_EOL;
                }
            }
        }
    }

    /**
     * Create the custom-css-js post type
     */
    public function register_post_type() {
        $labels = array(
            'name'               => _x( 'Custom Code', 'post type general name'),
            'singular_name'      => _x( 'Custom Code', 'post type singular name'),
            'menu_name'          => _x( 'Custom CSS & JS', 'admin menu'),
            'name_admin_bar'     => _x( 'Custom Code', 'add new on admin bar'),
            'add_new'            => _x( 'Add Custom Code', 'add new'),
            'add_new_item'       => __( 'Add Custom Code'),
            'new_item'           => __( 'New Custom Code'),
            'edit_item'          => __( 'Edit Custom Code'),
            'view_item'          => __( 'View Custom Code'),
            'all_items'          => __( 'All Custom Code'),
            'search_items'       => __( 'Search Custom Code'),
            'parent_item_colon'  => __( 'Parent Custom Code:'),
            'not_found'          => __( 'No Custom Code found.'),
            'not_found_in_trash' => __( 'No Custom Code found in Trash.')
        );

        $args = array(
            'labels'             => $labels,
                    'description'        => __( 'Custom CSS and JS code' ),
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_position'     => 100,
            'menu_icon'         => 'dashicons-plus-alt',
            'query_var'          => false,
            'rewrite'            => array( 'slug' => 'custom-css-js' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'exclude_from_search'   => true,
            'menu_position'      => null,
            'can_export'        => false,
            'supports'           => array( 'title' )
        );

        register_post_type( 'custom-css-js', $args );
    }


}

endif; 

/**
 * Returns the main instance of CustomCSSandJS 
 *
 * @return CustomCSSandJS 
 */
function CustomCSSandJS() {
    return CustomCSSandJS::instance();
}

CustomCSSandJS();


/**
 * Delete options, posts and files on uninstall
 */
function custom_css_js_uninstall() {

    delete_option( 'custom-css-js-tree' );

    $wp_upload_dir = wp_upload_dir();
    $upload_dir = $wp_upload_dir['basedir'] . '/custom-css-js';
    @array_map( 'unlink', $upload_dir . '/*' ); 
    @unlink( $upload_dir ); 

    $posts = query_posts( 'post_type=custom-css-js' );

    if ( ! is_array( $posts ) || count( $posts ) == 0 ) {
        return false;
    }

    foreach ( $posts as $_post ) {
        wp_delete_post( $_post, true );
    }

}
register_uninstall_hook( __FILE__, 'custom_css_js_uninstall' );


/**
 * Create the upload directory on install
*/
function custom_css_js_install() {
    $wp_upload_dir = wp_upload_dir();
    $upload_dir = $wp_upload_dir['basedir'] . '/custom-css-js'; 
    wp_mkdir_p( $upload_dir );

    // Top level blank index.php
    if ( ! file_exists( $upload_dir . '/index.php' ) && wp_is_writable( $upload_dir ) ) {
        $content = '<?php' . PHP_EOL . '// Silence is golden.'; 
        @file_put_contents( $upload_dir . '/index.php', $content );
    }
}
register_activation_hook( __FILE__, 'custom_css_js_install' );

/**
 * Plugin action link to Settings page
*/
function custom_css_js_plugin_action_links( $links ) {

    $settings_link = '<a href="edit.php?post_type=custom-css-js">' .
        esc_html( __('Settings' ) ) . '</a>';

    return array_merge( array( $settings_link), $links );
    
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'custom_css_js_plugin_action_links' );
