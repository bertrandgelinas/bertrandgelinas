<?php
// Add latest news from the Theme Junkie blog

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if (!class_exists('KhoThemesDashboardWidgetUWL')) {
    class KhoThemesDashboardWidgetUWL {

        public function __construct () {
            add_action('wp_dashboard_setup', array($this,'add_kt_dashboard_uwl'));
        }
        
        public function add_kt_dashboard_uwl() {
            add_meta_box('kt_dashboard_widget_uwl', __( 'Theme Junkie News' ), array($this,'kt_dashboard_widget_uwl'), 'dashboard', 'side', 'high');
        }
        
        public function kt_dashboard_widget_uwl() {
            echo '<div class="rss-widget">';
                wp_widget_rss_output(array(
                    'url'          => 'http://feeds.feedburner.com/ThemeJunkie',
                    'title'        => __( 'Theme Junkie Blog' ),
                    'items'        => 5,
                    'show_summary' => 0,
                    'show_author'  => 0,
                    'show_date'    => 0
                ));
            echo '</div>';
        }
    }
    
    new KhoThemesDashboardWidgetUWL();
}