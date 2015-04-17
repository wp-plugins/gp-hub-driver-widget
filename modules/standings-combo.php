<?php
class gphub419231_standings_widget extends WP_Widget {
	function __construct() {
		parent::__construct(false, $name = __('GP Hub: Championship Overview'));
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'clickthrough' => 'no', 'series_identifier' => 'f1' ) );

		$clickthrough = $instance['clickthrough'];
		$series_identifier = $instance['series_identifier'];
		

		?>
		<p>This widget shows the top 5 drivers, teams and the next 5 races for a series. </p>
		<?php
			$series_options = array(
				'f1' => 'F1', 
				'indy' => 'Indycar',
				'fe' => 'Formula E',
				'lights' => 'Indy Lights',
				'gp2' => 'GP2',
				'gp3' => 'GP3',
				'f3euro' => 'F3 Euro Series',
				'fr35' => 'Formula Renault 3.5'
			);
		?>
 		<p>
 			<label for="<?php echo $this->get_field_id('series_identifier'); ?>">Select the series to show:<br />
				<select class='widefat' id="<?php echo $this->get_field_id('series_identifier'); ?>" name="<?php echo $this->get_field_name('series_identifier'); ?>" type="text">
					<?php
						foreach($series_options as $k => $option){
							echo '<option value="'.$k.'" '.selected( $series_identifier, $k, false ).'>'.$option.'</option>';
						}
					?>
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
 			<label for="<?php echo $this->get_field_id('clickthrough'); ?>">Enable the clickthrough to include a 'show more' button which gives the user an option to view the full championship. This option also enables the profile links through to the full profile on GP Hub.<br />
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
		$instance['clickthrough'] = ( ! empty( $new_instance['clickthrough'] ) ) ? strip_tags( $new_instance['clickthrough'] ) : '';
		$instance['series_identifier'] = ( ! empty( $new_instance['series_identifier'] ) ) ? strip_tags( $new_instance['series_identifier'] ) : 'f1';
		return $instance;
	}
	function widget($args, $instance) {
		$instance = wp_parse_args( (array) $instance, array( 'clickthrough' => 'no', 'series_identifier' => 'f1' ) );
		
		$clickthrough = $instance['clickthrough'];   
		$series_identifier = $instance['series_identifier'];
		
		echo $args['before_widget'];
		
		$gphub_logo = '<img style="width: 75px;" src="'.GPHUB_DW_DIR.'/img/gphub-logo-colored.png" alt="The GP Hub WordPress Plugin"  />';
		
		if($clickthrough == 'yes')
			$gphub_logo = '<a style="text-align: right; display: block !important; margin: 3px 0px 10px;" href="http://www.gp-hub.com/" target="_parent" title="">'.$gphub_logo.'</a>';
		else
			$gphub_logo = '<div style="text-align: right; display: block !important; margin: 3px 0px 10px;">'.$gphub_logo.'</div>';


		/*
		 * This widget loads a page on the gp-hub.com website which is placed inside the iframe. The page contains cached html output of the standings using the most recent race statistics and information it can find. 
		 */

		echo <<<HERE
		<style type="text/css">
			#gphub_standings_widget_wrapper iframe {
			    width: 100%;
			    border: none;
			    background: transparent;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('iframe#gphub_standings_widget').iFrameResize();
			});
        </script>
		<div id="gphub_standings_widget_wrapper">
			<iframe id="gphub_standings_widget" src="http://www.gp-hub.com/?nD5N2j6t6GNvFJa=true&type=championship_combo&series_identifier=$series_identifier&clickthrough=$clickthrough" width="100%" frameborder="0" scrolling="no">Loading</iframe>
			{$gphub_logo}
		</div>
HERE;
		echo $args['after_widget'];
	}
}


function gphub419231_register_standings_widget()
{
	
    register_widget( 'gphub419231_standings_widget' );
	
	
}
add_action( 'widgets_init', 'gphub419231_register_standings_widget', 12);