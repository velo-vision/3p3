<?php
/**
 * Internationalization helper.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

if ( ! class_exists( 'Kirki_l10n' ) ) {

	/**
	 * Handles translations
	 */
	class Kirki_l10n {

		/**
		 * The plugin textdomain
		 *
		 * @access protected
		 * @var string
		 */
		protected $textdomain = 'kirki';

		/**
		 * The class constructor.
		 * Adds actions & filters to handle the rest of the methods.
		 *
		 * @access public
		 */
		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		}

		/**
		 * Load the plugin textdomain
		 *
		 * @access public
		 */
		public function load_textdomain() {

			if ( null !== $this->get_path() ) {
				load_textdomain( $this->textdomain, $this->get_path() );
			}
			load_plugin_textdomain( $this->textdomain, false, Kirki::$path . '/languages' );

		}

		/**
		 * Gets the path to a translation file.
		 *
		 * @access protected
		 * @return string Absolute path to the translation file.
		 */
		protected function get_path() {
			$path_found = false;
			$found_path = null;
			foreach ( $this->get_paths() as $path ) {
				if ( $path_found ) {
					continue;
				}
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					$path_found = true;
					$found_path = $path;
				}
			}

			return $found_path;

		}

		/**
		 * Returns an array of paths where translation files may be located.
		 *
		 * @access protected
		 * @return array
		 */
		protected function get_paths() {

			return array(
				WP_LANG_DIR . '/' . $this->textdomain . '-' . get_locale() . '.mo',
				Kirki::$path . '/languages/' . $this->textdomain . '-' . get_locale() . '.mo',
			);

		}

		/**
		 * Shortcut method to get the translation strings
		 *
		 * @static
		 * @access public
		 * @param string $config_id The config ID. See Kirki_Config.
		 * @return array
		 */
		public static function get_strings( $config_id = 'global' ) {

			$translation_strings = array(
				'background-color'      => esc_html__( 'Background Color', 'kirki' ),
				'background-image'      => esc_html__( 'Background Image', 'kirki' ),
				'no-repeat'             => esc_html__( 'No Repeat', 'kirki' ),
				'repeat-all'            => esc_html__( 'Repeat All', 'kirki' ),
				'repeat-x'              => esc_html__( 'Repeat Horizontally', 'kirki' ),
				'repeat-y'              => esc_html__( 'Repeat Vertically', 'kirki' ),
				'inherit'               => esc_html__( 'Inherit', 'kirki' ),
				'background-repeat'     => esc_html__( 'Background Repeat', 'kirki' ),
				'cover'                 => esc_html__( 'Cover', 'kirki' ),
				'contain'               => esc_html__( 'Contain', 'kirki' ),
				'background-size'       => esc_html__( 'Background Size', 'kirki' ),
				'fixed'                 => esc_html__( 'Fixed', 'kirki' ),
				'scroll'                => esc_html__( 'Scroll', 'kirki' ),
				'background-attachment' => esc_html__( 'Background Attachment', 'kirki' ),
				'left-top'              => esc_html__( 'Left Top', 'kirki' ),
				'left-center'           => esc_html__( 'Left Center', 'kirki' ),
				'left-bottom'           => esc_html__( 'Left Bottom', 'kirki' ),
				'right-top'             => esc_html__( 'Right Top', 'kirki' ),
				'right-center'          => esc_html__( 'Right Center', 'kirki' ),
				'right-bottom'          => esc_html__( 'Right Bottom', 'kirki' ),
				'center-top'            => esc_html__( 'Center Top', 'kirki' ),
				'center-center'         => esc_html__( 'Center Center', 'kirki' ),
				'center-bottom'         => esc_html__( 'Center Bottom', 'kirki' ),
				'background-position'   => esc_html__( 'Background Position', 'kirki' ),
				'background-opacity'    => esc_html__( 'Background Opacity', 'kirki' ),
				'on'                    => esc_html__( 'ON', 'kirki' ),
				'off'                   => esc_html__( 'OFF', 'kirki' ),
				'all'                   => esc_html__( 'All', 'kirki' ),
				'cyrillic'              => esc_html__( 'Cyrillic', 'kirki' ),
				'cyrillic-ext'          => esc_html__( 'Cyrillic Extended', 'kirki' ),
				'devanagari'            => esc_html__( 'Devanagari', 'kirki' ),
				'greek'                 => esc_html__( 'Greek', 'kirki' ),
				'greek-ext'             => esc_html__( 'Greek Extended', 'kirki' ),
				'khmer'                 => esc_html__( 'Khmer', 'kirki' ),
				'latin'                 => esc_html__( 'Latin', 'kirki' ),
				'latin-ext'             => esc_html__( 'Latin Extended', 'kirki' ),
				'vietnamese'            => esc_html__( 'Vietnamese', 'kirki' ),
				'hebrew'                => esc_html__( 'Hebrew', 'kirki' ),
				'arabic'                => esc_html__( 'Arabic', 'kirki' ),
				'bengali'               => esc_html__( 'Bengali', 'kirki' ),
				'gujarati'              => esc_html__( 'Gujarati', 'kirki' ),
				'tamil'                 => esc_html__( 'Tamil', 'kirki' ),
				'telugu'                => esc_html__( 'Telugu', 'kirki' ),
				'thai'                  => esc_html__( 'Thai', 'kirki' ),
				'serif'                 => _x( 'Serif', 'font style', 'kirki' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'kirki' ),
				'monospace'             => _x( 'Monospace', 'font style', 'kirki' ),
				'font-family'           => esc_html__( 'Font Family', 'kirki' ),
				'font-size'             => esc_html__( 'Font Size', 'kirki' ),
				'font-weight'           => esc_html__( 'Font Weight', 'kirki' ),
				'line-height'           => esc_html__( 'Line Height', 'kirki' ),
				'font-style'            => esc_html__( 'Font Style', 'kirki' ),
				'letter-spacing'        => esc_html__( 'Letter Spacing', 'kirki' ),
				'top'                   => esc_html__( 'Top', 'kirki' ),
				'bottom'                => esc_html__( 'Bottom', 'kirki' ),
				'left'                  => esc_html__( 'Left', 'kirki' ),
				'right'                 => esc_html__( 'Right', 'kirki' ),
				'center'                => esc_html__( 'Center', 'kirki' ),
				'justify'               => esc_html__( 'Justify', 'kirki' ),
				'color'                 => esc_html__( 'Color', 'kirki' ),
				'add-image'             => esc_html__( 'Add Image', 'kirki' ),
				'change-image'          => esc_html__( 'Change Image', 'kirki' ),
				'no-image-selected'     => esc_html__( 'No Image Selected', 'kirki' ),
				'add-file'              => esc_html__( 'Add File', 'kirki' ),
				'change-file'           => esc_html__( 'Change File', 'kirki' ),
				'no-file-selected'      => esc_html__( 'No File Selected', 'kirki' ),
				'remove'                => esc_html__( 'Remove', 'kirki' ),
				'select-font-family'    => esc_html__( 'Select a font-family', 'kirki' ),
				'variant'               => esc_html__( 'Variant', 'kirki' ),
				'subsets'               => esc_html__( 'Subset', 'kirki' ),
				'size'                  => esc_html__( 'Size', 'kirki' ),
				'height'                => esc_html__( 'Height', 'kirki' ),
				'spacing'               => esc_html__( 'Spacing', 'kirki' ),
				'ultra-light'           => esc_html__( 'Ultra-Light 100', 'kirki' ),
				'ultra-light-italic'    => esc_html__( 'Ultra-Light 100 Italic', 'kirki' ),
				'light'                 => esc_html__( 'Light 200', 'kirki' ),
				'light-italic'          => esc_html__( 'Light 200 Italic', 'kirki' ),
				'book'                  => esc_html__( 'Book 300', 'kirki' ),
				'book-italic'           => esc_html__( 'Book 300 Italic', 'kirki' ),
				'regular'               => esc_html__( 'Normal 400', 'kirki' ),
				'italic'                => esc_html__( 'Normal 400 Italic', 'kirki' ),
				'medium'                => esc_html__( 'Medium 500', 'kirki' ),
				'medium-italic'         => esc_html__( 'Medium 500 Italic', 'kirki' ),
				'semi-bold'             => esc_html__( 'Semi-Bold 600', 'kirki' ),
				'semi-bold-italic'      => esc_html__( 'Semi-Bold 600 Italic', 'kirki' ),
				'bold'                  => esc_html__( 'Bold 700', 'kirki' ),
				'bold-italic'           => esc_html__( 'Bold 700 Italic', 'kirki' ),
				'extra-bold'            => esc_html__( 'Extra-Bold 800', 'kirki' ),
				'extra-bold-italic'     => esc_html__( 'Extra-Bold 800 Italic', 'kirki' ),
				'ultra-bold'            => esc_html__( 'Ultra-Bold 900', 'kirki' ),
				'ultra-bold-italic'     => esc_html__( 'Ultra-Bold 900 Italic', 'kirki' ),
				'invalid-value'         => esc_html__( 'Invalid Value', 'kirki' ),
				'add-new'           	=> esc_html__( 'Add new', 'kirki' ),
				'row'           		=> esc_html__( 'row', 'kirki' ),
				'limit-rows'            => esc_html__( 'Limit: %s rows', 'kirki' ),
				'open-section'          => esc_html__( 'Press return or enter to open this section', 'kirki' ),
				'back'                  => esc_html__( 'Back', 'kirki' ),
				'reset-with-icon'       => sprintf( esc_html__( '%s Reset', 'kirki' ), '<span class="dashicons dashicons-image-rotate"></span>' ),
				'text-align'            => esc_html__( 'Text Align', 'kirki' ),
				'text-transform'        => esc_html__( 'Text Transform', 'kirki' ),
				'none'                  => esc_html__( 'None', 'kirki' ),
				'capitalize'            => esc_html__( 'Capitalize', 'kirki' ),
				'uppercase'             => esc_html__( 'Uppercase', 'kirki' ),
				'lowercase'             => esc_html__( 'Lowercase', 'kirki' ),
				'initial'               => esc_html__( 'Initial', 'kirki' ),
				'select-page'           => esc_html__( 'Select a Page', 'kirki' ),
				'open-editor'           => esc_html__( 'Open Editor', 'kirki' ),
				'close-editor'          => esc_html__( 'Close Editor', 'kirki' ),
				'switch-editor'         => esc_html__( 'Switch Editor', 'kirki' ),
				'hex-value'             => esc_html__( 'Hex Value', 'kirki' ),
			);

			// Apply global changes from the kirki/config filter.
			// This is generally to be avoided.
			// It is ONLY provided here for backwards-compatibility reasons.
			// Please use the kirki/{$config_id}/l10n filter instead.
			$config = apply_filters( 'kirki/config', array() );
			if ( isset( $config['i18n'] ) ) {
				$translation_strings = wp_parse_args( $config['i18n'], $translation_strings );
			}

			// Apply l10n changes using the kirki/{$config_id}/l10n filter.
			return apply_filters( 'kirki/' . $config_id . '/l10n', $translation_strings );

		}
	}
}
