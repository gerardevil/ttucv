<?php
require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

class gocarouselboot extends WP_Widget {
 
	function __construct(){
		$widget_ops = array('classname' => 'gocaroboot_widget', 'description' => __('All photos in a gallery are displayed in the Bootstrap Carousel 2.x or 3.x . We recommend that the pictures are of good quality.','gocarousel') );
		$this->WP_Widget('gocarouselboot', __('Widget Bootstrap Carousel using Gallery Netxgen','gocarousel'), $widget_ops);
	}
 
	function widget($args,$instance){
		echo $before_widget;
	
		//$array_image_url = explode("\n",$instance['gocaro_url']);
		global $wpdb;
		$table_pictures_netxgen = $wpdb->prefix.'ngg_pictures';
		$table_gallery_netxgen = $wpdb->prefix.'ngg_gallery';
		
		if ( is_plugin_active( 'nextgen-gallery/nggallery.php' )  && $wpdb->get_var("SHOW TABLES LIKE '$table_pictures_netxgen'") == $table_pictures_netxgen ) {
		
			$array_pictures_title = explode("\n",$instance['gocaroboot_title']);
			$array_pictures_url = $wpdb->get_col('SELECT filename FROM '.$table_pictures_netxgen.' WHERE galleryid="'.$instance['gocaroboot_gallery'].'"');
			$path_gallery = $wpdb->get_var('SELECT path FROM '.$table_gallery_netxgen.' WHERE gid="'.$instance['gocaroboot_gallery'].'"');
			
			$icon_prev = $instance['gocaroboot_version']=='3'?'<span class="glyphicon glyphicon-chevron-left"></span>':'&lsaquo;';
			$icon_next = $instance['gocaroboot_version']=='3'?'<span class="glyphicon glyphicon-chevron-right"></span>':'&rsaquo;';
		
			if(is_array($array_pictures_url) && count($array_pictures_url)>0) {
				$i=0; $html_carousel=$html_slide='';
				foreach($array_pictures_url as $picture_url) {
					$class=$i==0?'active':'';
				
					$html_slide.= '<li data-target="#'.$instance['gocaroboot_id'].'" data-slide-to="'.$i.'" class="'.$class.'"></li>'."\n";
				
					$html_carousel.= '<div class="'.$class.' item">'."\n".'
									<img src="'.site_url($path_gallery.'/'.$picture_url).'" alt="'.$array_pictures_title[$i].'" title="'.$array_pictures_title[$i].'" />'."\n".'
									<div class="carousel-caption">'."\n".'
										<h4>'.$array_pictures_title[$i].'</h4>'."\n".'
									</div>'."\n".'
								</div>'."\n";
					$i++;
				}

				echo '<div id="'.$instance['gocaroboot_id'].'" class="carousel slide" data-interval="'.$instance['gocaroboot_speed'].'" data-ride="carousel">'."\n".'
					<ol class="carousel-indicators">'."\n".'
						'.$html_slide.'
					</ol>'."\n".'
					<!-- Carousel items -->'."\n".'
					<div class="carousel-inner">'."\n".'
						'.$html_carousel.'
					</div>'."\n".'
					<!-- Carousel nav -->'."\n".'
					<a class="carousel-control left" href="#'.$instance['gocaroboot_id'].'" data-slide="prev">'.$icon_prev.'</a>'."\n".'
					<a class="carousel-control right" href="#'.$instance['gocaroboot_id'].'" data-slide="next">'.$icon_next.'</a>'."\n".'
				</div>';
			}
		} else {
			echo '<h3>'.sprintf(__('I am sorry, you do not have activated the plugin NextGen Gallery or maybe the table %s not does exists','gocarousel'), $table_pictures_netxgen).'</h3>';
		}
		echo $after_widget;
	}
 
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		update_option('gocaroboot_head', $new_instance['gocaroboot_head']);
		update_option('gocaroboot_version', $new_instance['gocaroboot_version']);
		
