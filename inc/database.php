<?php

//inicializa la creacion de la base de datos o tablas nuevas
  function lapizzeria_database(){
    //nos da los metodos para trabajar con tablas
    global $wpdb;
    //agregamos un version
    global $lapizzeria_dbversion;
    $lapizzeria_dbversion='1.0';
    //obtenemos el prefijo wp_
    $tabla = $wpdb->prefix.'reservaciones';
    //obtenemos el collation de la instalacion
    $charset_collate = $wpdb->get_charset_collate(); //es el cotejamiento
    //agregamos la estructura de la base de datos
    $sql = "CREATE TABLE $tabla (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nombre varchar(50) NOT NULL,
            fecha datetime NOT NULL,
            correo varchar(50) DEFAULT '' NOT NULL,
            telefono varchar(10) NOT NULL,
            mensaje longtext NOT NULL,
            PRIMARY KEY (id)
    ) $charset_collate; ";

    //se necesita dbDelta para ejecutar el SQL yesta en la siguiente direccion
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    //agregamos la version de la base de datos para compararla con futuras actualizaciones.
    add_option('lapizzeria_dbvdbersion', $lapizzeria_dbversion);

    //ACTUALIZAR EN CASO DE SER NECESARIO
    $version_actual=get_option('lapizzeria_dbversion');
    //cmparamos las dos versiones.
    if($lapizzeria_dbversion !=  $version_actual) {
        $tabla = $wpdb->prefix.'reservaciones'; // es el prefijo en este caso es wp_reservaciones

        //aqui se realiza la actulizacion
      $sql = "CREATE TABLE $tabla (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              nombre varchar(50) NOT NULL,
              fecha datetime NOT NULL,
              correo varchar(50) DEFAULT '' NOT NULL,
              telefono varchar(10) NOT NULL,
              mensaje longtext NOT NULL,
              PRIMARY KEY (id)
      ) $charset_collate; ";

      require_once(ABSPATH.'wp-admin/includes/upgrade.php');
      dbDelta($sql);
      //actualizamos a la version actual en caso de que asi sea.
      update_option('lapizzeria_dbversion', $lapizzeria_dbversion);
    }
  }
  add_action( 'after_setup_theme', 'lapizzeria_database');

//funcion para comprobar que la version instalada es igual a la base de datos nueva.
  function lapizzeriadb_revisar() {
    global $lapizzeria_dbversion;
    if(get_site_option('lapizzeria_dbversion') != $lapizzeria_dbversion) {
      lapizzeria_database();
    }
  }

  add_action('plugins_loaded', 'lapizzeriadb_revisar');

 ?>
