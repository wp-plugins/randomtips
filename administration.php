<?php
function rtip_Converter() {
	load_plugin_textdomain('randomtips', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
} 
add_action('plugins_loaded', 'rtip_Converter');
function rtip_my_init() {
	if (is_admin()) {
		wp_enqueue_script('jquery');
		
		wp_register_script('jquery-datatable', plugins_url('/js/jquery.dataTables.min.js', __FILE__ ), false, '1.10.4');
		wp_enqueue_script('jquery-datatable');
		//cdn.datatables.net/1.10.4/css/jquery.dataTables.css
		wp_register_style( 'rt-style',plugins_url('/css/jquery.dataTables.css', __FILE__ ) );
		wp_enqueue_style( 'rt-style' );
	}
}
add_action('init', 'rtip_my_init');

function rtip_options() {

	// must check that the user has the required capability
	if (! current_user_can ( 'manage_options' )) {
		wp_die ( __ ( 'You do not have sufficient permissions to access this page.' ) );
	}
	global $rt_results;
	// variables for the field and option names

	$hidden_field_name = 'mt_submit_hidden';
	$data_field_name_1 = 'testo';
	$data_field_name_2 = 'gruppo';
	$todeletert='rttodelete';


	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if (isset ( $_POST [$hidden_field_name] ) && $_POST [$hidden_field_name] == 'Y') {
		// Read their posted value
		$opt_val_1 = rtrim($_POST [$data_field_name_1]);
		$opt_val_2 = rtrim($_POST [$data_field_name_2]);
		if(!empty($opt_val_1)){			
			if(!empty($opt_val_2)){
				rtip_insert_tip ( $opt_val_1, $opt_val_2 );
			} else {
				rtip_insert_tip ( $opt_val_1, 'default' );
			}?>
			<div class="updated">
			<p>
			<strong><?php _e('settings saved.', 'randomtips' ); ?></strong>
				</p>
			</div>
			<?php 
		} else {
			?>
			<div class="updated">
			<p>
			<strong><?php _e('please fill the field text at least', 'randomtips' ); ?></strong>
				</p>
			</div>
			<?php 
		}
		// Save the posted value in the database
		

		// Put an settings updated message on the screen

		?>
<?php
	}

	if(isset ($_REQUEST [$todeletert])){
		rtip_delete_tip($_REQUEST [$todeletert]);
		?>
		<div class="updated">
			<p>
				<strong><?php _e('settings saved.', 'randomtips' ); ?></strong>
			</p>
		</div>
		<?php 
	}
		
	
	// Now display the settings editing screen
	
	echo '<div class="wrap">';
	
	// header
	
	echo "<h2>" . __ ( 'Create your tips.', 'randomtips' ) . "</h2>";
	
	// settings form
	
	?>

<h3><?php _e('Tip list', 'randomtips');?></h3>

<table id="risultati" class="widefat">
	<thead>
		<tr>
			<th>Id</th>
			<th><?php _e('Text', 'randomtips'); ?></th>
			<th><?php _e('Group', 'randomtips'); ?></th>
			<th><?php _e('Actions', 'randomtips'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Id</th>
			<th><?php _e('Text', 'randomtips'); ?></th>
			<th><?php _e('Group', 'randomtips'); ?></th>
			<th><?php _e('Actions', 'randomtips'); ?></th>
		</tr>
	</tfoot>
	<tbody>
    <?php
	rtip_getTips ();
	foreach ( $rt_results as $value ) {
		?>
        <tr class="alternate">
			<td><?php echo $value->id;?></td>
			<td><?php echo $value->text;?></td>
			<td><?php echo $value->team;?></td>
			<td> 
				<div>
					<span><a href="options-general.php?page=randomtips&<?php echo $todeletert;?>=<?php echo $value->id;?>"><?php _e('delete', 'randomtips' ); ?></a></span>
				</div>
			</td>
		</tr>
  <?php }?>
    </tbody>
</table>
<br>
<br>
<h3><?php _e('Insert a new tip', 'randomtips');?></h3>
<br>
<form name="form1" method="post" action="">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

	<p><?php _e("Text:", "randomtips"); ?>
	<textarea name="<?php echo $data_field_name_1; ?>" rows="4" cols="50"></textarea>
	</p>
	<p><?php _e("Group:", "randomtips" ); ?> 
	<input type="text" name="<?php echo $data_field_name_2; ?>" size="20" />
	</p>	
	<hr />

	<p class="submit">
		<input type="submit" name="Submit" class="button-primary"
			value="<?php esc_attr_e("Save"); ?>" />
	</p>

</form>

<script type="text/javascript">
<!--

//-->
jQuery(function ($) {
	$(document).ready(function() {
		$('#risultati').dataTable( {
	        "pagingType": "full_numbers"
	    } );
	} );
});
</script>
<?php } ?>
