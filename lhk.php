<?php
/**
 * @package LHK
 * @version 1.0
 */
/*
Plugin Name: LHK
Plugin URI: https://www.lanheziketa.com/
Description: Integración de la aplicación para la formación continua LHK en Wordpress.
Author: Irekisoft
Version: 1.0
Author URI: https://www.irekisoft.net/
*/

function lhk_register_options_page() {
	add_options_page('LHK plugin by Irekisoft', 'LHK', 'manage_options', 'lhk', 'lhk_options_page');
	/* Registro de los campos */
	register_setting( 'lhk_options_group', 'lhk_url' );
	register_setting( 'lhk_options_group', 'mostrar_cerrados' );
	register_setting( 'lhk_options_group', 'mostrar_titulos_convocatoria' );
	register_setting( 'lhk_options_group', 'color_borde' );
	register_setting( 'lhk_options_group', 'lhk_idioma' );
}
add_action('admin_menu', 'lhk_register_options_page');

function lhk_options_page()
{
?>
  <div>
  <h2><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'lhk/img/logo.png'; ?>"><br>Lan heziketa Kudeaketa : Irekisoft </h2>
  <form method="post" action="options.php">
  <?php 
	settings_fields( 'lhk_options_group' ); 
	do_settings_sections( 'lhk_options_group' );
	?>
  <p>Opciones de configuraci&oacute;n sobre los cursos de formaci&oacute;n continua dados de alta en la aplicaci&oacute;n.</p>
  <p>
  <strong>Como se utiliza:</strong><br>Para mostrar los cursos tan solo debemos de añadir a una pagina el siguiente shortcode [lhk]<br>
  Las opciones que se le pueden pasar son "convocatoria" e "idioma ['eu']". <br>
  En caso de querer mostrar una convocatoria concreta se haria de la siguiente manera [lhk convocatoria='13'] 
  </p>
  <hr>
  <p><label for="lhk_url">URL de la aplicaci&oacute;n:</label>
  <input type="text" id="lhk_url" placeholder="https://" name="lhk_url" size="50" value="<?php echo get_option('lhk_url'); ?>" />
  </p>
  <input type="checkbox" id="mostrar_cerrados" value="1" name="mostrar_cerrados" <?php echo ( get_option('mostrar_cerrados') == 1  ) ? "checked" : ""; ?>> Ocultar cursos cerrados</label>
  <br>
  <input type="checkbox" id="mostrar_titulos_convocatoria" value="1" name="mostrar_titulos_convocatoria" <?php echo ( get_option('mostrar_titulos_convocatoria') == 1  ) ? "checked" : ""; ?>> Ocultar titulos de las convocatorias</label>
  <br><br>
  <label for="favcolor">Pincha para seleccionar un color para el borde de la tabla:</label>
  <input type="color" id="color_borde" name="color_borde" value="<?php echo get_option('color_borde'); ?>">
  <p><b>Nota:</b> la selección de color no estan soportada en navegadores Internet Explorer 11 o Safari 9.1 (o anteriores).</p>
  <?php  submit_button(); ?>  
  </form>
  </div>
<?php
}


