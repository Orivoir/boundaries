<!-- content fields input range max attempts connect before lock authentication -->
<input
    type="range"
    min="1"
    max="100"
    name="boundaries_options[<?= esc_attr( $args['label_for'] ); ?>]"
    value="<?= $options['boundaries_field_max_connect'] ?? 5 ?>"
/>
<p class="description">
    the value and currently set to&nbsp;

    <strong>
        <?= $options['boundaries_field_max_connect'] ?>
    </strong>.
</p>

<p class="description">
    the standard value is <strong>5</strong>.
</p>

<p class="description">
    the maximum recommended value is <strong>12</strong>.
</p>

<p class="description">
    the minimum recommended value is <strong>2</strong>.
</p>
