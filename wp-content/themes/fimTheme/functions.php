<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}


add_theme_support( 'post-thumbnails' );
add_image_size( 'foto', 300,	9999,	true	);
add_image_size( 'foto1', 500,	400,	true	);

function template_chooser($template){
	global $wp_query;
	$post_type = get_query_var('post_type');
	if( $wp_query->is_search && $post_type == 'tatuador' ){
		return locate_template('search-tatuador.php');
	}

	if( $wp_query->is_search && $post_type == 'inspiracao' ){
		return locate_template('search-inspiracao.php');
	}
	return $template;
}
add_filter('template_include', 'template_chooser'); 

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyfifteen
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen' );

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
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	/*
	 * Enable support for custom logo.
	 *
	 * @since Twenty Fifteen 1.5
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 248,
		'width'       => 248,
		'flex-height' => true,
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';

function lista_posts_home(){
	$posts = new WP_Query( array(
		'post_type'				=> 'inspiracao',
		'order'					=> 'DESC',
		// 'offset'				=> $remove,
		'posts_per_page'		=> 20
	));

	if( $posts->have_posts() ) {
	// echo '<ul class="grid-lod effect-2" id="grid">';
		while( $posts->have_posts() ) {
			$posts->the_post();
			$link 					= types_render_field( "link-do-tatuador", array('output' => 'raw')  );
			$titulo					= get_the_title();
			$categorias				= get_the_category($posts->ID);
			$Data					= get_the_date('d-m-Y');
			$tatuador				= types_render_field( "tatuador");

			$asasassa = "";

			foreach( $categorias as $category ) {
				$asasassa .= '<button onClick= goToSection("'. get_site_url() . '/category/' . $category->slug .'")><span>' . $category->name . '</span></button>';
			}

			echo do_shortcode('[ajax_load_more post_type="inspiracao" post_format="image"]');

			echo '<div class="item medium grid">'; 
					// echo '<a class="fancy" href="' . get_the_post_thumbnail_url() . '" title="Título: <span>'. $titulo .'</span><br/> Tatuador:  <span>'. $tatuador . '</span><br/>Tags:  <p></p>">';
					echo '<a class="fancy" href="' . get_the_post_thumbnail_url() . '" title="'. $titulo . '">';
						echo '<figure class="effect-oscar">';
							if( has_post_thumbnail() ) {
								echo get_the_post_thumbnail( get_the_ID(), 'foto1', array( 'alt' => get_the_title(), 'title' => get_the_title(),  'class' => 'img-responsive' ) );
							} else {
								echo '<img src="' . get_bloginfo( 'template_directory' ) . '/images/img-sliderG.jpg" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
							}
						echo '<figcaption>';
							echo '<h2 class="oswald-bold">' .  $titulo  . '</h2>';
							// echo '<p class="author oswald-light"><button onclick="window.location.href=" (' .$link.')   ">Tatuador:' . $tatuador . '</button></p>';
							echo '<p class="author oswald-light"><button onClick= goToPage("' . $link. '")>Tatuador:' . $tatuador . '</button></p>';



							// echo '<p style="display:none"></p>';
							echo '<p class="tags oswald-light">Tags:';
								echo $asasassa;
							echo '</p>';
							echo '<p class="date oswald-light"> ' . $Data . '</p>';
						echo '</figcaption>';
							
						echo '</figure>';
					echo '</a>';

					
		echo '</div>';
		}
	} else {
		echo "nenhum post encontrado";
	}

	wp_reset_postdata();
}


function lista_posts($remove){
	$posts = new WP_Query( array(
		'post_type'				=> 'inspiracao',
		'order'					=> 'ASC',
		'offset'				=> $remove,
		'posts_per_page'		=> 10
	));

	if( $posts->have_posts() ) {
			echo '<ul class="grid-lod effect-2" id="grid">';
				while( $posts->have_posts() ) {
					$posts->the_post();
					$titulo					= get_the_title();
					$categorias				= get_the_category($posts->ID);
					$Data					= get_the_date('Y-m-d');
					$tatuador				= types_render_field( "tatuador" );
					$aqui					= 'as';

					$asasassa = "";

					foreach( $categorias as $category ) {
						$asasassa .= '<button href="'. get_site_url() . '/category/' . $category->slug .'"><span>' . $category->name . '</span></button>';
					}

					echo '<li>'; 
						echo '<a class="fancy" href="' . get_the_post_thumbnail_url() . '" title="Título: <span>'. $titulo .'</span><br/> Tatuador:  <span>'. $tatuador . '</span><br/>Tags:  <p></p>">';
							echo '<figure class="effect-oscar">';
								if( has_post_thumbnail() ) {
									echo get_the_post_thumbnail( get_the_ID(), 'foto1', array( 'alt' => get_the_title(), 'title' => get_the_title(),  'class' => 'img-responsive',  ) );
								} else {
									echo '<img src="' . get_bloginfo( 'template_directory' ) . '/images/img-sliderG.jpg" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
								}

								echo '<figcaption>';
									echo '<h2 class="oswald-bold">' .  $titulo  . '</h2>';
									echo '<p class="author oswald-light">Tatuador:' . $tatuador . '</p>';
									echo '<p class="tags oswald-light">Tags:';
										echo $asasassa;
									echo '</p>';
									echo '<p class="date oswald-light"> ' . $Data . '</p>';
								echo '</figcaption>';

							echo '</figure>';
						echo '</a>';
							
				echo '</li>';
				}
			echo '</ul>';
	} else {
		echo "nenhum post encontrado";
	}

	wp_reset_postdata();
}

function lista_blog(){
	$posts = new WP_Query( array(
		'post_type'				=> 'post',
		'order'					=> 'DESC',
		'posts_per_page'		=> 10
	));

	if( $posts->have_posts() ) {
		echo '<div class="row">';

		while( $posts->have_posts() ) {
			$index++;
			$posts->the_post();
			$titulo					= get_the_title();
			$resume 				= get_the_excerpt();
			$image 					= get_the_post_thumbnail();
			$categorias				= get_the_category($posts->ID);
			$dia					= get_the_date('j');
			$mes 					= get_the_date('F');
			$ano 					= get_the_date('Y');
			

			if(($index % 2) == 1){
				echo '</div><div class="row">';
			}
			echo '<section class="col-xs-12 col-sm-6 padding-top">';
					echo '<article class="blog-article">';
						echo '<figure>';
							echo '<div class="data">';
								echo '<p class="oswald-bold">' . $dia . '</p>';
								echo '<p class="oswald">'. $mes . '  ' . $ano .'</p>';
							echo '</div>';
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail( get_the_ID(), 'foto1', array( 'alt' => get_the_title(), 'title' => get_the_title(),  'class' => 'img-responsive',  ) );
									} else {
										echo '<img src="' . get_bloginfo( 'template_directory' ) . '/images/img-sliderG.jpg" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
									} 
			    			
		    			echo '</figure>';

		    			echo '<div class="container-text">';
		    				echo '<h2 class="oswald-bold">' . $titulo . '</h2>';
		    				echo '<p>'. $resume .'</p>';
		    				echo '<a href="'. get_permalink( get_the_ID() ) .'" class="oswald">Leia mais [+]</a>';
		    			echo '</div>';
					echo '</article>';
			echo '</section>';

		
		}

	} else {
		echo "nenhum post encontrado";
	}

	wp_reset_postdata();
}
function lista_artistas(){
	$posts = new WP_Query( array(
		'post_type'				=> 'tatuador',
		'order'					=> 'DESC',
		'posts_per_page'		=> 10
	));

	echo '<div class="row">';

	if( $posts->have_posts() ) {
		while( $posts->have_posts() ) {
			$posts->the_post();
			$titulo					= get_the_title();
			$resume 				= get_the_excerpt($posts->ID);
			$image 					= get_the_post_thumbnail();
			$categorias				= get_the_category($posts->ID);
			$dia					= get_the_date('j');
			$mes 					= get_the_date('F');
			$ano 					= get_the_date('Y');

			if(($index % 2) == 1){
				echo '</div><div class="row">';
			}
				
			echo '<section class="col-xs-12 col-sm-6 padding-top">';
				echo '<article class="blog-article">';
					echo '<figure>';
						echo '<div class="data">';
							echo '<p class="oswald-bold">' . $dia . '</p>';
							echo '<p class="oswald">'. $mes . '  ' . $ano .'</p>';
						echo '</div>';
								if( has_post_thumbnail() ) {
									echo get_the_post_thumbnail( get_the_ID(), 'foto1', array( 'alt' => get_the_title(), 'title' => get_the_title(),  'class' => 'img-responsive',  ) );
								} else {
									echo '<img src="' . get_bloginfo( 'template_directory' ) . '/images/img-sliderG.jpg" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
								} 
		    			
	    			echo '</figure>';

	    			echo '<div class="container-text">';
	    				echo '<h2 class="oswald-bold">' . $titulo . '</h2>';
	    				echo '<p>'. $resume .'</p>';
	    				echo '<a href="'. get_permalink( get_the_ID() ) .'" class="oswald">Leia mais [+]</a>';
	    			echo '</div>';
				echo '</article>';
			echo '</section>';
		}

	} else {
		echo "nenhum post encontrado";
	}

	wp_reset_postdata();
}

function lista_taboo(){
	$posts = new WP_Query( array(
		'post_type'				=> 'itemtaboo',
		'order'					=> 'DESC',
		'posts_per_page'		=> 10
	));

	echo '<div class="row">';

	if( $posts->have_posts() ) {
		while( $posts->have_posts() ) {
			$posts->the_post();
			$titulo					= get_the_title();
			$resume 				= get_the_excerpt($posts->ID);
			$image 					= get_the_post_thumbnail();
			$categorias				= get_the_category($posts->ID);
			$dia					= get_the_date('j');
			$mes 					= get_the_date('F');
			$ano 					= get_the_date('Y');

			if(($index % 2) == 1){
				echo '</div><div class="row">';
			}
				
			echo '<section class="col-xs-12 col-sm-6 padding-top">';
				echo '<article class="blog-article">';
					echo '<figure>';
						echo '<div class="data">';
							echo '<p class="oswald-bold">' . $dia . '</p>';
							echo '<p class="oswald">'. $mes . '  ' . $ano .'</p>';
						echo '</div>';
								if( has_post_thumbnail() ) {
									echo get_the_post_thumbnail( get_the_ID(), 'foto1', array( 'alt' => get_the_title(), 'title' => get_the_title(),  'class' => 'img-responsive',  ) );
								} else {
									echo '<img src="' . get_bloginfo( 'template_directory' ) . '/images/img-sliderG.jpg" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
								} 
		    			
	    			echo '</figure>';

	    			echo '<div class="container-text">';
	    				echo '<h2 class="oswald-bold">' . $titulo . '</h2>';
	    				echo '<p>'. $resume .'</p>';
	    				echo '<a href="'. get_permalink( get_the_ID() ) .'" class="oswald">Leia mais [+]</a>';
	    			echo '</div>';
				echo '</article>';
			echo '</section>';
		}

	} else {
		echo "nenhum post encontrado";
	}

	wp_reset_postdata();
}

function post_relacionados($postID, $postTax){
	$convertArray = explode(',', $postTax);

	$posts = new WP_Query( array(
		'post_type'				=> 'tatuador',
		'order'					=> 'ASC',
		'posts_per_page'		=> 2,
		'post__not_in' => array($postID),
		'tax_query' => array(
			array(
				'taxonomy' => 'estilo',
				'field'    => 'term_id',
				'terms'    => $convertArray
			),
		)
	));


	if( $posts->have_posts() ) {
		while( $posts->have_posts() ) {
			$posts->the_post();
			$titulo					= get_the_title();
			$image 					= get_the_post_thumbnail();
			
			echo '<div class="posts-relacionados">';
				echo '<div class="container-posts box">';

					echo '<a href="'. get_permalink( get_the_ID() ) .'" class="oswald">';
						if( has_post_thumbnail() ) {
							echo get_the_post_thumbnail( get_the_ID(), 'foto1', array( 'alt' => get_the_title(), 'title' => get_the_title(),  'class' => 'img-responsive',  ) );
						} else {
							echo '<img src="' . get_bloginfo( 'template_directory' ) . '/images/img-sliderG.jpg" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
						}
				

						echo '<span class="caption full-caption">';
							echo '<h3>' . get_the_title() . '</h3>';
						echo '</span>';
					echo '</a>';
				echo '</div>';
			echo '</div>';
		}

	} else {
		echo "nenhum post encontrado";
	}

	wp_reset_postdata();
}

