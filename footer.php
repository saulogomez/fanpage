
  <footer>
    <?php
      $args = array(
        'theme_location' => 'header-menu',
        'container' => 'nav',
        'after' => '<span class="separador">|</span>'
       );
       wp_nav_menu( $args );
     ?>

     <div class="ubicacion">
       <p><?php echo esc_html( get_option('lapizzeria_direccion')); ?></P>
       <p>Teléfono: <?php echo  esc_html( get_option('lapizzeria_telefono')); ?></P>
         <p class="copyright"> Todos los derechos reservados <?php echo date('Y'); ?></p>
     </div>

  </footer>

  <?php
      wp_footer();
    ?>
  </body>
</html>
