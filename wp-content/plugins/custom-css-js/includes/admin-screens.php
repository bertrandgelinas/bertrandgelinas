<?php
/**
 * Custom CSS and JS
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * CustomCSSandJS_Admin 
 */
class CustomCSSandJS_Admin {

    /**
     * An instance of the CustomCSSandJS class
     */
    private $main = '';

    /**
     * Default options for a new page
     */
    private $default_options = array(
        'type'  => 'header',
        'linking'   => 'internal',
        'side'      => 'frontend',
        'priority'  => 5,
        'language'  => 'css',
    );

    /**
     * Array with the options for a specific custom-css-js post
     */
    private $options = array();

    /**
     * Constructor
     */
    public function __construct() {
        $actions = array(
            'admin_menu'            => 'admin_menu',
            'admin_enqueue_scripts' => 'admin_enqueue_scripts',
            'current_screen'        => 'current_screen',
            'admin_notices'         => 'add_new_buttons',
            'edit_form_after_title' => 'codemirror_editor',
            'add_meta_boxes'        => 'add_meta_boxes',
            'save_post'             => 'options_save_meta_box_data',
            'trashed_post'          => 'trash_post',
            'untrashed_post'        => 'trash_post',
            'wp_loaded'             => 'compatibility_shortcoder',
            'wp_ajax_ccj_active_code' => 'wp_ajax_ccj_active_code',

        );
        foreach( $actions as $_key => $_value ) {
            add_action( $_key, array( $this, $_value ) );
        }

        add_filter( 'manage_custom-css-js_posts_columns', array( $this, 'manage_custom_posts_columns' ) );
        add_action( 'manage_custom-css-js_posts_custom_column', array( $this, 'manage_posts_columns' ), 10, 2 );

        $this->main = CustomCSSandJS();
    }

    /**
     * Add submenu pages
     */
    function admin_menu() {
        $menu_slug = 'edit.php?post_type=custom-css-js';
        $submenu_slug = 'post-new.php?post_type=custom-css-js';

        $title = __('Add Custom CSS');
        add_submenu_page( $menu_slug, $title, $title, 'manage_options', $submenu_slug .'&language=css');

        $title = __('Add Custom JS');
        add_submenu_page( $menu_slug, $title, $title, 'manage_options', $submenu_slug . '&language=js');

        remove_submenu_page( $menu_slug, $submenu_slug);
    }


    /**
     * Enqueue the scripts and styles
     */
    public function admin_enqueue_scripts( $hook ) {
        if ( $hook != 'post-new.php' && $hook != 'post.php' ) 
            return false;

        $screen = get_current_screen();

        if ( $screen->post_type != 'custom-css-js' )
            return false;

        $cm = plugins_url( '/', $this->main->plugin_file ). 'assets/codemirror/';
        $version = $this->main->version;

        wp_enqueue_script( 'codemirror', $cm . 'codemirror-compressed.js', array('jquery'), $version, false );


        wp_enqueue_style( 'codemirror', $cm . 'codemirror-compressed.css' , array(), $version );
        //wp_enqueue_style( 'codemirror_theme', $cm . 'theme/3024-night.css' , array(), $version );


    }

    public function add_meta_boxes() {
        add_meta_box('custom-code-options', __('Options'), array( $this, 'custom_code_options_meta_box_callback'), 'custom-css-js', 'side', 'low');
        
        remove_meta_box( 'slugdiv', 'custom-css-js', 'normal' );
    }



    /**
     * Get options for a specific custom-css-js post
     */
    private function get_options( $post_id ) {
        if ( isset( $this->options[ $post_id ] ) ) {
            return $this->options[ $post_id ];
        }

        $options = get_post_meta( $post_id );
        if ( empty( $options ) || ! isset ( $options['options'][0] ) ) {
            $this->options[ $post_id ] = $this->default_options;
            return $this->default_options;
        }

        $options = unserialize( $options['options'][0] );
        $this->options[ $post_id ] = $options;
        return $options;
    }


    /**
     * Reformat the `edit` or the `post` screens
     */
    function current_screen( $current_screen ) {

        if ( $current_screen->post_type != 'custom-css-js' ) {
            return false;
        }

        wp_deregister_script( 'autosave' );

        if ( $current_screen->base == 'edit' ) { 
            add_action( 'admin_head', array( $this, 'current_screen_edit' ) );
        }

        if ( $current_screen->base == 'post' ) {
            add_action( 'admin_head', array( $this, 'current_screen_post' ) ); 
        }
    }



