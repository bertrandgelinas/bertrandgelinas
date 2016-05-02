<?php
// Admin Panel Options

if ( ! class_exists( 'Redux' ) ) {
    return;
}

// Add CSS panel
function uwl_redux_custom_css() {
    wp_register_style( 'uwl-redux-custom-css', uwl_plugin_url( 'assets/admin/redux-custom.css' ), array('redux-admin-css'), time(), 'all' );
    wp_enqueue_style('uwl-redux-custom-css');
}
add_action( 'redux/page/uwl_options/enqueue', 'uwl_redux_custom_css' );

// Option name where all the Redux data is stored.
$opt_name = "uwl_options";

// All the possible arguments for Redux.
$uwl_redux_header = '<span id="name"><span style="color: #4dbefa;">U</span>ltimate <span style="color: #4dbefa;">W</span>idgets</span>';

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'              => 'uwl_options', // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'          => $uwl_redux_header . __( 'Panel','kho' ), // Name that appears at the top of your panel
    'display_version'       => '', // Version that appears at the top of your panel
    'menu_type'             => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'        => true, // Show the sections below the admin menu item or not
    'menu_title'            => __( 'UWL Panel', 'kho' ),
    'page_title'            => __( 'Panel', 'kho' ),
    'global_variable'       => '', // Set a different name for your global variable other than the opt_name
    'dev_mode'              => false, // Show the time the page took to load, etc
    'customizer'            => true, // Enable basic customizer support,
    'async_typography'      => false, // Enable async for fonts,
    'disable_save_warn'     => true,
    'open_expanded'         => false,
    'templates_path'        => UWL_PLUGIN_DIR .'/assets/admin/templates/', // Path to the templates file for various Redux elements
    // OPTIONAL -> Give you extra features
    'page_priority'         => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'           => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'      => 'manage_options', // Permissions needed to access the options panel.
    'menu_icon'             => '', // Specify a custom URL to an icon
    'last_tab'              => '', // Force your panel to always open to a specific tab (by id)
    'page_icon'             => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
    'page_slug'             => 'uwl_options', // Page slug used to denote the panel
    'save_defaults'         => true, // On load save the defaults to DB before user clicks save or not
    'default_show'          => false, // If true, shows the default value next to each field that is not the default value.
    'default_mark'          => '', // What to print by the field's title if the value shown is default. Suggested: *
    'admin_bar'             => true,
    'admin_bar_icon'        => 'dashicons-admin-generic',
    // CAREFUL -> These options are for advanced use only
    'output'                => false, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'            => false, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    //'domain'              => 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
    'footer_credit'         => false, // Disable the footer credit of Redux. Please leave if you can help it.
    'footer_text'           => "",
    'show_import_export'    => false,
    'system_info'           => false,
);

$args['share_icons'][] = array(
    'url'   => 'https://www.facebook.com/KhoThemes',
    'title' => 'Like us on Facebook',
    'icon'  => 'el el-facebook'
);
$args['share_icons'][] = array(
    'url'   => 'https://twitter.com/KhoThemes',
    'title' => 'Follow us on Twitter',
    'icon'  => 'el el-twitter'
);
$args['share_icons'][] = array(
    'url'   => 'https://plus.google.com/+KhothemesPage/',
    'title' => 'Find us on google+',
    'icon'  => 'el el-googleplus'
);

Redux::setArgs( "uwl_options", $args );

