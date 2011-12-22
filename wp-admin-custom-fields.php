<?php 
/**
 * @package WP Admin Custom Fields
 * @author VinMatrix Team
 * @version 1.0
 */
/*
Plugin Name: WP Admin Custom Fields
Plugin URI: http://blog.vinmatrix.com
Description: This plugin is usefull to maintain admin custom fields...
Author: VinMatrix Team
Version: 1.0
Author URI: http://blog.vinmatrix.com
*/

add_action('admin_menu','custom_field_settings_admin_menu');
add_action('admin_menu','custom_field_esttings_mgr_admin_menu');



function custom_field_settings_admin_menu() {

	$opt_title_name = 'custom_field_settings_screen_title_name';
	$opt_title_val = str_replace("\\","",(get_option( $opt_title_name )));
	
	if ($opt_title_val==""){
		$opt_title_val = "Custom Field Settings";
		}
	
		
	

}

function custom_field_esttings_mgr_admin_menu() {
	
	if (function_exists('add_options_page')) {
		add_options_page(__('Custom Field Settings'),__('Custom Field Settings'),10,basename(__FILE__),'custom_field_settings_page');
	}
}
function getcustomfield($fieldid){

$opt_custom_fields_settings = 'custom_fields_settings';
		$fieldssettings = get_option( $opt_custom_fields_settings );
		if($fieldssettings!='')
		$nooffields = $fieldssettings['nofvalues'];
		for($i=0;$i<$nooffields;$i++){
			
		if($fieldssettings['field_id'][$i] == $fieldid){
		return $fieldssettings['field_value'][$i];
		
		}
		}
		
}
function custom_field_settings_page(){
	

	$opt_custom_fields_settings = 'custom_fields_settings';
	$opt_field_id = 'field_id';
    $opt_field_value = 'field_value';
	$hidden_field_name = 'hidden_field';

    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        update_option( $opt_custom_fields_settings, $_POST );
	
?>
<div class="updated"><p><strong><?php _e('Custom fields Settings saved.', 'menu-test' ); ?></strong></p></div>
<?php

    }
   	$nooffields = get_option( $opt_custom_fields_settings );
	if($nooffields!='')
	$nooffields = $nooffields['nofvalues'];

    echo '<div class="wrap">';
   echo "<h2>" . __( 'Custom Fields Page', 'menu-test' ) . "</h2>";
    ?>
<a href="#" id="add">Add New Field</a>
<form name="form1" method="post" action="" onsubmit="return  validateit(this);">
<div class="inputs">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
<?php 
$fieldssettings = get_option( $opt_custom_fields_settings );	
if($nooffields!='' && $nooffields>0){
	?>
	<input type="hidden" name="nofvalues" id="nofvalues" value="<?=$nooffields?>">

	<?
for($i=0;$i<$nooffields;$i++){ ?>
<div id="div<?=$i+1?>">
<p><?php _e("Field Name:", 'field-title' ); ?> 
	<input type="text" name="field_id[]" value="<?php echo $fieldssettings['field_id'][$i]; ?>" size="20"> 
<?php _e("Value:", 'valie' ); ?> 
	<input type="text" name="field_value[]" value="<?php echo $fieldssettings['field_value'][$i]; ?>" size="50"> 
	
	<?=($i>0)?'<a href="#" id="remove" onclick="removeit('.($i+1).');">Remove</a>':'';?>
	
	<br/>
	
</p><hr />
</div>
<?php }}else{ ?>
<input type="hidden" name="nofvalues" id="nofvalues" value="1">

<?php
for($i=0;$i<1;$i++){ ?>
<div id="div<?=$i+1?>">
<p><?php _e("Field Name:", 'field-title'); ?> 
	<input type="text" name="field_id[]" value="" size="20"> 
<?php _e("Value:", 'valie' ); ?> 
	<input type="text" name="field_value[]" value="" size="50"> 
	
	<?=($i>0)?'<a href="#" id="remove" onclick="removeit('.($i+1).');">Remove</a>':'';?>
	
	<br/>
	
</p><hr />
</div>

<?php }} ?>
</div>
<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
</p>
</form>
Sample Code get the Custom Field value: getcustomfield('fieldname');<br/>
Ex: getcustomfield('email_id');

</div>

<script>jQuery(document).ready(function(){

	var i = parseInt(jQuery('#nofvalues').val());

	jQuery('#add').click(function() {
		i++;
		jQuery('<p><div id="div'+i+'">Field Name:<input type="text" name="field_id[]" value="" size="20">Value:<input type="text" name="field_value[]" value="" size="50"><a href="#" id="remove" onclick="removeit('+i+');">Remove</a> <br/></p><hr /></div>').fadeIn('slow').appendTo('.inputs');
		
		jQuery('#nofvalues').val(i);
	
	});



});
function removeit(id){
	
        if(id > 1) {
		
		jQuery('#div'+id).remove();
		id--;
		jQuery('#nofvalues').val(id);
	}
}
function validateit(form){
var chks = document.getElementsByName('field_id[]');
 
        for (var i = 0; i < chks.length; i++)
        {        
        if (chks[i].value=="")
        {
        alert("Please fillup all the fields");
        chks[i].focus();
        return false;            
        }else{
			
			var numericExpression = '^[_a-zA-Z0-9_]+$';
		if(!chks[i].value.match(numericExpression)){
			alert("Accepts letters and '_'");
			chks[i].focus();
        return false;   
		}
		  
        
		}
        }
		var chks = document.getElementsByName('field_value[]');
 
        for (var i = 0; i < chks.length; i++)
        {        
        if (chks[i].value=="")
        {
       alert("Please fillup all the fields");
        chks[i].focus();
        return false;            
        }
        }
}


</script>
<?php
 
}
?>