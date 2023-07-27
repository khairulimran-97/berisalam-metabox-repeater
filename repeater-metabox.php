<?php

add_action('admin_init', 'csm_add_meta_boxes', 2);

function csm_add_meta_boxes() {
    add_meta_box( 'csm-donation-group', 'Recurring Donation - Berisalam', 'Repeatable_meta_box_display', 'product', 'normal', 'default');
}

function Repeatable_meta_box_display() {
    global $post;
    $berisalam = get_post_meta($post->ID, 'customdata_group', true);
    wp_nonce_field( 'berisalam_repeatable_meta_box_nonce', 'berisalam_repeatable_meta_box_nonce' );
    ?>
<div class="jenis" style="padding-bottom:20px">
 	<label for="mingguan">Weekly URL:</label>
    <input style="width:100%;padding:5px;margin-top:10px" type="url" name="mingguan" id="mingguan" value="<?php echo esc_attr(get_post_meta($post->ID, 'mingguan', true)); ?>">
</div>
<div class="jenis" style="padding-bottom:20px">
 	<label for="bulanan">Monthly URL:</label>
    <input style="width:100%;padding:5px;margin-top:10px" type="url" name="bulanan" id="bulanan" value="<?php echo esc_attr(get_post_meta($post->ID, 'bulanan', true)); ?>">
</div>

    <script type="text/javascript">
        jQuery(document).ready(function( $ ){
            $( '#add-row' ).on('click', function() {
                var row = $( '.empty-row.screen-reader-text' ).clone(true);
                row.removeClass( 'empty-row screen-reader-text' );
                row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
                return false;
            });

            $( '.remove-row' ).on('click', function() {
                $(this).parents('tr').remove();
                return false;
            });
        });
    </script>
    <table id="repeatable-fieldset-one" width="50%">
        <tbody>
        <?php
        if ( $berisalam ) :
            foreach ( $berisalam as $field ) {
                ?>
                <tr>
                    <td>
						<label for="mingguan">Donation Label:</label>
                        <input style="width:95%;padding:5px;margin-top:10px;margin-right:20px;" type="text" placeholder="Donation Value Title" name="TitleItem[]" value="<?php if($field['TitleItem'] != '') echo esc_attr( $field['TitleItem'] ); ?>" />
                    </td>
                    <td >
						<label for="mingguan">Donation Value:</label>
                        <input style="width:100%;padding:5px;margin-top:10px" type="number" placeholder="Donation Value" name="TitleValue[]" value="<?php if ($field['TitleValue'] != '') echo esc_attr( $field['TitleValue'] ); ?>" />
					</td>
                    <td><a style="width:100%;padding:5px;margin-top:30px;background:red;color:white;padding-right:10px;padding-left:10px;text-align-last: center;" class="button remove-row" href="#1">Remove</a></td>
                </tr>
                <?php
            }
        else :
            // show a blank one
            ?>
            <tr>
                <td>
					<label for="mingguan">Donation Label:</label>
                    <input style="width:95%;padding:5px;margin-top:10px;margin-right:20px;" type="text" placeholder="Donation Value Title" title="Donation Value Title" name="TitleItem[]" /></td>
                <td>
					<label for="mingguan">Donation Value:</label>
                    <input style="width:100%;padding:5px;margin-top:10px" type="number"  placeholder="Donation Value" name="TitleValue[]" />
                    <?php if ($field['TitleValue'] != '') echo esc_attr( $field['TitleValue'] ); ?>
                </td>
                <td><a style="width:100%;padding:5px;margin-top:30px;background:red;color:white;padding-right:10px;padding-left:10px;text-align-last: center;" class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
            </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="empty-row screen-reader-text">
            <td>
				<label for="mingguan">Donation Label:</label>
                <input style="width:95%;padding:5px;margin-top:10px;margin-right:20px;" type="text" placeholder="Donation Title" name="TitleItem[]"/></td>
            <td>
				<label for="mingguan">Donation Value:</label>
                <input style="width:100%;padding:5px;margin-top:10px" type="number" placeholder="Donation Value" name="TitleValue[]" />
            </td>
            <td><a style="width:100%;padding:5px;margin-top:30px;background:red;color:white;padding-right:10px;padding-left:10px;text-align-last: center;" class="button remove-row" href="#">Remove</a></td>
        </tr>
        </tbody>
    </table>
    <p><a id="add-row" class="button" href="#">Add another</a></p>
    <?php
}

add_action('save_post', 'custom_repeatable_meta_box_save');
function custom_repeatable_meta_box_save($post_id) {
    if ( ! isset( $_POST['berisalam_repeatable_meta_box_nonce'] ) ||
        ! wp_verify_nonce( $_POST['berisalam_repeatable_meta_box_nonce'], 'berisalam_repeatable_meta_box_nonce' ) )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old = get_post_meta($post_id, 'customdata_group', true);
    $new = array();
    $title = $_POST['TitleItem'];
    $value = $_POST['TitleValue'];
    $count = count( $title );
    for ( $i = 0; $i < $count; $i++ ) {
        if ( $title[$i] != '' ) :
            $new[$i]['TitleItem'] = stripslashes( strip_tags( $title[$i] ) );
            $new[$i]['TitleValue'] = stripslashes( $value[$i] ); // and however you want to sanitize
        endif;
    }
	
	// Save single URL field
    if (isset($_POST['mingguan'])) {
        $mingguan = sanitize_text_field($_POST['mingguan']);
        update_post_meta($post_id, 'mingguan', $mingguan);
    }
	if (isset($_POST['bulanan'])) {
        $bulanan = sanitize_text_field($_POST['bulanan']);
        update_post_meta($post_id, 'bulanan', $bulanan);
    }
	
    if ( !empty( $new ) && $new != $old )
        update_post_meta( $post_id, 'customdata_group', $new );
    elseif ( empty($new) && $old )
        delete_post_meta( $post_id, 'customdata_group', $old );
}
