<!-- content fields range define sleep timeout for connect attempt boundaries by seconds -->
<input
    type="range"
    min="0"
    max="20"
    name="boundaries_options[<?= esc_attr( $args['label_for'] ); ?>]"
    value="<?= $options['boundaries_field_sleep_timeout'] ?? 1 ?>"
/>
<p class="description">
    the value and currently set to&nbsp;

    <strong>
        <?= $options['boundaries_field_sleep_timeout'] ?? 1 ?>
    </strong>
    second<?= ( $options['boundaries_field_sleep_timeout'] ?? 1 ) > 1 ? "s":"" ?>.
</p>

<p class="description">
    the standard value is <strong>1</strong> second.
</p>

<p class="description">
    the maximum recommended value is <strong>6</strong> seconds.
</p>

<p class="description">
    the minimum recommended value is <strong>1</strong> second.
</p>