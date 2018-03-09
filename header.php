<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="La Pizzeria">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.jpg">

    <meta name="mobile-we-app-capable" content="yes">
    <meta name="theme-color" content="#a61206">
    <meta name="application-name" content="La pizzeria">
    <link rel="icon" type="image/png"href="<?php echo get_template_directory_uri(); ?>/icono.png" sizes="192x192">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class() ?>>


    <header class="encabezado-sitio">
      <div class="contenedor">
        <div class="logo">
         <a href="<?php echo esc_url(home_url('/')); ?>">
          <?php
              if(function_exists('the_custom_logo')){
                the_custom_logo();
              }
           ?>
         </a>
       </div><!-- Logo -->

       <!-- Imprimiendo menus de las redes sociales -->
       <div class="informacion-encabezado">
         <div class="redes-sociales">
           <?php
            $args=array(
                'theme_location'=>'social-menu',
                'container'=>'nav',
                'container_class'=>'sociales',
                'container_id'=>'sociales',
                'link_before'=>'<span class=sr-text>',
                'link_after'=>'</span>'
            );
            /*pidiendo a wordpress que me imprima el menu social-menu dentro de un nav, con un container_class
              llamando menu-social, un container-id menu-social y donde cada item este dentro de la clase sr-text
              es una clase especial en dispositvos para persona con problemas visuales.*/
            wp_nav_menu( $args );
           ?>
         </div>
         <div class="direccion">
           <p><?php echo esc_html( get_option('lapizzeria_direccion') ); ?></P>
           <p>Telefono : <?php echo  esc_html( get_option('lapizzeria_telefono') ); ?></P>
         </div>
       </div>

     </div> <!--contenedor-->
    </header>

    <!-- Imprimiendo Menus -->
    <div class="menu-principal">
      <div class="mobile-menu">
        <a href="#" class="mobile"><i class="fas fa-align-justify"></i> Menu</a>
      </div>

      <div class="contenedor navegacion">
        <?php
          $args=array(
            'theme_location'=>'header-menu',
            'container'=>'nav',
            'container_class'=>'menu-sitio'
          );

          wp_nav_menu( $args );
         ?>
      </div>
    </div>
