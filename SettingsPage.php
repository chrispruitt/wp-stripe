<?php

class SettingsPage {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            'WP Stripe',
            'manage_options',
            'my-setting-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>WP Stripe Settings</h2>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'test-settings' );
                ?>
                <hr />
                <?php
                do_settings_sections( 'live-settings' );
                submit_button();
                ?>
            </form>
        </div>
    <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Test Settings', // Title
            $this, // Callback
            'test-settings' // Page Section
        );

        add_settings_section(
            'setting_section_id', // ID
            'Live Settings', // Title
            $this, // Callback
            'live-settings' // Page Section
        );

        add_settings_field(
            'test_secret_key', // ID
            'Test Secret Key', // Title
            array( $this, 'test_secret_key_callback' ), // Callback
            'test-settings', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'test_publishable_key', // ID
            'Test Publishable Key', // Title
            array( $this, 'test_publishable_key_callback' ), // Callback
            'test-settings', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'live_secret_key', // ID
            'Live Secret Key', // Title
            array( $this, 'live_secret_key_callback' ), // Callback
            'live-settings', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'live_publishable_key', // ID
            'Live Publishable Key', // Title
            array( $this, 'live_publishable_key_callback' ), // Callback
            'live-settings', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'key_to_use', // ID
            'Which key would you like to use?', // Title
            array( $this, 'key_to_use_callback' ), // Callback
            'live-settings', // Page
            'setting_section_id' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['test_secret_key'] ) ) {
            $new_input['test_secret_key'] = sanitize_text_field($input['test_secret_key']);
        }
        if( isset( $input['test_publishable_key'] ) ) {
            $new_input['test_publishable_key'] = sanitize_text_field($input['test_publishable_key']);
        }
        if( isset( $input['live_secret_key'] ) ) {
            $new_input['live_secret_key'] = sanitize_text_field($input['live_secret_key']);
        }
        if( isset( $input['live_publishable_key'] ) ) {
            $new_input['live_publishable_key'] = sanitize_text_field($input['live_publishable_key']);
        }
        if( isset( $input['key_to_use'] ) ) {
            $new_input['key_to_use'] = $input['key_to_use'];
        }

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function test_secret_key_callback()
    {
        printf(
            '<input type="text" id="test_secret_key" name="my_option_name[test_secret_key]" value="%s" class="regular-text"/>',
            isset( $this->options['test_secret_key'] ) ? esc_attr( $this->options['test_secret_key']) : ''
        );
    }
    public function test_publishable_key_callback()
    {
        printf(
            '<input type="text" id="test_publishable_key" name="my_option_name[test_publishable_key]" value="%s" class="regular-text"/>',
            isset( $this->options['test_publishable_key'] ) ? esc_attr( $this->options['test_publishable_key']) : ''
        );
    }
    public function live_secret_key_callback()
    {
        printf(
            '<input type="text" id="live_secret_key" name="my_option_name[live_secret_key]" value="%s" class="regular-text"/>',
            isset( $this->options['live_secret_key'] ) ? esc_attr( $this->options['live_secret_key']) : ''
        );
    }
    public function live_publishable_key_callback()
    {
        printf(
            '<input type="text" id="live_publishable_key" name="my_option_name[live_publishable_key]" value="%s" class="regular-text"/>',
            isset( $this->options['live_publishable_key'] ) ? esc_attr( $this->options['live_publishable_key']) : ''
        );
    }
    public function key_to_use_callback() {
        printf(
            '<input type="radio" name="my_option_name[key_to_use]" value="test" %s/>Use Test Key',
            isset( $this->options['key_to_use'] ) && $this->options['key_to_use'] == 'test' ? 'checked' : ''
        );
        print('<br />');
        printf(
            '<input type="radio" name="my_option_name[key_to_use]" value="live" %s/>Use Live Key',
            isset( $this->options['key_to_use'] ) && $this->options['key_to_use'] == 'live' ? 'checked' : ''
        );
    }
}