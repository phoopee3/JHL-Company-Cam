<?php
/*
Plugin Name: Company Cam
Description: Connect to a Company Cam instance and get the photos to display
Version: 1.0.0
Author: Jason Lawton <jason@jasonlawton.com>
*/

define( 'JHL_CC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'JHL_CC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
// define( 'JHL_CC_TRANSIENT', 'jhl_cc_api_transient' );

add_action( 'admin_menu', 'jhl_cc_add_admin_menu' );
add_action( 'admin_init', 'jhl_cc_settings_init' );

function jhl_cc_add_admin_menu(  ) { 

	add_options_page( 'Company Cam', 'Company Cam', 'manage_options', 'jhl_auto_login', 'jhl_cc_options_page' );

}

function jhl_cc_settings_init(  ) { 

	register_setting( 'pluginPage', 'jhl_cc_settings' );

	add_settings_section(
		'jhl_cc_pluginPage_section', 
		__( 'Settings for Company Cam', 'jhl_cc' ), 
		'jhl_cc_settings_section_callback', 
		'pluginPage'
	);

}

function jhl_cc_settings_section_callback(  ) { 

	echo __( 'Use this page to manage settings', 'jhl_cc' );

}

function jhl_cc_options_page(  ) { 

    if (!current_user_can('manage_options')) {
        wp_die('Go away.');
    }

    if ( count( $_POST ) ) {
        if ( ! check_admin_referer( 'jhl_cc_option_page_update' ) ) {
            wp_die('Nonce verification failed');
        }

        // form fields

        if (isset($_POST['jhl_cc_api_key'])) {
            update_option('jhl_cc_api_key', $_POST['jhl_cc_api_key']);
            $value = $_POST['jhl_cc_api_key'];
        } 

        if (isset($_POST['jhl_cc_project_id'])) {
            update_option('jhl_cc_project_id', $_POST['jhl_cc_project_id']);
            $value = $_POST['jhl_cc_project_id'];
        }

        if (isset($_POST['jhl_cc_api_base'])) {
            update_option('jhl_cc_api_base', $_POST['jhl_cc_api_base']);
            $value = $_POST['jhl_cc_api_base'];
        } 

        if (isset($_POST['jhl_cc_api_endpoint'])) {
            update_option('jhl_cc_api_endpoint', $_POST['jhl_cc_api_endpoint']);
            $value = $_POST['jhl_cc_api_endpoint'];
        }

        if (isset($_POST['jhl_cc_user_email'])) {
            update_option('jhl_cc_user_email', $_POST['jhl_cc_user_email']);
            $value = $_POST['jhl_cc_user_email'];
        }

        if (isset($_POST['jhl_cc_delete_transient'])) {
            // delete the transient
            delete_transient( $jhl_cc_api_transient );
        }
    }

    include 'options-form.php';

}

// Add Shortcode
function jhl_cc_shortcode_company_cam() {
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    wp_enqueue_script( 'fancybox', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js', [ 'jquery' ], '3.5.7' );
    wp_enqueue_style( 'fancybox', 'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', [], '3.5.7' );

    $base       = get_option( 'jhl_cc_api_base' );
    $project_id = get_option( 'jhl_cc_project_id' );
    $endpoint   = get_option( 'jhl_cc_api_endpoint' );
    $api_key    = get_option( 'jhl_cc_api_key' );
    $url = trailingslashit( $base ) . trailingslashit( $project_id ) . $endpoint;
    $headers = [
        'Authorization' => "Bearer $api_key"
    ];
    $response = wp_remote_get( $url, ['headers' => $headers] );
    if ( is_wp_error( $response ) ) {
        if ( $response->has_errors() ) {
            $errors = $response->get_error_messages();
            foreach( $errors as $error ) {
                $error_message .= "<p>$error</p>";
            }
            return $error_message;
        } else {
            return "Error, but no error messages";
        }
    } else {
        $responseBody = wp_remote_retrieve_body( $response );
        $results = json_decode( $responseBody );
        ob_start();
        if ( count( $results ) ) {
            ?>
            <style>
                .container {
                    display: flex;
                    flex-wrap: wrap;
                    padding: 5px;
                    justify-content: space-evenly;
                }
                .item {
                    margin: 5px;
                }
                /* fix for divi header */
                #top-header, #main-header {
                    z-index:9999;
                }
            </style>
            <div class="container">
                <?php
                foreach( $results as $result ) {
                    $original = '';
                    $thumbnail = '';
                    foreach( $result->uris as $image ) {
                        if ( 'original' == $image->type ) {
                            $original = $image->url;
                        }
                        if ( 'thumbnail' == $image->type ) {
                            $thumbnail = $image->url;
                        }
                        if ( $original && $thumbnail ) {
                            break;
                        }
                    }
                    ?>
                    <a class="item" data-fancybox="gallery" href="<?php echo $original; ?>"><img src="<?php echo $thumbnail; ?>"></a>
                    <?php
                }
                ?>
            </div>
            <?php
        } // end if results
        $output = ob_get_clean();
        return $output;
    }
}
add_shortcode( 'company_cam', 'jhl_cc_shortcode_company_cam' );
