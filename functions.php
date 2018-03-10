<?php

//añadir recaptcha
function lapizzeria_agregar_recaptcha() { ?>
  <script src='https://www.google.com/recaptcha/api.js'></script>
<?php
}add_action( 'wp_head','lapizzeria_agregar_recaptcha');

//tablas personalizadas
  require get_template_directory().'/inc/database.php';
  //funciones para las reservaciones
  require get_template_directory().'/inc/reservaciones.php';
  //crear opciones para el template
  require get_template_directory().'/inc/opciones.php';

 function lapizzeria_setup(){
   add_theme_support('post-thumbnails');
   add_theme_support('title-tag');
   add_image_size('nosotros',390,291,true);
   add_image_size('especialidades',668,515,true);
   add_image_size('especialidades_front', 435, 526, true);

   update_option('thumbnail_size_w', 253);
   update_option('thumbnail_size_h', 164);
 }
 add_action( 'after_setup_theme', 'lapizzeria_setup');

 function  lapizzeria_custom_logo(){
   $logo= array(
     'width' =>150,
     'height'=>45
   );
   add_theme_support( 'custom-logo', $logo);
 }
 add_action( 'after_setup_theme', 'lapizzeria_custom_logo' );

 //hacer que hojas de estilo funciones en el proyecto
  function lapizzeria_styles(){
    wp_register_style('normalize', get_template_directory_uri().'/css/normalize.css', array(), '7.0.0');
    wp_register_style('google_fonts', 'https://fonts.googleapis.com/css?family=Open+Sans|Raleway:400,700,900', array(), '1.0.0 ');
    wp_register_style('fontawesome-all', get_template_directory_uri().'/css/fontawesome-all.css', array('normalize'),'5.0.6');
    wp_register_style('fluidboxcss', get_template_directory_uri().'/css/fluidbox.min.css', array('normalize'),'5.0.6');
    wp_register_style('datetime-local', get_template_directory_uri().'/css/datetime-local-polyfill.css', array('normalize'),'5.0.6');
    wp_register_style('style', get_template_directory_uri().'/style.css', array('normalize'), '1.0');


  //  wp_enqueue_script( 'fontawesome-all', get_template_directory_uri() . '/js/fontawesome-all.js', array(), '5.0.6');
    // Regisntrando scripts
  //  wp_register_script('debounce', '//cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js', array('jquery'), '1.0.0', true );
    $apikey = esc_html(get_option( 'lapizzeria_gmap_apikey'));
    wp_register_script( 'maps', 'https://maps.googleapis.com/maps/api/js?key='.$apikey.'&callback=initMap',array(), '', true );
    wp_register_script('fluidbox', get_template_directory_uri().'/js/jquery.fluidbox.min.js', array('jquery'), '1.0.0', true );
    wp_register_script('datetime-local-polyfill', get_template_directory_uri().'/js/datetime-local-polyfill.min.js', array('jquery'), '1.0.0', true );
    wp_register_script('modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js', array(), '2.8.3', true );
    wp_register_script('scripts', get_template_directory_uri().'/js/scripts.js', array(), '1.0.0', true );


    //llamar los estilos
    wp_enqueue_style('normalize');
    wp_enqueue_style('fontawesome-all');
    wp_enqueue_style('fluidboxcss');
    wp_enqueue_style('datetime-local');
    wp_enqueue_style('style');


    //llamar los scripts
    wp_enqueue_script( 'maps');
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'jquery-ui-core');
    wp_enqueue_script( 'jquery-ui-datepicker');
    wp_enqueue_script('fluidbox');
    wp_enqueue_script( 'datetime-local-polyfill');
    wp_enqueue_script( 'modernizr');
  //  wp_enqueue_script('debounce');
    wp_enqueue_script('scripts');

    //Pasar variables de php a javascript
    wp_localize_script(
      'scripts',
      'opciones',
      array(
            'latitud'=> get_option( 'lapizzeria_gmap_latitud' ),
            'longitud' => get_option('lapizzeria_gmap_longitud'),
            'zoom'=>get_option('lapizzeria_gmap_zoom')
      )
     );

  }

  add_action('wp_enqueue_scripts','lapizzeria_styles');
// me da la ruta del archivo admin-ajax.php.
  function lapizzeria_admin_scripts(){
    wp_enqueue_style( 'sweetalert', get_template_directory_uri().'/css/sweetalert2.min.css');
    wp_enqueue_script('sweetalertjs', get_template_directory_uri().'/js/sweetalert2.min.js', array('jquery'), '1.0', true );
    wp_enqueue_script( 'adminjs', get_template_directory_uri().'/js/admin-ajax.js', array('jquery'),'1.0', true );
    wp_localize_script( 'adminjs', 'url_eliminar', array('ajaxurl'=>admin_url('admin-ajax.php'))
    );
  }
  add_action( 'admin_enqueue_scripts', 'lapizzeria_admin_scripts' );

  //estilos de inicio de sesion
  function admin_styles() {
    wp_enqueue_style( 'loginCSS',get_stylesheet_directory_uri().'/css/loginStyles.css', false );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'loginJs',get_stylesheet_directory_uri().'/js/login.js',array('jquery'), '1.0.0', true );

  }add_action('login_enqueue_scripts','admin_styles',10 );


  //Agregar Async y defer
