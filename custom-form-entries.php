<?php
/*
Plugin Name: Custom Form Entries
Description: A plugin to display form and its entries in frontend using shortcode and form submission using AJAX.
Version: 1.0
Author: Sonam Gupta
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if (!defined('CFE_PLUGIN_URL')) {
	if(is_ssl()){
		define('CFE_PLUGIN_URL', str_replace('http://', 'https://', plugin_dir_url(__FILE__)));
	}else{
		define('CFE_PLUGIN_URL', plugin_dir_url(__FILE__));
	}
}
/* define constant for plugin dir */
if (!defined('CFE_PLUGIN_DIR')) {
	define('CFE_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

global $custom_form_entries_version;
$custom_form_entries_version = '1.0';

global $custom_form_entries;
$custom_form_entries = new CustomFormEntries();


class CustomFormEntries {
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'cfe_entries';

        // Hooks
        register_activation_hook(__FILE__, array($this, 'cfe_activate_plugin'));
        add_shortcode('cfe_form', array($this, 'cfe_display_form'));
        add_shortcode('cfe_entries', array($this, 'cfe_display_entries'));
        add_action('wp_ajax_cfe_submit_form', array($this, 'cfe_submit_form'));
        add_action('wp_ajax_nopriv_cfe_submit_form', array($this, 'cfe_submit_form'));
        add_action('wp_enqueue_scripts', array($this, 'cfe_enqueue_scripts'));
    }

    public function cfe_activate_plugin() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        if($wpdb->get_var( "show tables like '$this->table_name'" ) != $this->table_name ) {
            $sql = "CREATE TABLE $this->table_name (
                id int(11) NOT NULL AUTO_INCREMENT,
                first_name varchar(255) NOT NULL,
                last_name varchar(255) NOT NULL,
                email varchar(255) NOT NULL,
                phone varchar(20) NOT NULL,
                PRIMARY KEY (id)
            ) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            // Insert test entries
            for ($i = 1; $i <= 15; $i++) {
                $wpdb->insert($this->table_name, [
                    'first_name' => 'First' . $i,
                    'last_name' => 'Last' . $i,
                    'email' => 'email' . $i . '@example.com',
                    'phone' => '1234567890',
                ]);
            }
        }
    }

    public function cfe_display_form() {
        ob_start();
        require_once CFE_PLUGIN_DIR. 'views/cfe-custom-form.php';
        return ob_get_clean();
    }

    public function cfe_submit_form() {
        global $wpdb;
        parse_str($_POST['data'], $data);
        $first_name = sanitize_text_field($data['first_name']);
        $last_name = sanitize_text_field($data['last_name']);
        $email = sanitize_email($data['email']);
        $phone = sanitize_text_field($data['phone']);

        $wpdb->insert($this->table_name, [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
        ]);

        echo 'Entry successfully added!';
        wp_die();
    }

    public function cfe_display_entries() {
        global $wpdb;
        ob_start();
        require_once CFE_PLUGIN_DIR. 'views/cfe-form-entries.php';
        return ob_get_clean();
    }

    public function cfe_enqueue_scripts() {
        global $custom_form_entries_version;
        wp_enqueue_script('jquery');
        wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
        wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), $custom_form_entries_version, true);
        wp_enqueue_style('cfe_style', CFE_PLUGIN_URL . 'assets/css/style.css', '', $custom_form_entries_version);
        wp_enqueue_script('cfe_custom', CFE_PLUGIN_URL . 'assets/js/custom.js', array(), $custom_form_entries_version, true);
        wp_localize_script('cfe_custom', 'ajaxObj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    }
}
