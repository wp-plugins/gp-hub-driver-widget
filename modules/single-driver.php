<?php
class gphub419231_driver_widget extends WP_Widget {
	function __construct() {
		parent::__construct(false, $name = __('GP Hub: Driver Widget'));
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'clickthrough' => 'no' ) );

		$driver_id = $instance['driver_id'];   
		$clickthrough = $instance['clickthrough'];


		$driver_options = gphub419231_get_driver_options();

		$select_options = '';
		foreach($driver_options as $k => $driver_name){
			$select_options .= '<option value="'.$k .'" '.selected( $driver_id, $k, false ).'>'.$driver_name.'</option>';
		}

		?>
		<p>There are currently <?php echo count($driver_options); ?> drivers to choose from, select one below: </p>
 		<p>
 			<label for="<?php echo $this->get_field_id('driver_id'); ?>">Driver: 
				<select class='widefat' id="<?php echo $this->get_field_id('driver_id'); ?>" name="<?php echo $this->get_field_name('driver_id'); ?>" type="text">
		          <?php echo $select_options; ?>
				</select>
			</label>
		</p>
		<?php
			$clickthrough_options = array(
				'yes' => 'Yes', 
				'no' => 'No'
			);
		?>
 		<p>
 			<label for="<?php echo $this->get_field_id('clickthrough'); ?>">Link through to the full driver profile on GP Hub? <br />
				<select class='widefat' id="<?php echo $this->get_field_id('clickthrough'); ?>" name="<?php echo $this->get_field_name('clickthrough'); ?>" type="text">
					<?php
						foreach($clickthrough_options as $k => $option){
							echo '<option value="'.$k.'" '.selected( $clickthrough, $k, false ).'>'.$option.'</option>';
						}
					?>
				</select>
			</label>
		</p>
		<?php 
	}
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['driver_id'] = ( ! empty( $new_instance['driver_id'] ) ) ? strip_tags( $new_instance['driver_id'] ) : '';
		$instance['clickthrough'] = ( ! empty( $new_instance['clickthrough'] ) ) ? strip_tags( $new_instance['clickthrough'] ) : '';
		return $instance;
	}
	function widget($args, $instance) {
		$instance = wp_parse_args( (array) $instance, array( 'clickthrough' => 'no' ) );
		
		$driver_id = $instance['driver_id'];   
		$clickthrough = $instance['clickthrough'];   

		echo $args['before_widget'];
		
		$gphub_logo = '<img style="width: 75px;" src="'.GPHUB_DW_DIR.'/img/gphub-logo-colored.png" alt="GP Hub F1 Driver Widget"  />';
		
		if($clickthrough == 'yes')
			$gphub_logo = '<a style="text-align: right; display: block; margin: 3px 0px 10px;" href="http://www.gp-hub.com/" target="_parent" id="gphub-logo" title="">'.$gphub_logo.'</a>';
		else
			$gphub_logo = '<div style="text-align: right; display: block; margin: 3px 0px 10px;" id="gphub-logo">'.$gphub_logo.'</div>';


		/*
		 * This widget loads a page on the gp-hub.com website which is placed inside the iframe. The page contains cached html output of the driver profile using the most recent race statistics and information it can find. 
		 */

		echo <<<HERE
		<style type="text/css">
			#gphub_driver_widget_{$driver_id}_wrapper iframe {
			    width: 100%;
			    border: 1px solid #ddd;
			    background: #fff;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('iframe#gphub_driver_widget_$driver_id').iFrameResize();
			});
        </script>
		<div id="gphub_driver_widget_{$driver_id}_wrapper">
			<iframe id="gphub_driver_widget_$driver_id" src="http://www.gp-hub.com/?nD5N2j6t6GNvFJa=true&type=single_driver&driver_id=$driver_id&clickthrough=$clickthrough" width="100%" frameborder="0" scrolling="no">Loading</iframe>
			{$gphub_logo}
		</div>
HERE;
		echo $args['after_widget'];
	}
}


function gphub419231_register_driver_widget()
{
	
    register_widget( 'gphub419231_driver_widget' );
	
	
}
add_action( 'widgets_init', 'gphub419231_register_driver_widget', 12);


function gphub419231_get_driver_options(){

	$driver_options = array();

	// Ferrari
	$driver_options[238] = 'Raikkonen (Ferrari)';
	$driver_options[210] = 'Vettel (Ferrari)';

	// Red Bull
	$driver_options[237] = 'Ricciardo (Red Bull)';
	$driver_options[8681] = 'Kvyat (Ferrari)';

	// Williams
	$driver_options[225] = 'Massa (Williams)';
	$driver_options[347] = 'Bottas (Williams)';

	// Mercedes
	$driver_options[202] = 'Hamilton (Mercedes)';
	$driver_options[223] = 'Rosberg (Mercedes)';

	// Force India
	$driver_options[228] = 'Hulkenberg (Force India)';
	$driver_options[226] = 'Perez (Force India)';

	// Sauber
	$driver_options[4328] = 'Ericsson (Sauber)';
	$driver_options[4332] = 'Nasr (Sauber)';	

	// McLaren
	$driver_options[203] = 'Alonso (McLaren)';
	$driver_options[222] = 'Button (McLaren)';
	$driver_options[1310] = 'Magnussen (McLaren)';

	// Lotus
	$driver_options[224] = 'Grosjean (Lotus)';
	$driver_options[204] = 'Maldonado (Lotus)';

	// Toro Rosso
	$driver_options[24629] = 'Verstappen (Toro Rosso)';
	$driver_options[8679] = 'Sainz (Toro Rosso)';

	// Manor
	$driver_options[24304] = 'Merhi (Manor)';
	$driver_options[6704] = 'Stevens (Manor)';
	

	asort($driver_options);

	return $driver_options;
}