    /**
     * Add the buttons in the `edit` screen
     */
    function add_new_buttons() {
        $current_screen = get_current_screen();

        if ( $current_screen->base != 'edit' || $current_screen->post_type != 'custom-css-js' ) {
            return false;
        }
?>
    <style type="text/css">
        .updated.buttons {
            border: none; 
            background-color: transparent; 
            box-shadow: none; 
            padding: 0; 
            margin: 15px 0 15px !important; 
        }
        .custom-btn {
            background: #0c73b8;
            border-radius: 2px;
            color: #ffffff;
            font-size: 17px;
            padding: 10px 20px 10px 20px !important;
            text-decoration: none;
        }
        .custom-btn:hover {
            color: #fff;
            background: #2eaadd;
            text-decoration: none;
        }
        .custom-js-btn { background: #e4a228; }
        .custom-js-btn:hover { background: #eebf31; }
        .custom-php-btn { background: #e45126; }
        .custom-php-btn:hover { background: #f6652c; }
    </style>
    <div class="updated buttons">
        <a href="post-new.php?post_type=custom-css-js&language=css" class="custom-btn custom-css-btn">Add CSS code</a>
        <a href="post-new.php?post_type=custom-css-js&language=js" class="custom-btn custom-js-btn">Add JS code</a>
        <!-- a href="post-new.php?post_type=custom-css-js&language=php" class="custom-btn custom-php-btn">Add PHP code</a -->
    </div>
<?php
    }


    /**
     * Reformat the `edit` screen
     */
    function current_screen_edit() {
        ?>
        <style type="text/css">
            h1 .page-title-action { display: none; }
            .inline.hide-if-no-js{ display: none; }
            .view-switch { display: none; }
            #modified { width: 140px; }
            #active.manage-column { width: 30px; }
            #type.manage-column { width: 50px; }
            .language { 
                background: #0c73b8;
                border-radius: 2px;
                color: #ffffff;
                font-size: 12px;
                padding: 5px 10px !important;
                text-decoration: none;
            }
            .language-js { background: #e4a228; }
            .language-php { background: #e45126; }
            .type.column-type, .check-column, .column-active { vertical-align: middle !important; }
            .ccj-dashicons:before { color: grey; }
            .column-active .dashicons { font-size: 17px; }
            .column-active a, .column-active a:active, .column-active a:hover, .column-active a:focus { display: block; outline: 0; border: 0; text-decoration: none; }

        </style>
        <?php 
    }



    /**
     * Add new columns in the `edit` screen
     */
    function manage_custom_posts_columns( $columns ) {
        return array(
            'cb'    => '<input type="checkbox" />',
            'active' => '<span class="ccj-dashicons dashicons dashicons-star-empty" title="Active"></span>',
            'type'  => 'Type',
            'title' => 'Title',
            'author'  => 'Author',
            'date'  => 'Date',
            'modified'  => 'Modified',
        );
    }


    /**
     * Fill the data for the new added columns in the `edit` screen
     */
    function manage_posts_columns( $column, $post_id ) {

        if ( $column == 'type' ) {
            $options = $this->get_options( $post_id );
            echo '<span class="language language-'.$options['language'].'">' . $options['language'] . '</span>';
        }

        if ( $column == 'modified' ) {
            $m_time = get_the_modified_time( 'G', true, get_post( $post_id ) );
            $time_diff = time() - $m_time;

            if ( $time_diff > 0 && $time_diff < DAY_IN_SECONDS ) {
                $h_time = sprintf( __( '%s ago' ), human_time_diff( $m_time ) );
            } else {
                $h_time = mysql2date( __( 'Y/m/d' ), $m_time );
            }

            echo $h_time; 
        }

        if ( $column == 'active' ) {
            $url = wp_nonce_url( admin_url( 'admin-ajax.php?action=ccj_active_code&code_id=' . $post_id ), 'ccj-active-code' );
            echo '<a href="' . esc_url( $url ) . '" title="'. __( 'Toggle active' ) . '">';
            if ( $this->is_active( $post_id ) ) {
                echo '<span class="dashicons dashicons-star-filled" title="The code is active. Click to inactivate it"></span>';
            } else {
                echo '<span class="dashicons dashicons-star-empty" title="The code is inactive. Click to activate it"></span>';
            }
            echo '</a>';

        }
    }

    /**
     * Activate/deactivate a code
     *
     * @return void
     */
    function wp_ajax_ccj_active_code() {
        if ( ! isset( $_GET['code_id'] ) ) die();

		if ( check_admin_referer( 'ccj-active-code' ) ) {
			$code_id = absint( $_GET['code_id'] );

			if ( 'custom-css-js' === get_post_type( $code_id ) ) {
				update_post_meta( $code_id, '_active', get_post_meta( $code_id, '_active', true ) === 'yes' ? 'no' : 'yes' );

                $this->build_search_tree();
			}
		}

		wp_safe_redirect( wp_get_referer() ? remove_query_arg( array( 'trashed', 'untrashed', 'deleted', 'ids' ), wp_get_referer() ) : admin_url( 'edit.php?post_type=custom-css-js' ) );
		die();
    }

    /**
     * Check if a code is active
     *
     * @return bool
     */
    function is_active( $post_id ) {
        return get_post_meta( $post_id, '_active', true ) !== 'no';
    }



    /**
     * Reformat the `post` screen
     */
    function current_screen_post() {
    
        if ( isset( $_GET['post'] ) ) {
            $action = 'Edit';
            $language = $this->get_options( $_GET['post'] );
            $language = $language['language'];
        } else {
            $action = 'Add';
            $language = isset( $_GET['language'] ) ? $_GET['language'] : 'css';
        }

        $title = $action . ' ' . strtoupper( $language ) . ' code';

        ?>
        <script type="text/javascript">
             /* <![CDATA[ */
            jQuery(window).ready(function($){
                $("#wpbody-content h1").text('<?php echo $title; ?>');
                $("#message.updated.notice").html('<p>Code updated</p>');
            });
            /* ]]> */
        </script>
        <style type="text/css">
            .update.notice a { display: none; }
        </style>
        <?php
    }



    /**
     * Add the codemirror editor in the `post` screen
     */
    public function codemirror_editor( $post ) {
        $current_screen = get_current_screen();

        if ( $current_screen->post_type != 'custom-css-js' ) {
            return false;
        }

        if ( empty( $post->title ) && empty( $post->post_content ) ) {
            $new_post = true;
            $language = isset( $_GET['language'] ) ? $_GET['language'] : 'css';
        } else {
            $new_post = false;
            if ( ! isset( $_GET['post'] ) ) $_GET['post'] = $post->id;
            $language = $this->get_options( $_GET['post'] );
            $language = $language['language'];
        }

        switch ( $language ) {
            case 'js' :
                if ( $new_post ) {
                    $post->post_content = '/* Your code goes here */ ' . PHP_EOL . PHP_EOL;
                }
                $code_mirror_mode = 'text/javascript';
                $code_mirror_before = '<script type="text/javascript">';
                $code_mirror_after = '</script>';
                break;
            case 'php' :
                if ( $new_post ) {
                    $post->post_content = '/* The following will be executed as if it were written in functions.php. */' . PHP_EOL . PHP_EOL;
                }
                $code_mirror_mode = 'text/php';
                $code_mirror_before = '<?php';
                $code_mirror_after = '?>';

                break;
            default :
                if ( $new_post ) {
                    $post->post_content .= '.example {' . PHP_EOL;
                    $post->post_content .= "\t" . 'color: #eee;' . PHP_EOL;
                    $post->post_content .= '}' . PHP_EOL . PHP_EOL;
                }
                $code_mirror_mode = 'text/css';
                $code_mirror_before = '<style type="text/css">';
                $code_mirror_after = '</style>';

        } 

            ?>
            <style type="text/css">
            .page-title-action { display: none; }
            #minor-publishing { display: none; }
            #post-body #normal-sortables { min-height: 0px; }
            .CodeMirror { 
                height: 384px; 
                margin-top: 0px; 
                border: 1px solid #ddd; 
                border-bottom: none; 
                border-top: none;
            }
            .CodeMirror pre { padding-left: 7px; line-height: 1.25; }

            .CodeMirrorBefore {
                margin-top: 15px;
                border: 1px solid #ddd;
                border-bottom: none;
                background-color: #f7f7f7;
            }
            .CodeMirrorBefore div {
                color: #8F8F8F;
                margin-left: 29px;
                border-left: 1px solid #ddd;
                padding: 3px 8px;
                background-color: #fff;
            }

            .CodeMirrorAfter {
                border: 1px solid #ddd;
                border-top: none;
                background-color: #f7f7f7;
            }
            .CodeMirrorAfter div {
                color: #8F8F8F;
                margin-left: 29px;
                border-left: 1px solid #ddd;
                padding: 3px 8px;
                background-color: #fff;
            }
            .cm-s-default .cm-atom { color: #549d18; }
            .cm-s-default .cm-property { color: #b62625; }
            .cm-s-default .cm-qualifier, .cm-s-default .cm-tag { color: #4731E4; }
            </style>
              <form style="position: relative; margin-top: .5em;">

                <div class="CodeMirrorBefore"><div><?php echo htmlentities( $code_mirror_before );?></div></div>
                <textarea id="custom-code" name="content"><?php echo $post->post_content; ?></textarea>
                <div class="CodeMirrorAfter"><div><?php echo htmlentities( $code_mirror_after );?></div></div>
              </form>
              <script>
                window.onload = function() {
                    var editor = CodeMirror.fromTextArea(document.getElementById("custom-code"), {
                        lineNumbers: true,
                        mode: "<?php echo $code_mirror_mode; ?>",
                        matchBrackets: true
                    });
                }
              </script>
            <?php
 
    }



    /**
     * Show the options form in the `post` screen
     */
    function custom_code_options_meta_box_callback( $post ) {

            $options = $this->get_options( $post->ID );

            if ( isset( $_GET['language'] ) ) {
                $options['language'] = $_GET['language'];
            }

            $selected = array(
                'header' => '',
                'footer' => '',
                'internal' => '',
                'external' => '',
                'priority' => 5,
                'frontend'  => '',
                'admin' => '',
            );

            if ( isset( $options['priority'] ) ) { 
                $selected['priority'] = $options['priority'];
            } 

            if ( isset( $options['type'] ) ) {
                $selected[ $options['type'] ] = ' checked="checked"';
            }

            if ( isset( $options['linking'] ) ) {
                $selected[ $options['linking'] ] = ' checked="checked"';
            }

            if ( isset( $options['side'] ) ) {
                $selected[ $options['side'] ] = ' checked="checked"';
            }

            wp_nonce_field( 'options_save_meta_box_data', 'custom-css-js_meta_box_nonce' );
            ?>
             <style type="text/css">
             .radio-group input { margin-top: 1px; }
             .radio-group label { padding: 2px 0; }
            .options_meta_box h3 { margin-top: 10px !important; }
            .radio-group { line-height: 30px; padding-left: 10px; }
            .radio-group .dashicons-before:before { margin: 7px 3px 0 3px; }
            .options_meta_box select { margin-left: 10px; }
             </style>


            <div class="options_meta_box">
            <h3>Linking type</h3>
            <div class="radio-group">

            <input type="radio" <?php echo $selected['external']; ?>value="external" name="custom_code_linking" id="custom_code_linking-external"><label class="dashicons-before dashicons-media-code" for="custom_code_linking-external"> External File</label><br />

            <input type="radio" <?php echo $selected['internal']; ?>value="internal" name="custom_code_linking" id="custom_code_linking-internal"><label class="dashicons-before dashicons-editor-alignleft" for="custom_code_linking-internal"> Internal</label><br />
            </div>


            <h3>Where on page</h3>
             <div class="radio-group">
             <input type="radio" <?php echo $selected['header']; ?>value="header" name="custom_code_type" id="custom_code_type-header"><label class="dashicons-before dashicons-arrow-up-alt2" for="custom_code_type-header"> Header</label><br />
             <input type="radio" <?php echo $selected['footer']; ?>value="footer" name="custom_code_type" id="custom_code_type-footer"><label class="dashicons-before dashicons-arrow-down-alt2" for="custom_code_type-footer"> Footer</label><br />
            </div>


            <?php /*
            <h3>Priority</h3>
            <select name="custom_code_priority">
            <?php

            $priorities = array( 1 => '1 highest', '2', '3', '4', '5 default', '6', '7', '8', '9', '10 lowest');

            foreach( $priorities as $_key => $_value ) {
                $checked = ''; 
                if ( $_key == $selected['priority'] ) {
                    $checked = 'selected="selected" ';
                }

                echo "\t" . '<option value="'.$_key.'"'.$checked .'>'.$_value.'</option>' . PHP_EOL;
            }

            ?>
            </select>
             */ ?>
            <input type="hidden" name="custom_code_priority" value="5" />



            <h3>Where in site</h3>
            <div class="radio-group">
            <input type="radio" <?php echo $selected['frontend']; ?>value="frontend" name="custom_code_side" id="custom_code_side-frontend"><label class="dashicons-before dashicons-tagcloud" for="custom_code_side-frontend"> In Frontend</label><br />
            <input type="radio" <?php echo $selected['admin']; ?>value="admin" name="custom_code_side" id="custom_code_side-admin"><label class="dashicons-before dashicons-id" for="custom_code_side-admin"> In Admin</label><br />
            </div>

            <input type="hidden" name="custom_code_language" value="<?php echo $options['language']; ?>" />

            <div style="clear: both;"></div>


            <?php
    }


    /**
     * Save the post and the metadata
     */
    function options_save_meta_box_data( $post_id ) {

        
        // The usual checks
        if ( ! isset( $_POST['custom-css-js_meta_box_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['custom-css-js_meta_box_nonce'], 'options_save_meta_box_data' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['post_type'] ) && 'custom-css-js' != $_POST['post_type'] ) {
            return;
        }

        // Update the post's meta
        $defaults = array(
            'type'  => 'header',
            'linking'   => 'internal',
            'priority'  => 5,
            'side'  => 'frontend', 
            'language' => 'css',
        );

        foreach( $defaults as $_field => $_default ) {
            $options[ $_field ] = isset( $_POST['custom_code_'.$_field] ) ? $_POST['custom_code_'.$_field] : $_default;
        }

        update_post_meta( $post_id, 'options', $options );


        // Save the Custom Code in a file in `wp-content/uploads/custom-css-js`
        if ( $options['linking'] == 'internal' ) {
                
            $before = '<!-- start Simple Custom CSS and JS -->' . PHP_EOL; 
            $after = '<!-- end Simple Custom CSS and JS -->' . PHP_EOL;
            if ( $options['language'] == 'css' ) {
                $before .= '<style type="text/css">' . PHP_EOL;
                $after = '</style>' . PHP_EOL . $after;
            }
            if ( $options['language'] == 'js' ) {
                if ( ! preg_match( '/<script\b[^>]*>([\s\S]*?)<\/script>/im', $_POST['content'] ) ) {
                $before .= '<script type="text/javascript">' . PHP_EOL;
                $after = '</script>' . PHP_EOL . $after;
                }
            }
        }

        if ( $options['linking'] == 'external' ) {
            $before = '/******* Do not edit this file *******' . PHP_EOL .
            'Simple Custom CSS and JS - by Silkypress.com' . PHP_EOL . 
            'Saved: '.date('M d Y | H:i:s').' */' . PHP_EOL;
        }

        if ( is_multisite() ) {
            $this->create_custom_css_js_dir();
        }

        if ( wp_is_writable( $this->main->upload_dir ) ) {
            $file_name = $post_id . '.' . $options['language'];
            $file_content = $before . stripslashes($_POST['content']) . $after;
            @file_put_contents( $this->main->upload_dir . '/' . $file_name , $file_content );
        }


        $this->build_search_tree();
    }

    private function create_custom_css_js_dir() {
        $upload_dir = $this->main->upload_dir;

        wp_mkdir_p( $upload_dir ); 

        // Top level blank index.php
        if ( ! file_exists( $upload_dir . '/index.php' ) && wp_is_writable( $upload_dir ) ) {
            $content = '<?php' . PHP_EOL . '// Silence is golden.'; 
            @file_put_contents( $upload_dir . '/index.php', $content );
        }

    } 


    /**
     * Build a tree where you can quickly find the needed custom-css-js posts 
     *
     * @return void
     */
    private function build_search_tree() {

        $posts = query_posts( 'post_type=custom-css-js&post_status=publish&nopaging=true' );

        if ( ! is_array( $posts ) || count( $posts ) == 0 ) {
            return false;
        }

        $tree = array();
        foreach ( $posts as $_post ) {
            if ( ! $this->is_active( $_post->ID ) ) {
                continue;
            }

            $options = $this->get_options( $_post->ID );
            
            $tree_branch = $options['side'] . '-' .$options['language'] . '-' . $options['type'] . '-' . $options['linking'];

            $filename = $_post->ID . '.' . $options['language'];

            if ( $options['linking'] == 'external' ) {
                $filename .= '?v=' . rand(1, 10000); 
            }

            $tree[ $tree_branch ][] = $filename; 

        }

        update_option( 'custom-css-js-tree', $tree );
    }

    /**
     * Rebuilt the tree when you trash or restore a custom code
     */
    function trash_post( $post_id ) {
        $this->build_search_tree( );
    }


    /**
     * Compatibility with `shortcoder` plugin
     */
    function compatibility_shortcoder() {
        ob_start( array( $this, 'compatibility_shortcoder_html' ) );
    }
    function compatibility_shortcoder_html( $html ) {
        if ( strpos( $html, 'QTags.addButton' ) === false ) return $html;
        if ( strpos( $html, 'codemirror/codemirror-compressed.js' ) === false ) return $html;

        return str_replace( 'QTags.addButton', '// QTags.addButton', $html );
    }


}

return new CustomCSSandJS_Admin();
