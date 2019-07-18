<?php 
//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class for registering a new settings page under Settings.
 */
class isba_Options_Page {

    /**
    * Holds the values to be used in the fields callbacks
    */
    private $options;
 
    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'isba_admin_menu' ) );
        add_action('admin_init', array( $this, 'isba_register_add_settings') );
    }

    /**
    * Registers a new settings page under Settings.
    */
    function isba_admin_menu() {

           global $themename, $shortname, $options, $spawned_options;    
           print_r($options);

        add_options_page(
            __( 'Infinite Scroll By Ajax Settings Page', 'hire-expert-developer' ),
            __( 'ISBA Settings', 'hire-expert-developer' ),
            'manage_options', // Capablilties
            'isba_settings_admin', // Page slug
            array(
                $this,
                'isba_settings_page_cb' // callback function
            )
        );
    }
   
    /**
     * Settings page display callback.
     */ 
    function isba_settings_page_cb() {

        // Set options class property
        $this->options = get_option( 'isba_settings_option' );

        ?>
        <div id="isba_settings_id" class="wrap">
        <h1>Infinite Scroll By Ajax Settings Page</h1>
        <?php echo $this->options; ?>
        <form method="post" action="options-general.php?page=isba_settings_admin" enctype="multipart/form-data" >

          <?php 
            wp_nonce_field( 'isba_setting_nonce_action', 'isba_security' ); 
            settings_fields( 'isba-reg-setting-group' ); // Settubg Group
            do_settings_sections( 'isba_settings_admin' ); // Page slug
            submit_button('Save Settings', 'primary', 'isba_save_changes'); 
          ?>
          </form>
        </div>


        <?php  
      
    }

    /**
     * Register and Add Settings.
     */
    function isba_register_add_settings() {

       //Register Settings.    
        register_setting( 'isba-reg-setting-group', 'isba_settings_option' );
        
        add_settings_section(
        'isba_settings_section_id', // Section ID
        'Main Settings', // Title
        '', // Callback
        'isba_settings_admin' // Page Name isba_settings_admin
        );  

        add_settings_field(
        'isba_post_excerpt_size', // ID
        'Post Excerpt Size', // Title 
        array( $this, 'isba_post_excerpt_size_cb' ), // Callback
        'isba_settings_admin', // Page Name isba_settings_admin
        'isba_settings_section_id' // Section ID          
        );     
        

          if(isset($_POST['isba_save_changes'])) {
            if ( ! empty( $_POST ) && check_admin_referer( 'isba_setting_nonce_action', 'isba_security' ) ) {
                
                  // $test = 'fasdfsdfsdf';
                  // update_option('isba_settings_option',$test);
                  // Set options class property
                
            } 
        }
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function isba_post_excerpt_size_cb()
    {   
        printf(
            '<input type="text" name="isba_settings_option[isba_post_excerpt_size]" id="isba_post_excerpt_size" value="%s" class="regular-text">',
            isset( $this->options['isba_post_excerpt_size'] ) ? esc_attr( $this->options['isba_post_excerpt_size']) : ''
        );
    }

}
 
new isba_Options_Page; 