		$instance['gocaroboot_head'] = strip_tags($new_instance['gocaroboot_head']);
		$instance['gocaroboot_version'] = strip_tags($new_instance['gocaroboot_version']);
		$instance['gocaroboot_gallery'] = strip_tags($new_instance['gocaroboot_gallery']);
		$instance['gocaroboot_title'] = strip_tags($new_instance['gocaroboot_title']);
		$instance['gocaroboot_speed'] = strip_tags($new_instance['gocaroboot_speed']);
		$instance['gocaroboot_id'] = strip_tags($new_instance['gocaroboot_id']);
        return $instance; 
	}
 
	function form($instance){
		global $wpdb;
		
		$table_gallery_netxgen = $wpdb->prefix.'ngg_gallery';
		if ( is_plugin_active( 'nextgen-gallery/nggallery.php' )  && $wpdb->get_var("SHOW TABLES LIKE '$table_gallery_netxgen'") == $table_gallery_netxgen ) {
			
			$data_gallery_nextgen = $wpdb->get_results('SELECT gid,title FROM '.$table_gallery_netxgen);
			$checked_head = esc_attr($instance['gocaroboot_head'])==1?'CHECKED':'';
			$checked_v2 = esc_attr($instance['gocaroboot_version'])==2?'CHECKED':'';
			$checked_v3 = esc_attr($instance['gocaroboot_version'])==3?'CHECKED':'';
			
			$option_gallery='';
			foreach($data_gallery_nextgen as $gallery_nextgen) {
				$selected = $gallery_nextgen->gid==$instance['gocaroboot_gallery']?'SELECTED':'';
				$option_gallery.='<option value="'.$gallery_nextgen->gid.'" '.$selected.'>'.$gallery_nextgen->title.'</option>';
			}
			
			echo '<p>
				<label for="'.$this->get_field_id('gocaroboot_head').'">
				<input type="checkbox" id="'.$this->get_field_id('gocaroboot_head').'" name="'.$this->get_field_name('gocaroboot_head').'" value="1" '.$checked_head.' />
				'.__('Include Bootstrap libraries in the head','gocarousel').'</label>
			</p>
			<p>
				<label for="'.$this->get_field_id('gocaroboot_version').'">'.__('The structure of carousel must match with bootstrap version: ','gocarousel').'</label>
				<label for="'.$this->get_field_id('gocaroboot_version').'-2">2.x <input type="radio" id="'.$this->get_field_id('gocaroboot_version').'-2" name="'.$this->get_field_name('gocaroboot_version').'" value="2" '.$checked_v2.' /></label>
				<label for="'.$this->get_field_id('gocaroboot_version').'-3">3.x <input type="radio" id="'.$this->get_field_id('gocaroboot_version').'-3" name="'.$this->get_field_name('gocaroboot_version').'" value="3" '.$checked_v3.' /></label>
			</p>
			<p>
				<label for="'.$this->get_field_id('gocaroboot_id').'">'.__('Carousel ID','gocarousel').'</label>
				#<input type="text" class="widefat" id="'.$this->get_field_id('gocaroboot_id').'" name="'.$this->get_field_name('gocaroboot_id').'" value="'.esc_attr($instance['gocaroboot_id']).'" />
			</p>
			<p>
				<label for="'.$this->get_field_id('gocaroboot_speed').'">'.__('Speed of Carousel (Recommended: 3 sec)','gocarousel').'</label>
				<select class="widefat" id="'.$this->get_field_id('gocaroboot_speed').'" name="'.$this->get_field_name('gocaroboot_speed').'">
					<option value="1000" '.(isset($instance['gocaroboot_speed'])&&$instance['gocaroboot_speed']==1000?'SELECTED':'').'>'.__('1 Sec','gocarousel').'</option>
					<option value="2000" '.(isset($instance['gocaroboot_speed'])&&$instance['gocaroboot_speed']==2000?'SELECTED':'').'>'.__('2 Sec','gocarousel').'</option>
					<option value="3000" '.(isset($instance['gocaroboot_speed'])&&$instance['gocaroboot_speed']==3000?'SELECTED':'').'>'.__('3 Sec','gocarousel').'</option>
					<option value="4000" '.(isset($instance['gocaroboot_speed'])&&$instance['gocaroboot_speed']==4000?'SELECTED':'').'>'.__('4 Sec','gocarousel').'</option>
					<option value="5000" '.(isset($instance['gocaroboot_speed'])&&$instance['gocaroboot_speed']==5000?'SELECTED':'').'>'.__('5 Sec','gocarousel').'</option>
					<option value="8000" '.(isset($instance['gocaroboot_speed'])&&$instance['gocaroboot_speed']==8000?'SELECTED':'').'>'.__('8 Sec','gocarousel').'</option>
					<option value="10000" '.(isset($instance['gocaroboot_speed'])&&$instance['gocaroboot_speed']==10000?'SELECTED':'').'>'.__('10 Sec','gocarousel').'</option>
				</select>
			</p>
			<p>
				<label for="'.$this->get_field_id('gocaroboot_gallery').'">'.__('Choose the Nextgen Gallery (all photos in this gallery are displayed in the Bootstrap Carousel)','gocarousel').'</label>
				<select name="'.$this->get_field_name('gocaroboot_gallery').'" id="'.$this->get_field_id('gocaroboot_gallery').'">'.$option_gallery.'</select>
			</p>
			<p>
				<label for="'.$this->get_field_id('gocaroboot_title').'">'.__('Text/subtitle for each image  (one per linea)','gocarousel').'</label>
				<textarea class="widefat" id="'.$this->get_field_id('gocaroboot_title').'" name="'.$this->get_field_name('gocaroboot_title').'" cols="20" rows="16">'.esc_attr($instance['gocaroboot_title']).'</textarea>
			</p>'; 
		} else {
			echo '<h3>'.sprintf(__('I am sorry, you do not have activated the plugin NextGen Gallery or maybe the table %s not does exists','gocarousel'), $table_gallery_netxgen).'</h3>';
		}
	}    
}
?>