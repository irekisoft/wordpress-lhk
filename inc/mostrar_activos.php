<?php
echo '<tr>';
?>
<td style="border: 2px solid <?php echo get_option('color_borde'); ?>">
<?php
if ( !empty($atts['idioma']) ) :
	if ( $atts['idioma'] == 'es' ):
		include( plugin_dir_path( __FILE__ ) . '/es.php' );
	else:
		include( plugin_dir_path( __FILE__ ) . '/eus.php' );
	endif;
else:
	include( plugin_dir_path( __FILE__ ) . '/es.php' );
endif;


$comienzo = date("d/m/Y", strtotime($curso['fcomienzo']));
	if ($comienzo == '01/01/1000' || $comienzo == '30/11/-0001') : $fcomienzo = 'Sin especificar'; else: $fcomienzo = $comienzo ; endif;
		echo "<a target='_blank' href='".$lhk_url."/curso/".$curso['id']."/info'>";
		echo "<img src='".plugin_dir_url( dirname( __FILE__ ) ) ."img/areas/".$curso['departamento'].".gif'> <strong>".$area[$curso['departamento']]."</strong></a> &nbsp;";
		echo "<a target='_blank' class='lhk_button' href='".$lhk_url."/curso/".$curso['id']."/info'>+ INFO</a><br><hr><p>";
		echo "<div class='lhk_titulo'>".$curso['codigoReal'].' - '.mb_strtoupper($titulo, 'UTF-8')."</div>";
	if ( $curso['codigoCM'] != $curso['codigoReal'] && !empty($curso['codigoCM']) && ( $curso['tipo'] == 1 || $curso['tipo'] == 2 )) 
		echo ' ('. $curso['codigoCM'] .')';
		echo '<div class="lhk_info">';
		echo '<i class="fa fa-clock-o"></i> '.$curso['horas'].'h.';
		echo '- '.$horario.': '.$curso['horario'].'&nbsp;';
		echo '<i class="fa fa-calendar"></i>&nbsp;'.$fcomienzo.'&nbsp;';
		if ( $curso['horasDistancia'] > 0 ):
			echo '<i class="fa fa-flag"></i>&nbsp; '.$remoto.' &nbsp;';
		else: 
			echo '<i class="fa fa-flag"></i>&nbsp; '.$presencial.' &nbsp;';
		endif;
		if ( $curso['terminado'] == 1 ):
			echo '<i class="fa fa-lock"></i> cerrada';
			elseif ( $curso['terminado'] == 0 && $curso['matriculaCerrada'] == 1 ):
				echo '<i class="fa fa-lock"></i>';
			elseif ( $curso['terminado'] == 0 && $curso['matriculaCerrada'] == 0 ):
				echo 'Abierta';
	endif;
	if ( !empty($curso['precio']) ) echo ' ( '. $curso['precio']. ' € )';
	echo '</div></p>';
	//Descarga de Documentos de la web de Lanbide
    if ( $curso['tipo'] == 20 && !empty($curso['codigoReal']) ) : 
    if (substr($curso['codigoReal'],0,2) != 'UF' && substr($curso['codigoReal'],0,2) != 'MF')  :
    $url = "https://apps.lanbide.euskadi.net/descargas/egailancas/certificados/ficha/".$curso['codigoReal']."_FIR.pdf"; 
	$array = @get_headers($url); 
	$string = $array[0]; 
	if(strpos($string, "200")) : ?>
		<p class="descargas"><span class="lhk_documentos"><?php echo $documentos; ?></span>
			<a href="https://apps.lanbide.euskadi.net/descargas/<?php echo $ruta_labide; ?>/certificados/ficha/<?php echo $curso['codigoReal'];?>_FIR.pdf"><i class="fa fa-download"></i> <?php echo $ficha_resumen; ?></a>
			<a href="https://apps.lanbide.euskadi.net/descargas/<?php echo $ruta_labide; ?>/certificados/normativa/<?php echo $curso['codigoReal']; ?>_NOR.pdf"><i class="fa fa-download"></i> <?php echo $normativa; ?></a>
			<a href="https://apps.lanbide.euskadi.net/descargas/<?php echo $ruta_labide; ?>/certificados/normativa/reales_decretos/rde/<?php echo $curso['codigoReal']; ?>_RDE.pdf"><i class="fa fa-download"></i>  <?php echo $real_decreto; ?></a>
		</p>
	<?php endif;
		endif;  
	endif; 
	echo '</td>';
	echo '</tr>';
