<?php
/**
 * elektrika220-380 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package elektrika220-380
 */

if ( ! function_exists( 'elektrika220_380_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function elektrika220_380_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on elektrika220-380, use a find and replace
	 * to change 'elektrika220-380' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'elektrika220-380', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'elektrika220-380' ),
	) );
	register_nav_menus( array(
		'menu-2' => esc_html__( 'Secondary', 'elektrika220-380' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'elektrika220_380_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
endif;
add_action( 'after_setup_theme', 'elektrika220_380_setup' );
function elk_replace_textdomain(){
	//unload_textdomain( 'woocommerce' );
	//load_textdomain( 'woocommerce', WP_PLUGIN_DIR .'/elk-localization/woocommerce-ru_RU.mo' );
	unload_textdomain( 'prdctfltr' );
	load_textdomain( 'prdctfltr', WP_PLUGIN_DIR .'/elk-localization/prdctfltr-ru_RU.mo' );
}
add_action('init', 'elk_replace_textdomain');
add_action('init', 'elk_create_taxonomy');
function elk_create_taxonomy(){
	// заголовки
	// весь список: http://wp-kama.ru/function/get_taxonomy_labels
	$labels = array(
		'name'              => 'Производители',
		'singular_name'     => 'Производитель',
		'search_items'      => 'Поиск производителей',
		'all_items'         => 'Все производители',
		'parent_item'       => 'Родительский раздел',
		'parent_item_colon' => 'Parent Genre:',
		'edit_item'         => 'Редактировать раздел',
		'update_item'       => 'Обновить раздел',
		'add_new_item'      => 'Добавить раздел',
		'new_item_name'     => 'Новый производитель',
		'menu_name'         => 'Производители',
	); 
	// параметры
	$args = array(
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => $labels,
		'description'           => '', // описание таксономии
		'public'                => true,
		'publicly_queryable'    => null, // равен аргументу public
		'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_tagcloud'         => true, // равен аргументу show_ui
		'show_in_rest'          => null, // добавить в REST API
		'rest_base'             => null, // $taxonomy
		'hierarchical'          => true,
		'update_count_callback' => '',
		'rewrite'               => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
		'show_admin_column'     => false, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
		'_builtin'              => false,
		'show_in_quick_edit'    => null, // по умолчанию значение show_ui
	);
	register_taxonomy('product_brand', array('product'), $args );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function elektrika220_380_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'elektrika220_380_content_width', 640 );
}
add_action( 'after_setup_theme', 'elektrika220_380_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function elektrika220_380_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'elektrika220-380' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'elektrika220-380' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title title-catalog">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Правая колонка каталога', 'elektrika220-380' ),
		'id'            => 'sidebar-right-category',
		'description'   => esc_html__( 'Add widgets here.', 'elektrika220-380' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Правая колонка товара', 'elektrika220-380' ),
		'id'            => 'sidebar-right-product',
		'description'   => esc_html__( 'Add widgets here.', 'elektrika220-380' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title title-catalog">',
		'after_title'   => '</h2>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Область под логотипом в футере', 'elektrika220-380' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Add widgets here.', 'elektrika220-380' ),
		'before_widget' => '<section id="%1$s" class="%2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Ссылка на Избранное', 'elektrika220-380' ),
		'id'            => 'sidebar-wishlist',
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Ссылка на сравнение', 'elektrika220-380' ),
		'id'            => 'sidebar-compare',
		'description'   => '',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'elektrika220_380_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function elektrika220_380_scripts() {
	wp_enqueue_style( 'elektrika220-380-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri().'/css/bootstrap.min.css' );
	wp_enqueue_style( 'formstyler', get_stylesheet_directory_uri().'/js/jQueryFormStyler/jquery.formstyler.css' );
	wp_enqueue_style( 'ie10-viewport-bug-workaround', get_stylesheet_directory_uri().'/css/ie10-viewport-bug-workaround.css' );
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri().'/css/custom.css' );	
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/ie10-viewport-bug-workaround.js', array('jquery'), null, true );
	wp_enqueue_script( 'formstyler-js', get_template_directory_uri() . '/js/jQueryFormStyler/jquery.formstyler.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'wcqi-number-polyfill' );
	wp_enqueue_script( 'elektrika-js', get_template_directory_uri() . '/js/elektrika.js', array('jquery','tm-woocompare','tm-woowishlist'), null, true );
	/*wp_localize_script( 'elektrika-js', 'tmWoocompare', array(
			'ajaxurl'     => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
			'compareText' => get_option( 'tm_woocompare_compare_text', __( 'Add to Compare', 'tm-wc-compare-wishlist' ) ),
			'removeText'  => get_option( 'tm_woocompare_remove_text', __( 'Remove from Compare List', 'tm-wc-compare-wishlist' ) ),
			'countFormat' => apply_filters( 'tm_compare_count_format', '<span class="compare-count">(%count%)</span>' )
		) );*/	
	if (is_checkout()){
		wp_enqueue_script( 'checkout-js', get_template_directory_uri() . '/js/elk-checkout.js', array('jquery'), null, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if (!is_admin()) {
		wp_register_style('google-opensans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext', array(), null, 'all');
		wp_enqueue_style('google-opensans');
		wp_register_style('google-robotocondensed', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext', array(), null, 'all');
		wp_enqueue_style('google-robotocondensed');		
	}
}
add_action( 'wp_enqueue_scripts', 'elektrika220_380_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/elektrika_functions.php';
require get_template_directory() . '/inc/woocommerce_functions.php';

require_once get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

add_theme_support( 'woocommerce' );

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;        
}
class UL_Class_Walker extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth=0,  $args = array()) { 
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' );
	$display_depth=(int)$depth+2;
    $output .= "\n$indent<ul class=\"level_".$display_depth."\">\n";
  }
}
/** 
 * Добавлено для возможности поиска по ID товара
 * https://www.relevanssi.com/knowledge-base/searching-post-id/ - не работает
 */
add_filter('relevanssi_custom_field_value', 'electrika_relevanssi_custom_field_value', 10, 3);
function electrika_relevanssi_custom_field_value( $value, $field, $post_id ) 
{
	if ( $field != 'id' )
		return $value;
	
	$value = str_pad( $post_id, 6, '0', STR_PAD_LEFT );
	
	// Отладка индексирования
	$logFile = $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-content/relevanssi_content_to_index.log';
	WP_DEBUG && file_put_contents( $logFile, $value . PHP_EOL, FILE_APPEND );
	
    return $value;
}