function display_radio_list_shortcode() {
    global $post;
    $berisalam = get_post_meta($post->ID, 'customdata_group', true);

    $output = '<form>';
    
    if ($berisalam) {
        foreach ($berisalam as $field) {
            $title = esc_attr($field['TitleItem']);
            $value = esc_attr($field['TitleValue']);
            
            $output .= '<input type="radio" name="custom_radio" value="' . $value . '">' . $title . '<br>';
        }
    }
    
    $output .= '</form>';

    return $output;
}
add_shortcode('display_radio_list', 'display_radio_list_shortcode');

function display_mingguan_url_shortcode($atts) {
    $post_id = get_the_ID();
    $url = get_post_meta($post_id, 'mingguan', true);
    return $url;
}
add_shortcode('mingguan', 'display_mingguan_url_shortcode');

function display_bulanan_url_shortcode($atts) {
    $post_id = get_the_ID();
    $url = get_post_meta($post_id, 'bulanan', true);
    return $url;
}
add_shortcode('bulanan', 'display_bulanan_url_shortcode');


function redirect_based_on_radio_selection_shortcode() {
    ob_start();
    ?>
    <h2>Weekly Donation:</h2>
    <form id="redirectForm">
        <?php echo do_shortcode('[display_radio_list]'); ?>
        <br>
        <button id="redirectButton">Go</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('redirectForm');
            var button = document.getElementById('redirectButton');

            button.addEventListener('click', function(event) {
                event.preventDefault();
                var selectedValue = form.querySelector('input[name="custom_radio"]:checked');
                if (selectedValue) {
                    var campaign = selectedValue.value;
                    var redirectUrl = '<?php echo do_shortcode("[mingguan]"); ?>';
                    redirectUrl += '?campaign=' + campaign +'&package=1';
                    window.location.href = redirectUrl;
                }
            });
        });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('redirect_based_on_radio_selection', 'redirect_based_on_radio_selection_shortcode');

function redirect_based_on_radio_selection_bulanan_shortcode() {
    ob_start();
    ?>
    <h2>Monthly Donation</h2>
    <form id="bulananForm">
        <?php echo do_shortcode('[display_radio_list]'); ?>
        <br>
        <button id="redirectbulanan">Go</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('bulananForm');
            var button = document.getElementById('redirectbulanan');

            button.addEventListener('click', function(event) {
                event.preventDefault();
                var selectedValue = form.querySelector('input[name="custom_radio"]:checked');
                if (selectedValue) {
                    var campaign = selectedValue.value;
                    var redirectUrl = '<?php echo do_shortcode("[bulanan]"); ?>';
                    redirectUrl += '?campaign=' + campaign +'&package=1';
                    window.location.href = redirectUrl;
                }
            });
        });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('redirect_based_on_radio_selection_bulanan', 'redirect_based_on_radio_selection_bulanan_shortcode');
