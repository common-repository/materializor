<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( esc_html__( 'Sorry, you are not allowed to manage options for this site.', 'materializor' ) );
}

use Materializor\Assets\MTZR_Roboto;
use Materializor\MTZR_Plugin;

$plugin = MTZR_Plugin::$instance;
$theme  = $plugin->frontend->theme;

if ( isset( $_POST['_wpnonce'] ) && 1 === wp_verify_nonce( $_POST['_wpnonce'], 'materializor_settings' ) ) {
    $new_theme_options = [];
    if ( ! empty( $_POST['theme_main_color'] ) ) {
        $new_theme_options['main_color'] = sanitize_text_field( $_POST['theme_main_color'] );
    }
    if ( ! empty( $_POST['theme_link_color'] ) ) {
        $new_theme_options['link_color'] = sanitize_text_field( $_POST['theme_link_color'] );
    }
    $theme->save_options( $new_theme_options );

    $new_settings = [];
    if ( ! empty( $_POST['roboto_source'] ) ) {
        $new_settings['roboto_source'] = sanitize_text_field( $_POST['roboto_source'] );
    }
    $new_settings['mdi_enabled'] = ! empty( $_POST['mdi_enabled'] );
    $plugin->save_settings( $new_settings );
}

$theme_values = $theme->get_options_values();
$settings = $plugin->get_settings();

?>
<div class="wrap">
    <h1><?php esc_html_e( 'Materializor', 'materializor' ); ?></h1>
    <form method="post" novalidate="novalidate">

        <?php wp_nonce_field( 'materializor_settings' ); ?>

        <h2 class="title"><?php esc_html_e( 'Theme', 'materializor' ); ?></h2>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php esc_html_e( 'Main Color', 'materializor' ); ?></label>
                    </th>
                    <td>
                        <div id="theme_main_color_picker"
                             data-settings-color="theme_main_color"
                             data-color="<?php echo esc_attr( $theme_values['main_color'] ); ?>">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php esc_html_e( 'Link Color', 'materializor' ); ?></label>
                    </th>
                    <td>
                        <div id="theme_link_color_picker"
                             data-settings-color="theme_link_color"
                             data-color="<?php echo esc_attr( $theme_values['link_color'] ); ?>">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 class="title"><?php esc_html_e( 'Icons', 'materializor' ); ?></h2>
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="mdi_enabled"><?php esc_html_e( 'Material Design Icons', 'materializor' ); ?></label>
                </th>
                <td>
                    <fieldset>
                        <label for="mdi_enabled">
                            <input name="mdi_enabled" type="checkbox" id="mdi_enabled" value="1" <?php checked( true, $settings['mdi_enabled'] ); ?> />
                            <?php esc_html_e( 'Add to Elementor icon library', 'materializor' ); ?>
                        </label>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>

        <h2 class="title"><?php esc_html_e( 'Fonts', 'materializor' ); ?></h2>
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="roboto_source"><?php esc_html_e( 'Roboto', 'materializor' ); ?></label>
                </th>
                <td>
                    <fieldset>
                        <p>
                            <?php foreach ( MTZR_Roboto::get_sources() as $value => $label ) : ?>
                                <label>
                                    <input name="roboto_source" type="radio" value="<?php echo esc_attr( $value ) ?>" <?php checked( $value, $settings['roboto_source'] ); ?>	/>
                                    <?php echo esc_html( $label ); ?>
                                </label>
                                <br />
                            <?php endforeach; ?>
                        </p>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>

        <?php submit_button(); ?>

    </form>
</div>
