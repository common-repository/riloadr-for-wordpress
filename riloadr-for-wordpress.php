<?php
/*
 Plugin Name: Riloadr for WordPress
 Plugin URI: http://olevik.me/
 Description: Riloadr for WordPress is a cross-browser responsive images loader for WordPress 3.0.0 and up.
 Author: Ole Vik
 Version: 1.2.1
 Author URI: http://olevik.me/
 */

/*
Copyright (c) 2012, Ole Vik. 
 
This program is free software; you can redistribute it and/or 
modify it under the terms of the GNU General Public License 
as published by the Free Software Foundation; either version 2 
of the License, or (at your option) any later version. 
 
This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 
 
You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA. 
*/

require dirname( __FILE__ ) . '/scb/load.php';

function riloadr_init() {
	$options = new scbOptions('riloadr_settings', __FILE__, array(
		'source' => 'theme',
		'image_sizes' => '240, 320, 480, 640, 768, 800, 1024, 1280, 1600, 1920',
		'handheldfriendly' => 1,
		'mobileoptimized' => 1,
		'viewport' => 1,
		'defer' => 'none',
		'ignorelowbandwidth' => 'false'
	));
	if ( is_admin() ) {
		require_once( dirname( __FILE__ ) . '/includes/view.php' );
		new Riloadr_Admin_Page( __FILE__, $options );
	} else {
		add_action('init', 'riloadr_public_init');
		/** 
		* 
		* @return public initialization of Riloadr 
		*/  
		function riloadr_public_init() {
			global $_wp_additional_image_sizes;
			$options = get_option( 'riloadr_settings' );
			$riloadr = new Riloadr($options);
			$riloadr->image_sizes();
			new Riloadr_Scripts($_wp_additional_image_sizes, $options);
			new Riloadr_Filters($options);
		}
	}
}
	/** 
	* Riloadr main class
	* 
	* Initializes Riloadr for Wordpress by creating
	* the necessary image sizes and gathering
	* options from the database.
	* 
	* @author Ole Vik <public@olevik.me> 
	* @copyright 2012 Ole Vik
	* @license http://www.gnu.org/licenses/gpl-2.0.html GNU GPLv2
	* @package Riloadr
	* @version 1.1.1
	*/  
	class Riloadr {
		/** 
		* @var string stores data for the class 
		*/
		public $options;
		/** 
		* @param string constructs and assigns $options
		* @return $options as $this-options
		*/
		function __construct($options) {
			$this->options = $options;
		}
		/** 
		* @return WordPress image sizes through 'add_image_size()'
		*/
		public function image_sizes() {
			add_theme_support('post-thumbnails');
			if ($this->options['source'] == 'theme') {}
			if ($this->options['source'] == 'custom') {
				$sizes = str_replace(' ', '', $this->options['image_sizes']);
				$sizes = explode(',', $sizes);
				foreach ($sizes as $width) {
					add_image_size(''.$width.'', $width, 9999);
				}
			}
			if ($this->options['source'] == 'override') {
				add_image_size('1920', 1920, 9999);
				add_image_size('1600', 1600, 9999);
				add_image_size('1280', 1280, 9999);
				add_image_size('1024', 1024, 9999);
				add_image_size('800', 800, 9999);
				add_image_size('768', 768, 9999);
				add_image_size('640', 640, 9999);
				add_image_size('480', 480, 9999);
				add_image_size('320', 320, 9999);
				add_image_size('240', 240, 9999);
			}
		}
	}
	/** 
	* Riloadr Scripts
	* 
	* Extends Riloadr by adding necessary scipts
	* to WordPress by using 'wp_enqueue_script()'.
	* 
	* @author Ole Vik <public@olevik.me> 
	* @copyright 2012 Ole Vik
	* @license http://www.gnu.org/licenses/gpl-2.0.html GNU GPLv2
	* @package Riloadr
	* @version 1.2.1
	*/  
	class Riloadr_Scripts extends Riloadr {
		/** 
		* @param array $theme_image_sizes holds predefined image sizes
		* @param array $options holds predefined options
		* @return scripts into 'wp_head()'
		*/
		function __construct($theme_image_sizes, $options) {
			parent::__construct($options);
			$this->options = $options;
			$this->theme_image_sizes = $theme_image_sizes;
			$image_sizes = $image_sizes_riloadr = array();
			$image_sizes[0] = array('', '');
			foreach ($this->theme_image_sizes as $key => $data) {
				$image_sizes[] = array($key, $data['width']);
			}
			for ($i=1; $i<count($image_sizes); $i++) {
				$image_sizes_riloadr[$i]['name'] = $image_sizes[$i][0];
				$image_sizes_riloadr[$i]['minWidth'] = $image_sizes[$i][1];
				if ($image_sizes[$i-1][1]) {
					$image_sizes_riloadr[$i]['maxWidth'] = ($image_sizes[$i-1][1])-1;
				}
			}
			sort($image_sizes_riloadr);
			$this->image_sizes_riloadr = $image_sizes_riloadr;
			wp_enqueue_script('jquery');
			wp_register_script('riloadr',
			plugins_url( '' , __FILE__ ) . '/includes/riloadr.wp.jquery.min.js',
				array('jquery'),
				'1.2.1' );
			wp_enqueue_script('riloadr');
			wp_localize_script('riloadr', 'defer', $this->options['defer']);
			wp_localize_script('riloadr', 'ignorelowbandwidth', $this->options['ignorelowbandwidth']);
			wp_localize_script('riloadr', 'image_sizes', $this->image_sizes_riloadr);
		}
	}
	/** 
	* Riloadr Filters
	* 
	* Extends Riloadr by adding necessary metadata and 
	* replacing image elements attributes.
	* 
	* @author Ole Vik <public@olevik.me> 
	* @copyright 2012 Ole Vik
	* @license http://www.gnu.org/licenses/gpl-2.0.html GNU GPLv2
	* @package Riloadr
	* @version 1.2.1
	*/  
	class Riloadr_Filters extends Riloadr {
		/** 
		* @param array $options holds predefined options
		* @return filters into 'wp_head()'
		*/
		function __construct($options) {
			add_filter('img_caption_shortcode', array( 'Riloadr_Filters', 'riloadr_caption_shortcode'), 12, 3 );
			add_filter('the_content',  array( 'Riloadr_Filters', 'riloadr_img_replacement' ), 11);
			if ($this->options['handheldfriendly'] == 1) {
				add_filter( 'wp_head', array( 'Riloadr_Filters', 'riloadr_meta_handheldfriendly' ), 11 );
			}
			if ($this->options['mobileoptimized'] == 1) {
				add_filter( 'wp_head', array( 'Riloadr_Filters', 'riloadr_meta_mobileoptimized' ), 11 );
			}
			if ($this->options['viewport'] == 1) {
				add_filter( 'wp_head', array( 'Riloadr_Filters', 'riloadr_meta_viewport' ), 11 );
			}
		}
		/** 
		* @return HTML Metadata
		*/
		function riloadr_meta_handheldfriendly() {echo '<meta name="HandheldFriendly" content="True">' . "\n";}
		/** 
		* @return HTML Metadata
		*/
		function riloadr_meta_mobileoptimized() {echo '<meta name="MobileOptimized" content="0">' . "\n";}
		/** 
		* @return HTML Metadata
		*/
		function riloadr_meta_viewport() {echo '<meta name="viewport" content="width=device-width">' . "\n";}
		/** 
		* @param int $val Default WordPress variable
		* @param string $attr Default WordPress variable
		* @param string $content Default WordPress variable
		* @return images (captions) as html5 figure elements
		*/
		function riloadr_caption_shortcode($val, $attr, $content = null) {
			extract(shortcode_atts(array(
				'id'	=> '',
				'align'	=> 'alignnone',
				'width'	=> '',
				'caption' => ''
			), $attr));
			if ( 1 > (int) $width || empty($caption) )
				return $content;
			if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
			$img = preg_replace('/-[0-9]*x[0-9]*\./', '-150x150.', $content);
			return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '">' . "\n"
			. do_shortcode( $content )
			. '<noscript>' . $img . '</noscript>' . "\n"
			. '<figcaption class="wp-caption-text">' . $caption . '</figcaption>' . "\n"
			. '</figure>' . "\n";
		}
		/** 
		* @param string $content Default WordPress variable, see 'the_content()' in WP Codex
		* @return html with <img> tags replaced for use with Riloadr
		*/
		function riloadr_img_replacement($content = '') {
			$content = preg_replace('/-[0-9]*x[0-9]*\./', '{breakpoint-name}.', $content);
			preg_match_all('/<\s*img[^>]*src=[\"|\'](.*?)[\"|\'][^>]*\/*>/i', $content, $matches, PREG_SET_ORDER);
			foreach ($matches as $image) {
				$href = str_replace('{breakpoint-name}', '', $image[1]);
				$content = str_replace('href="'.$image[1].'"', 'href="'.$href.'"', $content);
			}
			$content = preg_replace( '/width/', "wdt", $content );
			$content = preg_replace( '/height/', "hgt", $content );
			$content = preg_replace('/src\=\"/', 'data-src="', $content);
			$content = preg_replace('/class\=\"/', 'class="riloadr ', $content);
			return $content;
		}
	}
scb_init( 'riloadr_init' );
?>