<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://datamad.co.uk
 * @since      0.0.1
 *
 * @package    Plantuml_Renderer
 * @subpackage Plantuml_Renderer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plantuml_Renderer
 * @subpackage Plantuml_Renderer/public
 * @author     Todd Halfpenny <todd@toddhalfpenny.com>
 */
class Plantuml_Renderer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param    string $plugin_name	The name of the plugin.
	 * @param    string $version			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'plantuml', array( $this, 'pumlr_shortcode_handler' ) );
	}

	/**
	 * Our lovely shortcode.
	 *
	 * @param    array  $atts    Attributes passed into shortcode.
	 * @param    string $content Content within the shortcode tags.
	 * @since    0.0.3
	 */
	public function pumlr_shortcode_handler( $atts, $content = null ) {
		$new_content = str_replace( '&gt;','>',$content );					// Right angle bracket.
		$new_content = str_replace( '&lt;','<',$new_content );			// Left angle bracket.
		$new_content = str_replace( '&#8211;','--',$new_content );	// En-dash  (WP converts "--" to one en-dash).
		$new_content = str_replace( '&#8212;','--',$new_content );	// Em-dash  (WP converts "--" to one em-dash).
		$new_content = str_replace( '&#8220;','"',$new_content );	  // Curly left double quote
		$new_content = str_replace( '&#8221;','"',$new_content );	  // Curly right double quote
		$new_content = str_replace( '&#8221;','"',$new_content );	  // Curly right double quote
		$remove_array = array( '<p>', '</p>', '<br />', '<br/>' );		// Remove HTML tags.
		$new_content = str_replace( $remove_array, '', $new_content );
		$img = '<p><img src=http://www.plantuml.com/plantuml/img/';
		$img .= $this->encodep( $new_content );
		$img .= ' alt="PlantUML Syntax:' . $content . '" usemap="#plantuml_map">';

		// Get the image map, if our syntax has plantuml link syntax.
		$linkpos = strpos( $new_content, '[[' );
		if ( false !== $linkpos ) {
			$response = wp_remote_get( 'http://www.plantuml.com/plantuml/map/' . $this->encodep( $new_content ) );
			if ( is_array( $response ) ) {
				$body = $response['body'];
				$img .= $body;
			}
		}
		$img .= '</p>';
		return $img;
	}


	/**
	 * Encode our plantuml syntax - See PlantUML PHP Doc for details - where this was lifted from.
	 *
	 * @param    string $text Our text to encode.
	 * @since    1.0.0
	 */
	private function encodep( $text ) {
		$data = utf8_encode( $text );
		$compressed = gzdeflate( $data, 9 );
		return $this->encode64( $compressed );
	}


	/**
	 * Encode6bit - See PlantUML PHP Doc for details - where this was lifted from.
	 *
	 * @param    char $b Char.
	 * @since    1.0.0
	 */
	private function encode6bit( $b ) {
		if ( $b < 10 ) {
			return chr( 48 + $b );
		}
		$b -= 10;
		if ( $b < 26 ) {
			return chr( 65 + $b );
		}
		$b -= 26;
		if ( $b < 26 ) {
			return chr( 97 + $b );
		}
		$b -= 26;
		if ( 0 == $b ) {
			return '-';
		}
		if ( 1 == $b ) {
			return '_';
		}
		return '?';
	}


	/**
	 * Append3bytes - See PlantUML PHP Doc for details - where this was lifted from.
	 *
	 * @param    byte $b1 Some byte?.
	 * @param    byte $b2 Some byte?.
	 * @param    byte $b3 Some byte?.
	 * @since    1.0.0
	 */
	private function append3bytes( $b1, $b2, $b3 ) {
			 $c1 = $b1 >> 2;
			 $c2 = ( ( $b1 & 0x3 ) << 4 ) | ( $b2 >> 4 );
			 $c3 = ( ( $b2 & 0xF ) << 2 ) | ( $b3 >> 6 );
			 $c4 = $b3 & 0x3F;
			 $r = '';
			 $r .= $this->encode6bit( $c1 & 0x3F );
			 $r .= $this->encode6bit( $c2 & 0x3F );
			 $r .= $this->encode6bit( $c3 & 0x3F );
			 $r .= $this->encode6bit( $c4 & 0x3F );
			 return $r;
	}


	/**
	 * Encode64 - See PlantUML PHP Doc for details - where this was lifted from.
	 *
	 * @param    char $c Char.
	 * @since    1.0.0
	 */
	private function encode64( $c ) {
		$str = '';
		$len = strlen( $c );
		for ( $i = 0; $i < $len; $i += 3 ) {
			if ( $i + 2 == $len ) {
				$str .= $this->append3bytes( ord( substr( $c, $i, 1 ) ) , ord( substr( $c, $i + 1, 1 ) ), 0 );
			} else if ( $i + 1 == $len ) {
				$str .= $this->append3bytes( ord( substr( $c, $i, 1 ) ) , 0, 0 );
			} else {
				$str .= $this->append3bytes( ord( substr( $c, $i, 1 ) ), ord( substr( $c, $i + 1, 1 ) ), ord( substr( $c, $i + 2, 1 ) ) );
			}
		}
		return $str;
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plantuml_Renderer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plantuml_Renderer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plantuml-renderer-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plantuml_Renderer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plantuml_Renderer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plantuml-renderer-public.js', array( 'jquery' ), $this->version, false );
	}
}
