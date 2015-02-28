<?php
?>
<div class="wrap">
    <h2>wp-stripe</h2>

    <form method="post" action="options.php">
        <?php
            settings_fields( 'myoption-group' );
            do_settings_sections( 'myoption-group' );
            submit_button();
        ?>
    </form>
</div>