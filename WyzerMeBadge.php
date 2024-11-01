<?php
/**
Plugin Name: WyzerMeBadge
Plugin URI: https://www.wyzerme.com/static/assets/bloglink/wordpress/WyzerMeBadge-1.0.zip
Description: The official widget for wyzerme.com, loads your WyzerMe badge with a link to you WyzerMe expert profile on your blog sidebar
Author: Jeroen van Rijn at Frienductions, Inc
Version: 1.0
Author URI: http://www.wyzerme.com/p/jay/
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Copyright (C) 2012 Frienductions, Inc.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

 */

class WyzerMeBadge extends WP_Widget {
	/** constructor */
	function WyzerMeBadge() {
		$widget_ops = array('classname' => 'WyzerMeBadge', 'description' => "The official WyzerMe Badge widget. Loads your WyzerMe profile picture and links to your expert profile on wyzerme.com." );
		$control_ops = array('width' => 80, 'height' => 125);
		parent::WP_Widget(false, __('WyzerMe Badge'), $widget_ops, $control_ops);		
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		$wyzermeuser = $instance['wyzermeuser'];
		$bloggername = $instance['bloggername'];
		echo $before_widget;
		?>
		<iframe src="https://www.wyzerme.com/profile/contactframe/withpic/?user=<?php echo urlencode($wyzermeuser); if ($bloggername) { echo "&overridename=".urlencode($bloggername);}?>" allowtransparency=true frameborder ="0" scrolling="no" style="width:80px; height:125px;">
			<a href="https://www.wyzerme.com/profile/contactframe/withpic/?user=<?php echo $wyzermeuser;?>">Aks me <?php if ($bloggername) { echo $bloggername; } else { echo $wyzermeuser; } ?> on WyzerMe</a>			
		</iframe>
		<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['bloggername']);
		$instance['wyzermeuser'] = strip_tags($new_instance['wyzermeuser']);
		$instance['bloggername'] = strip_tags($new_instance['bloggername']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$wyzermeuser = esc_attr($instance['wyzermeuser']);
			$bloggername = esc_attr($instance['bloggername']);
		}
		else {
			$wyzermeuser = __( 'Your wyzerme.com user name', 'text_domain' );
			$bloggername = __( '', 'text_domain' );			
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('wyzermeuser'); ?>"><?php _e('Your WyzerMe username:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('wyzermeuser'); ?>" name="<?php echo $this->get_field_name('wyzermeuser'); ?>" type="text" value="<?php echo $wyzermeuser; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('bloggername'); ?>"><?php _e('(optional) The name you use on this blog:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('bloggername'); ?>" name="<?php echo $this->get_field_name('bloggername'); ?>" type="text" value="<?php echo $bloggername; ?>" />
		</p>
		<?php 
	}
} 


add_action( 'widgets_init', create_function( '', 'register_widget("WyzerMeBadge");' ) );

?>