/**
    Widgets
**/
Redux::setSection( $opt_name, array(
    'id'            => 'widgets',
    'icon'          => 'el el-cogs',
    'title'         => __( 'Widgets', 'kho' ),
    'customizer'    => false,
    'fields'        => array(
        array(
            'id'        => 'minify_css',
            'type'      => 'switch', 
            'title'     => __( 'Minify CSS', 'kho' ),
            'subtitle'  => __( 'Compress all CSS in a single file or activate the CSS when the widgets are on the page.', 'kho' ),
            "default"   => '1',
            'on'        => __( 'On', 'kho' ),
            'off'       => __( 'Off', 'kho' ),
        ),
        array(
            'id'        => 'minify_js',
            'type'      => 'switch', 
            'title'     => __( 'Minify JS', 'kho' ),
            'subtitle'  => __( 'Compress all JS in a single file or activate the JS when the widgets are on the page.', 'kho' ),
            "default"   => '1',
            'on'        => __( 'On', 'kho' ),
            'off'       => __( 'Off', 'kho' ),
        ),
        array(
            'id'        => 'about-me',
            'type'      => 'switch', 
            'title'     => __( 'About Me Widget', 'kho' ),
            "default"   => '1',
            'on'        => __( 'On', 'kho' ),
            'off'       => __( 'Off', 'kho' ),
        ),
        array(
            'id'        => 'contact-info',
            'type'      => 'switch', 
            'title'     => __( 'Contact Info Widget', 'kho' ),
            "default"   => '1',
            'on'        => __( 'On', 'kho' ),
            'off'       => __( 'Off', 'kho' ),
        ),
        array(
            'id'        => 'flickr',
            'type'      => 'switch', 
            'title'     => __( 'Flickr Widget', 'kho' ),
            "default"   => '1',
            'on'        => __( 'On', 'kho' ),
            'off'       => __( 'Off', 'kho' ),
        ),
        array(
            'id'        => 'instagram',
            'type'      => 'switch', 
            'title'     => __( 'Instagram Widget', 'kho' ),
            "default"   => '1',
            'on'        => __( 'On', 'kho' ),
            'off'       => __( 'Off', 'kho' ),
        ),
        array(
            'id'        => 'mailchimp',
            'type'      => 'switch', 
            'title'     => __( 'MailChimp Widget', 'kho' ),
            "default"   => '1',
            'on'        => __( 'On', 'kho' ),
            'off'       => __( 'Off', 'kho' ),
        ),
        array(
            'id'        => 'menu',
            'type'      => 'switch', 
            'title'     => __( 'Menu Widget', 'kho' ),
            "default"   => '1',
            'on'        => __( 'On', 'kho' ),
            'off'       => __( 'Off', 'kho' ),
        ),
    ),
));

