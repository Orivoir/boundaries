
<div class="wrap">

    <h1><?= esc_html( get_admin_page_title() ); ?></h1>

    <form
        action="options.php"
        method="post"
    >
        <?php

        // output security fields for the registered setting "boundaries"
        settings_fields( 'boundaries' ); // check fields from "boundaries" section if submitted

        // output setting sections and their fields
        // (sections are registered for "boundaries", each field is registered to a specific section)
        do_settings_sections( 'boundaries' ); // show field from "boundaries" section

        // output save settings button
        submit_button( 'Save Settings' ); // show: button[type="submit"]
        ?>
    </form>

    <div class="wrap" style="display:flex;justify-content:space-around;margin: 2.85vh 0;">

        <div class="wrap">
            <button type="button" class="button button-primary" id="boundaries-settings-btn-reset-value">
                Reset to default value
            </button>
        </div>

    </div>

</div>

<style>

<?php include PATH_STYLE . '/settings-form.css' ; ?>

</style>

<script>

<?php include PATH_SCRIPT . '/settings-form.js' ; ?>

</script>