<?php
	/* Plugin Settings Page */
	
	class NewsletterSettingsPage
	{
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
				'Improvi Newsletter Settings',
				'manage_options', 
				'impr_nl-setting-admin', 
				array( $this, 'create_admin_page' )
			);
		}

		/**
		 * Options page callback
		 */
		public function create_admin_page()
		{
			// Set class property
			$this->options = get_option( 'impr_nl_options' );
			?>
			<div class="wrap">
				<?php screen_icon(); ?>
				<h2>Improvi Newsletter Settings</h2>
				<form method="post" action="options.php">
				<?php
					// This prints out all hidden setting fields
					settings_fields( 'impr_nl_option_group' );   
					do_settings_sections( 'impr_nl-setting-admin' );
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
				'impr_nl_option_group', // Option group
				'impr_nl_options', // Option name
				array( $this, 'sanitize' ) // Sanitize
			);

			add_settings_section(
				'setting_section_id', // ID
				'', // Title
				array( $this, 'print_section_info' ), // Callback
				'impr_nl-setting-admin' // Page
			);

			add_settings_field(
				'class_name', 
				'CSS Class', 
				array( $this, 'class_name_callback' ), 
				'impr_nl-setting-admin', 
				'setting_section_id'
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

			if( isset( $input['class_name'] ) )
				$new_input['class_name'] = sanitize_text_field( $input['class_name'] );

			return $new_input;
		}

		/** 
		 * Print the Section text
		 */
		public function print_section_info()
		{
			print '<a href="' . plugins_url('impr_newsletters.csv', __FILE__ ) . '">Download</a> the CSV file with the newsletter signups.<br><br>';
			print 'Wrap the newsletter plugin code in a CSS class of your choice for styling.';
			
		}

		/** 
		 * Get the settings option array and print one of its values
		 */
		public function class_name_callback()
		{
			printf(
				'<input type="text" id="class_name" name="impr_nl_options[class_name]" value="%s" />',
				isset( $this->options['class_name'] ) ? esc_attr( $this->options['class_name']) : ''
			);
		}
	}
?>