/**
    Styling
**/
Redux::setSection( $opt_name, array(
    'id'            => 'styling',
    'icon'          => 'el el-magic',
    'title'         => __( 'Styling', 'kho' ),
    'customizer'    => false,
    'fields'        => array(
        array(
            'id'        => 'widgets_style',
            'type'      => 'select',
            'title'     => __( 'Widgets Style', 'kho' ), 
            'subtitle'  => __( 'Select your preferred style.', 'kho' ),
            'desc'      => '',
            'options'   => array(
                'style1'  => __( 'Style 1', 'kho' ),
                'style2'  => __( 'Style 2', 'kho' ),
                'style3'  => __( 'Style 3', 'kho' ),
            ),
            'default'   => 'style1',
        ),

        /*-----------------------------------------------------------------------------------*/
        /*  - Style 1
        /*-----------------------------------------------------------------------------------*/
        array(
            'id'        => 'style1_border_color',
            'type'      => 'color',
            'title'     => __( 'Style 1 Border Color', 'kho' ),
            'subtitle'  => __( 'Select your custom hex color.', 'kho' ),
            'default'   => '',
            'required'  => array( 'widgets_style', 'equals', 'style1' ),
        ),

        array(
            'id'        => 'style1_padding',
            'type'      => 'text',
            'title'     => __( 'Style 1 Padding', 'kho' ),
            'subtitle'  => __( 'Enter your custom padding in pixels.', 'kho' ),
            'default'   => '16px',
            'required'  => array( 'widgets_style', 'equals', 'style1' ),
        ),

        array(
            'id'        => 'style1_margin_bottom',
            'type'      => 'text',
            'title'     => __( 'Style 1 Margin Bottom', 'kho' ),
            'subtitle'  => __( 'Enter your custom margin bottom in pixels.', 'kho' ),
            'default'   => '40px',
            'required'  => array( 'widgets_style', 'equals', 'style1' ),
        ),

        array(
            'id'          => 'style1_title_bg',
            'type'        => 'color',
            'title'       => __( 'Style 1 Title Background', 'kho' ),
            'subtitle'    => __( 'Select your custom hex color.', 'kho' ),
            'default'     => '',
            'transparent' => false,
            'required'    => array( 'widgets_style', 'equals', 'style1' ),
        ),

        array(
            'id'          => 'style1_title_color',
            'type'        => 'color',
            'title'       => __( 'Style 1 Title Color', 'kho' ),
            'subtitle'    => __( 'Select your custom hex color.', 'kho' ),
            'default'     => '',
            'transparent' => false,
            'required'    => array( 'widgets_style', 'equals', 'style1' ),
        ),

        array(
            'id'        => 'style1_title_font_size',
            'type'      => 'text',
            'title'     => __( 'Style 1 Title Font Size', 'kho' ),
            'subtitle'  => __( 'Enter your font size for the title in pixels.', 'kho' ),
            'default'   => '10px',
            'required'  => array( 'widgets_style', 'equals', 'style1' ),
        ),

        /*-----------------------------------------------------------------------------------*/
        /*  - Style 2
        /*-----------------------------------------------------------------------------------*/
        array(
            'id'        => 'style2_margin_bottom',
            'type'      => 'text',
            'title'     => __( 'Style 2 Margin Bottom', 'kho' ),
            'subtitle'  => __( 'Enter your custom margin bottom in pixels.', 'kho' ),
            'default'   => '50px',
            'required'  => array( 'widgets_style', 'equals', 'style2' ),
        ),

        array(
            'id'          => 'style2_title_color',
            'type'        => 'color',
            'title'       => __( 'Style 2 Title Color', 'kho' ),
            'subtitle'    => __( 'Select your custom hex color.', 'kho' ),
            'default'     => '',
            'transparent' => false,
            'required'    => array( 'widgets_style', 'equals', 'style2' ),
        ),

        array(
            'id'        => 'style2_title_font_size',
            'type'      => 'text',
            'title'     => __( 'Style 2 Title Font Size', 'kho' ),
            'subtitle'  => __( 'Enter your font size for the title in pixels.', 'kho' ),
            'default'   => '16px',
            'required'  => array( 'widgets_style', 'equals', 'style2' ),
        ),

        array(
            'id'          => 'style2_title_border_color',
            'type'        => 'color',
            'title'       => __( 'Style 2 Title Border Color', 'kho' ),
            'subtitle'    => __( 'Select your custom hex color.', 'kho' ),
            'default'     => '',
            'transparent' => false,
            'required'    => array( 'widgets_style', 'equals', 'style2' ),
        ),

        array(
            'id'        => 'style2_title_border_width',
            'type'      => 'text',
            'title'     => __( 'Style 2 Title Border Width', 'kho' ),
            'subtitle'  => __( 'Enter your width for the title border.', 'kho' ),
            'default'   => '40%',
            'required'  => array( 'widgets_style', 'equals', 'style2' ),
        ),

        /*-----------------------------------------------------------------------------------*/
        /*  - Style 3
        /*-----------------------------------------------------------------------------------*/
        array(
            'id'        => 'style3_margin_bottom',
            'type'      => 'text',
            'title'     => __( 'Style 3 Margin Bottom', 'kho' ),
            'subtitle'  => __( 'Enter your custom margin bottom in pixels.', 'kho' ),
            'default'   => '30px',
            'required'  => array( 'widgets_style', 'equals', 'style3' ),
        ),

        array(
            'id'          => 'style3_title_bg',
            'type'        => 'color',
            'title'       => __( 'Style 3 Title Background', 'kho' ),
            'subtitle'    => __( 'Select your custom hex color.', 'kho' ),
            'default'     => '',
            'required'    => array( 'widgets_style', 'equals', 'style3' ),
        ),

        array(
            'id'          => 'style3_title_color',
            'type'        => 'color',
            'title'       => __( 'Style 3 Title Color', 'kho' ),
            'subtitle'    => __( 'Select your custom hex color.', 'kho' ),
            'default'     => '',
            'transparent' => false,
            'required'    => array( 'widgets_style', 'equals', 'style3' ),
        ),

        array(
            'id'        => 'style3_title_font_size',
            'type'      => 'text',
            'title'     => __( 'Style 3 Title Font Size', 'kho' ),
            'subtitle'  => __( 'Enter your font size for the title in pixels.', 'kho' ),
            'default'   => '18px',
            'required'  => array( 'widgets_style', 'equals', 'style3' ),
        ),

        array(
            'id'          => 'style3_title_border_color',
            'type'        => 'color',
            'title'       => __( 'Style 3 Title Border Bottom Color', 'kho' ),
            'subtitle'    => __( 'Select your custom hex color.', 'kho' ),
            'default'     => '',
            'required'    => array( 'widgets_style', 'equals', 'style3' ),
        ),

        array(
            'id'    => 'links-title',
            'type'  => 'info',
            'title' => false,
            'desc'  => __( 'Links Color', 'kho' ),
        ),

        array(
            'id'            => 'custom_links_color',
            'type'          => 'color',
            'title'         => __( 'Links Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => '',
            'transparent'   => false,
        ),

        array(
            'id'            => 'custom_links_hover_color',
            'type'          => 'color',
            'title'         => __( 'Links Hover Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => '',
            'transparent'   => false,
        ),

        array(
            'id'    => 'inputs-title',
            'type'  => 'info',
            'title' => false,
            'desc'  => __( 'Inputs Styles', 'kho' ),
        ),

        array(
            'id'            => 'input_bg',
            'type'          => 'link_color',
            'title'         => __( 'Input Background', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

        array(
            'id'            => 'input_color',
            'type'          => 'color',
            'title'         => __( 'Input Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => '',
            'transparent'   => false,
        ),

        array(
            'id'            => 'input_border',
            'type'          => 'link_color',
            'title'         => __( 'Input Border Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

        array(
            'id'    => 'buttons-title',
            'type'  => 'info',
            'title' => false,
            'desc'  => __( 'Buttons Styles', 'kho' ),
        ),

        array(
            'id'            => 'input_submit_bg',
            'type'          => 'link_color',
            'title'         => __( 'Input Submit Background', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

        array(
            'id'            => 'input_submit_color',
            'type'          => 'link_color',
            'title'         => __( 'Input Submit Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

        array(
            'id'            => 'input_submit_border',
            'type'          => 'link_color',
            'title'         => __( 'Input Submit Border Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

    ),
));

/**
Styling => Contact Info Widget
**/
Redux::setSection( $opt_name, array(
    'id'            => 'style_contact_info_widget',
    'title'         => __( 'Contact Info Widget', 'kho' ),
    'customizer'    => false,
    'subsection'    => true,
    'fields'        => array(
        array(
            'id'    => 'contact-info-default-style-title',
            'type'  => 'info',
            'title' => false,
            'desc'  => __( 'Default Style', 'kho' ),
        ),

        array(
            'id'                => 'default_style_icons_color',
            'type'              => 'color',
            'title'             => __( 'Icons Color', 'kho' ),
            'subtitle'          => __( 'Select your custom hex color.', 'kho' ),
            'default'           => '',
            'transparent'       => false,
        ),

        array(
            'id'                => 'default_style_icons_border_color',
            'type'              => 'color',
            'title'             => __( 'Icons Border Color', 'kho' ),
            'subtitle'          => __( 'Select your custom hex color.', 'kho' ),
            'default'           => '',
        ),

        array(
            'id'                => 'default_style_titles_color',
            'type'              => 'color',
            'title'             => __( 'Titles Color', 'kho' ),
            'subtitle'          => __( 'Select your custom hex color.', 'kho' ),
            'default'           => '',
            'transparent'       => false,
        ),

        array(
            'id'    => 'contact-info-big-icons-style-title',
            'type'  => 'info',
            'title' => false,
            'desc'  => __( 'Big Icons Style', 'kho' ),
        ),

        array(
            'id'            => 'big_icons_style_icons_bg',
            'type'          => 'link_color',
            'title'         => __( 'Icons Background', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

        array(
            'id'            => 'big_icons_style_icons_color',
            'type'          => 'link_color',
            'title'         => __( 'Icons Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

        array(
            'id'            => 'big_icons_style_icons_border_color',
            'type'          => 'link_color',
            'title'         => __( 'Icons Border Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

        array(
            'id'                => 'big_icons_style_titles_color',
            'type'              => 'color',
            'title'             => __( 'Titles Color', 'kho' ),
            'subtitle'          => __( 'Select your custom hex color.', 'kho' ),
            'default'           => '',
            'transparent'       => false,
        ),

        array(
            'id'    => 'contact-info-skype-title',
            'type'  => 'info',
            'title' => false,
            'desc'  => __( 'Skype Style', 'kho' ),
        ),

        array(
            'id'            => 'contact_info_skype_bg',
            'type'          => 'link_color',
            'title'         => __( 'Skype Background', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),

        array(
            'id'            => 'contact_info_skype_color',
            'type'          => 'link_color',
            'title'         => __( 'Skype Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),
    ),
));


/**
Styling => Menu Widget
**/
Redux::setSection( $opt_name, array(
    'id'            => 'style_menu_widget',
    'title'         => __( 'Menu Widget', 'kho' ),
    'customizer'    => false,
    'subsection'    => true,
    'fields'        => array(
        array(
            'id'                => 'links_border_bottom',
            'type'              => 'color',
            'title'             => __( 'Links Border Bottom Color', 'kho' ),
            'subtitle'          => __( 'Select your custom hex color.', 'kho' ),
            'default'           => '',
        ),

        array(
            'id'            => 'sub_icon_color',
            'type'          => 'link_color',
            'title'         => __( 'Sub Icon Color', 'kho' ),
            'subtitle'      => __( 'Select your custom hex color.', 'kho' ),
            'default'       => array(
                'regular'   => '',
                'hover'     => '',
                'active'    => '',
            ),
        ),
    ),
));

/**
    Custom CSS
**/
Redux::setSection( $opt_name, array(
    'id'            => 'custom_code',
    'icon'          => 'el el-css',
    'title'         => __( 'Custom CSS', 'kho' ),
    'customizer'    => false,
    'fields'        => array(
        array(
            'id'        => 'custom_css',
            'type'      => 'ace_editor',
            'mode'      => 'css',
            'theme'     => 'chrome',
            'title'     => __( 'Design Edits', 'kho' ),
            'subtitle'  => __( 'Quickly add some CSS to your theme to make design adjustments by adding it to this block. It is a much better solution then manually editing style.css', 'kho' ),
        ),
    ),
));

/**
    Import/Export
**/
Redux::setSection( $opt_name, array(
    'id'        => 'import_export',
    'title'     => __( 'Import / Export', 'kho' ),
    'icon'      => 'el el-refresh',
    'fields'    => array(
        array(
            'id'            => 'opt-import-export',
            'type'          => 'import_export',
            'title'         => 'Import Export',
            'subtitle'      => 'Save and restore your Redux options',
            'full_width'    => false,
        ),
    ),
));

class UWL_Redux_Tracking {
    public $options = array();
    public $parent;
    private static $instance = null;
    public static function get_instance() {
        if ( null == self::$instance ) {self::$instance = new self;}
        return self::$instance;
    }

    function __construct() {}
    public function load( $parent ) {}
    function _enqueue_tracking() {}
    function _enqueue_newsletter() {}
    function tracking_request() {}
    function newsletter_request() {}
    function print_scripts( $selector, $options, $button1, $button2 = false, $button2_function = '', $button1_function = '' ) {}
    function tracking() {}
}

UWL_Redux_Tracking::get_instance();