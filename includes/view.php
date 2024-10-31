<?php
class Riloadr_Admin_Page extends scbAdminPage {
	function setup() {
		$this->args = array(
			'page_title' => 'Riloadr',
		);
	}

	function page_content() {
		echo html( 'p', 'On this page you choose how Riloadr should operate; the default settings should be enough'
			. ' to get you doing. Please use'
			. ' <a href="https://github.com/OleVik/riloadr-wordpress/issues" alt="GitHub">GitHub</a>'
			. ' for error reporting and feature requests.' );
		echo html( 'h2', 'Image Sizes' );
		echo html( 'p', 'Select where to get image sizes from. Each size should correspond to the maximum width of the'
			. ' targeted device, as the replaced images will use whichever image best fits the device the site'
			. ' is viewed on; and resized to fit the content using CSS. Possible options:'
			. '<br />Theme: Gather breakpoints from the built-in sizes of the current theme.'
			. '<br />Custom: Comma-separated list of breakpoint widths.'
			. '<br />Override: Force image sizes from plugin. WARNING: These may not fit your theme.' );
		echo $this->form_table( array(
			array(
				'title' => 'Source',
				'type' => 'radio',
				'name' => 'source',
				'value' => array(
					'theme' => 'Theme',
					'custom' => 'Custom',
					'override' => 'Override'
				),
				'selected' => 'theme'
			),
			array(
				'title' => 'Custom Image Sizes',
				'type' => 'textarea',
				'name' => 'image_sizes',
				'value' => '240, 320, 480, 640, 768, 800, 1024, 1280, 1600, 1920',
				'extra' => 'rows="5" cols="50"'
			)
		) );
		echo html( 'h2', 'HTML Metadata' );
		echo html( 'p', 'The options below are necessary for Riloadr to function out-of-the-box,'
			. ' and should remain as-is unless you are customizing the HTML Metadata yourself.' );
		echo $this->form_table( array(
			array(
				'title' => 'HandheldFriendly',
				'type' => 'checkbox',
				'name' => 'handheldfriendly',
				'desc' => 'Use <i>HandheldFriendly = True</i>',
				'checked' => true
			),
			array(
				'title' => 'MobileOptimized',
				'type' => 'checkbox',
				'name' => 'mobileoptimized',
				'desc' => 'Use <i>MobileOptimized = 0</i>',
				'checked' => true
			),
			array(
				'title' => 'ViewPort',
				'type' => 'checkbox',
				'name' => 'viewport',
				'desc' => 'Set ViewPort width to <i>device-width</i>',
				'checked' => true
			)
		) );
		echo html( 'h2', 'Image Load' );
		echo html( 'p', 'Tells Riloadr to defer the load of images; that is, the images will not load'
			. ' unless necessary. Possible options:'
			. '<br />None: Do not defer image load.'
			. '<br />Load: Images will be loaded once the window has fully loaded (window.onload).'
			. '<br />Below Fold: Images will load when the user is likely to see them (above the fold).'
			. '<br /><br />ignoreLowBandwidth: Use W3C Network Api to determine HiDPI compatability, IE set to true to force loading of Hi-Res images (<b>Experimental feature</b>).' );		
		echo $this->form_table( array(
			array(
				'title' => 'Defer Images',
				'type' => 'radio',
				'name' => 'defer',
				'value' => array(
					'none' => 'None',
					'load' => 'Load',
					'belowfold' => 'Below Fold'
				),
				'selected' => 'none'
			),
			array(
				'title' => 'Use ignoreLowBandwidth',
				'type' => 'radio',
				'name' => 'ignorelowbandwidth',
				'value' => array(
					'true' => 'Yes',
					'false' => 'No'
				),
				'selected' => 'false'
			)
		) );

		/*echo html( 'h2', 'Templates' );
		echo html( 'p', 'Comma-separated list of templates to apply Riloadr to.'
		. ' Use an asterisk (*) enables it across the site.' );
		echo $this->form_table( array(
			array(
				'title' => 'Template Parts',
				'type' => 'textarea',
				'name' => 'templates',
				'value' => "*",
				'extra' => 'rows="5" cols="50"'
			)
		) );*/
	}

	function page_footer() {
		parent::page_footer();
	?>
	<script type="text/javascript">
		(function() {
			var forms = document.getElementsByTagName('form');
			for (var i = 0; i < forms.length; i++) {
				forms[i].reset();
			}
		}());
	</script>
	<?php
	}
}