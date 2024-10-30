<?php


/*
Plugin Name: Contenido del dia
Plugin URI: https://wordpress.org/plugins/contenido-del-dia/
Description: Muestra el contenido del día que incluye: imagen del día cualquier palabra en varias versiones de la Biblia, con la mas potente concordancia del mundo desde BibliaTodo.com
Version: 2.3
Author: Bibliatodo.com
Author URI: https://www.bibliatodo.com
License: GPL2
  Copyright 2017  BibliaTodo.com  (email : bibliatodo1@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function cdd_contenido_funcion_del_dia($showlink, $language) {
	if($language == 'en'){
		$languageUrl = 'https://www.bibliatodo.com/assets/js/wordpress/es/widget-contenido-dia.js';
	}
	else{
		$languageUrl = 'https://www.bibliatodo.com/assets/js/wordpress/es/widget-contenido-dia.js';
	}
	
	$html = '<div>';
	$html .= '<script type="text/javascript" language="javascript" src="'.$languageUrl.'"></script>';
	/*if ($showlink == 1){
		$html .= '<p style="text-align: center;"><a href="https://www.bibliatodo.com/recursos/" target="_blank">Agrega esto a tu Sitio Web</a></p>';
	}*/
	$html .= '</div>';
	return $html;
}

add_shortcode('cdd_contenidodeldia', 'cdd_contenido_funcion_del_dia');

class cdd_contenidodeldiaWidget extends WP_Widget
{
	function __construct()
	{
		parent::__construct('cdd_contenidodeldiaWidget', __('Contenido del día', 'cdd_contenidodeldia' ), array ('description' => __( 'Este plugin muestra el contenido del dia que incluye: la imagen del dia, consejo del día, el video, la reflexión el versículo del día, por Bibliatodo.com', 'cdd_contenidodeldia')));
	}
	function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Contenido del día', 'showlink' => '1', 'language' => 'es' ) );
		$title = $instance['title'];
		$showlink = $instance['showlink'];
		$language = $instance['language'];
?>

<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="ddlb_widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo
$this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

<p><select id="<?php echo $this->get_field_id('language'); ?>" name="<?php echo $this->get_field_name('language'); ?>">

<option value="es" <?php _e($language == '' || $language == 'es' ? 'selected' : ''); ?>>Español</option>
<!--<option value="en" <?php _e($language == 'en' ? 'selected' : ''); ?>>Ingles</option>-->

</select></p>

<p><input id="<?php echo $this->get_field_id('showlink'); ?>" name="<?php echo $this->get_field_name('showlink'); ?>" type="checkbox" value="1" <?php checked( '1',
$showlink ); ?>/><label for="<?php echo $this->get_field_id('showlink'); ?>"><?php _e('&nbsp;Show link to BibliaTodo.com (thank you!)'); ?></label></p>

<?php
	}
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		if($new_instance['showlink'] == '1')
		{
			$instance['showlink'] = '1';
		}
		else
		{
			$instance['showlink'] = '0';
		}
		$instance['language'] = $new_instance['language'];
		return $instance;
	}
	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		if (!empty($title))
			echo $before_title . $title . $after_title;;
		$showlink = $instance['showlink'];
		$language = $instance['language'];
		echo cdd_contenido_funcion_del_dia($showlink, $language);
		echo $after_widget;
	}
}

add_action( 'widgets_init', create_function('', 'return register_widget("cdd_contenidodeldiaWidget");') );

?>