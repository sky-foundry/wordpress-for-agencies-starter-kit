<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Bridge\Twig\Extension\DumpExtension;
use Symfony\Component\VarDumper\Cloner\VarCloner;

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

if (function_exists('acf_add_options_page')) {
	acf_add_options_page([
        'page_title' => 'Theme Settings'
    ]);
}


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action('after_setup_theme', array($this, 'theme_supports'));
		add_filter('timber_context', array($this, 'add_to_context'));
		add_filter('get_twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_taxonomies'));
        add_filter('acf/settings/save_json', array($this, 'acf_save_point'));
        add_filter('acf/settings/load_json', array($this, 'acf_load_point'));
		parent::__construct();
	}
    
    /** This is where you can register custom post types. */
	public function register_post_types() {

	}
    
    /** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context($context) {
		$context['menu'] = new Timber\Menu();
		$context['site'] = $this;
        $context['options'] = get_fields('options');
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats', array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support('menus');
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig($twig) {
		$twig->addExtension(new Twig_Extension_StringLoader());

		$versionStrategy = new JsonManifestVersionStrategy(
			get_template_directory() . '/dist/manifest.json'
		);
		
		$packages = new Packages(new PathPackage('/', $versionStrategy));
		$twig->addExtension(new AssetExtension($packages));
		
		/**
		 * Add DEBUG extensions
		 */
		if (defined('WP_DEBUG') && WP_DEBUG) {
			$twig->addExtension(new DumpExtension(new VarCloner()));
		}
		
		return $twig;
	}

}

new StarterSite();
