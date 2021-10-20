
function pdetails_meta_box() {
	add_meta_box('pdetails','Personal Details','pdetails_callback','post');
}
add_action('add_meta_boxes','pdetails_meta_box');
 

function pdetails_callback( $post ){
 
	wp_nonce_field('pdetails_save','pdetails_meta_box_nonce');
	$pdetails =  get_post_meta($post->ID,'_pdetails_key',false);
 
	?>
 
    <label for="">Enter First Name</label>
    <input type="text" name="first_name_field" placeholder="Enter First Name" value="<?php echo $pdetails[0]['first_name']; ?>">
    <br>
    <label for="">Enter Last Name</label>
    <input type="text" name="last_name_field" placeholder="Enter last Name" value="<?php echo $pdetails[0]['last_name']; ?>">
    <br>
    <label for="">Enter Email</label>
    <input type="text" name="email_field" placeholder="Enter Email" value="<?php echo $pdetails[0]['email']; ?>">
    <?php
}

function pdetails_save( $post_id ) {
 
	if( ! isset($_POST['pdetails_meta_box_nonce'])) {
		return;
	}
 
	if( ! wp_verify_nonce( $_POST['pdetails_meta_box_nonce'], 'pdetails_save') ) {
		return;
	}
 
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return;
	}
 
	if( ! current_user_can('edit_post', $post_id)) {
		return;
	}
 
	$personal_details = [
	    'first_name' => $_POST['first_name_field'],
        'last_name' => $_POST['last_name_field'],
        'email' =>   $_POST['email_field']
    ];
 
 
 
	update_post_meta( $post_id,'_pdetails_key', $personal_details );
}
add_action('save_post','pdetails_save');