function agregar_async_defer($tag, $handle){
  if('maps' !== $handle)
    return $tag;
    return str_replace('src', 'async="async" defer="defer" src', $tag);

}
add_filter( 'script_loader_tag', 'agregar_async_defer',10,2);

//creacion de menus
  function lapizzeria_menus(){
    register_nav_menus(array(
      'header-menu'=> __('header menu','lapizzeria'),
      'social-menu'=> __('social menu','lapizzeria'),
    ));
  }
    add_action('init','lapizzeria_menus');


    add_action( 'init', 'lapizzeria_especialidades' );
    function lapizzeria_especialidades() {
    	$labels = array(
    		'name'               => _x( 'Pizzas', 'lapizzeria' ),
    		'singular_name'      => _x( 'Pizzas', 'post type singular name', 'lapizzeria' ),
    		'menu_name'          => _x( 'Pizzas', 'admin menu', 'lapizzeria' ),
    		'name_admin_bar'     => _x( 'Pizzas', 'add new on admin bar', 'lapizzeria' ),
    		'add_new'            => _x( 'Add New', 'book', 'lapizzeria' ),
    		'add_new_item'       => __( 'Add New Pizza', 'lapizzeria' ),
    		'new_item'           => __( 'New Pizzas', 'lapizzeria' ),
    		'edit_item'          => __( 'Edit Pizzas', 'lapizzeria' ),
    		'view_item'          => __( 'View Pizzas', 'lapizzeria' ),
    		'all_items'          => __( 'All Pizzas', 'lapizzeria' ),
    		'search_items'       => __( 'Search Pizzas', 'lapizzeria' ),
    		'parent_item_colon'  => __( 'Parent Pizzas:', 'lapizzeria' ),
    		'not_found'          => __( 'No Pizzases found.', 'lapizzeria' ),
    		'not_found_in_trash' => __( 'No Pizzases found in Trash.', 'lapizzeria' )
    	);

    	$args = array(
    		'labels'             => $labels,
        'description'        => __( 'Description.', 'lapizzeria' ),
    		'public'             => true,
    		'publicly_queryable' => true,
    		'show_ui'            => true,
    		'show_in_menu'       => true,
    		'query_var'          => true,
    		'rewrite'            => array( 'slug' => 'especialidades' ),
    		'capability_type'    => 'post',
    		'has_archive'        => true,
    		'hierarchical'       => false,
    		'menu_position'      => 6,
    		'supports'           => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'          => array( 'category' ),
    	);

    	register_post_type( 'especialidades', $args );
    }

    function lapizzeria_widgets(){
      register_sidebar(array(
            'name'  =>  'Blog Sidebar',
            'id'    =>  'blog_sidebar',
            'before_widget' =>  '<div class="widget">',
            'after_widget'  =>  '</div>',
            'before_title'  =>  '<h3>',
            'after_title' =>  '</h3>'
      ));
    }
    add_action('widgets_init','lapizzeria_widgets');

    /** Advanced custom field**/
    define( 'ACF_LITE', true );
    include_once('advanced-custom-fields/acf.php');

    if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_especialidades',
		'title' => 'Especialidades',
		'fields' => array (
			array (
				'key' => 'field_5a82169a65a77',
				'label' => 'precio',
				'name' => 'precio',
				'type' => 'text',
				'instructions' => 'añada un precio del platillo',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'especialidades',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_inicio',
		'title' => 'Inicio',
		'fields' => array (
			array (
				'key' => 'field_5a998d643e8e4',
				'label' => 'Contenido',
				'name' => 'contenido',
				'type' => 'wysiwyg',
				'instructions' => 'Argue su contenido',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_5a998d803e8e5',
				'label' => 'Imagen',
				'name' => 'imagen',
				'type' => 'image',
				'instructions' => 'agregue Imagen',
				'save_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page',
					'operator' => '==',
					'value' => '5',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_sobre-nosotros',
		'title' => 'Sobre Nosotros',
		'fields' => array (
			array (
				'key' => 'field_5a81994dee60a',
				'label' => 'imagen 1',
				'name' => 'imagen_1',
				'type' => 'image',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_5a8199b3ee60d',
				'label' => 'descripcion 1',
				'name' => 'descripcion_1',
				'type' => 'wysiwyg',
				'instructions' => 'ingre su texto',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_5a819988ee60b',
				'label' => 'imagen 2',
				'name' => 'imagen_2',
				'type' => 'image',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_5a819a4bee60e',
				'label' => 'descripcion 2',
				'name' => 'descripcion_2',
				'type' => 'wysiwyg',
				'instructions' => 'ingrese su texto',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_5a81999eee60c',
				'label' => 'imagen 3',
				'name' => 'imagen_3',
				'type' => 'image',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_5a819a66ee60f',
				'label' => 'descripcion 3',
				'name' => 'descripcion_3',
				'type' => 'wysiwyg',
				'instructions' => 'ingrese su texto',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page',
					'operator' => '==',
					'value' => '9',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}


 ?>