function obtener_url($atts) {
ob_start();
wp_enqueue_style( 'lhk', plugin_dir_url( dirname( __FILE__ ) ) . 'lhk/css/lhk.css', false, '1.0.0', 'all');
wp_enqueue_style( 'font-awesome.min', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

$lhk_url = get_option( 'lhk_url' ); 

extract( shortcode_atts( array(
  'convocatoria' => 'all', 'idioma' => 'es'),
$atts ) );


if ( !empty($atts) ) :
	
	$convocatoria_key = array_search('convocatoria', $atts);
 
	if( is_int($convocatoria_key) ) :
		if ( $atts['convocatoria'] == 'all' ):
			$json_url = $lhk_url.'/indice/'.$atts['convocatoria'].'/json?lang=es_ES';
		else :
			$json_url = $lhk_url.'/indice/convocatoria/'.$atts['convocatoria'].'/json?lang=es_ES';
		endif;
	else:
		$json_url = $lhk_url.'/indice/all/json?lang=es_ES';
	endif;
else:
	$json_url = $lhk_url.'/indice/all/json?lang=es_ES';
endif;



$areas = ['1'=>'ADMINISTRACION Y GESTION', '2'=>'ACTIVIDADES FÍSICAS Y DEPORTIVAS','3'=>'AGRARIA','4'=>'ARTES GRÁFICAS','5'=>'ARTES Y ARTESANIAS','6'=>'COMERCIO Y MARKETING','7'=>'EDIFICACIÓN Y OBRA CIVIL','8'=>'ELECTRICIDAD Y ELECTRÓNICA','9'=>'ENERGÍA Y AGUA','10'=>'FABRICACIÓN MECÁNICA','11'=>'HOSTELERIA Y TURISMO','12'=>'INDUSTRIAS EXTRACTIVAS','13'=>'INFORMÁTICA Y COMUNICACIONES','14'=>'INSTALACIÓN Y MANTENIMIENTO','15'=>'IMAGEN PERSONAL','16'=>'IMAGEN Y SONIDO','17'=>'INDUSTRIAS ALIMENTARIAS','18'=>'MADERA, MUEBLE Y CORCHO','19'=>'MARÍTIMO-PESQUERA','20'=>'QUÍMICA','21'=>'SANIDAD','22'=>'SEGURIDAD Y MEDIO AMBIENTE','23'=>'SERVICIOS SOCIOCULTURALES Y A LA COMUNIDAD','24'=>'TEXTIL, CONFECCIÓN Y PIEL','25'=>'TRANSPORTE Y MANTENIMIENTO DE VEHÍCULOS','26'=>'VIDRIO Y CERÁMICA','27'=>'FORMACIÓN COMPLEMENTARIA'];
$areas_eus = ['1'=>'ADMINISTRAZIOA ETA KUDEAKETA', '2'=>'JARDUERA FISIKOAK ETA KIROLAK','3'=>'NEKAZARITZA','4'=>'ARTE GRAFIKOAK','5'=>'ARTEAK ETA ESKULANGINTZAK','6'=>'MERKATARITZA ETA MARKETINA','7'=>'ERAIKUNTZA ETA OBRA ZIBILA','8'=>'ELEKTRIZITATEA ETA ELEKTRONIKA','9'=>'ENERGIA ETA URA','10'=>'FABRIKAZIO MEKANIKOA','11'=>'OSTALARITZA ETA TURISMOA','12'=>'ERAUSKETA INDUSTRIAK','13'=>'INFORMATIKA ETA KOMUNIKAZIOAK','14'=>'INSTALATZE ETA MANTENTZE LANAK','15'=>'IRUDI PERTSONALA','16'=>'IRUDIA ETA SOINUA','17'=>'ELIKAGAIEN INDUSTRIAK','18'=>'ZURGINTZA, ALTZARIGINTZA ETA KORTXOA','19'=>'ITSASOA ETA ARRANTZA','20'=>'KIMIKA','21'=>'OSASUNA','22'=>'SEGURTASUNA ETA INGURUMENA','23'=>'GIZARTE ETA KULTUR ZERBITZUAK','24'=>'EHUNGINTZA JANTZIGINTZA ETA LARRUGINTZA','25'=>'GARRAIOA ETA IBILGAILUEN MANTENTZE LANAK','26'=>'BEIRA ETA ZERAMIKA','27'=>'HEZIKETA OSAGARRIA'];
$contenido = file_get_contents($json_url);
$decode = json_decode ($contenido,true);
$mostrar_cerrados = get_option( 'mostrar_cerrados' );
$mostrar_titulos_convocatoria = get_option( 'mostrar_titulos_convocatoria' );


$fecha_actual = strtotime(date("d-m-Y H:i:00",time()));

if ( $mostrar_titulos_convocatoria == 1 ):
echo "";
else:
	echo "<div class='lhk_alert lhk_alert-info' role='alert'>";	
	if ( !empty($atts['convocatoria']) ) :
		if ( $atts['convocatoria'] != 'all' ):
			echo "<span class='lhk_alert-link'>".$decode[0]['convocatorias_titulo']."</span>";
		else:
			echo "CURSOS DE FORMACI&Oacute;N CONTINUA";
		endif;
	else :
		echo "CURSOS DE FORMACI&Oacute;N CONTINUA";
	endif;
	echo "</div>";
endif;
echo "<table class='table table-condensed'>";
echo "<tbody>";


if ( $mostrar_cerrados == 1 )  :

	foreach ($decode as $curso) :
		if($curso['terminado'] == 1) :
			require( plugin_dir_path( __FILE__ ) . '/inc/mostrar_activos.php' );
		endif; 
	endforeach;
wp_reset_postdata();
else :
	foreach ($decode as $curso) :
			require( plugin_dir_path( __FILE__ ) . '/inc/mostrar_todos.php' );
	endforeach;
wp_reset_postdata();

endif; 
echo "</tbody>";
echo "</table>";
return ob_get_clean();
}

add_shortcode('lhk', 'obtener_url');
