<?php
wp_enqueue_style('infobar', get_template_directory_uri() . "/assets/css/infobar.min.css");

$i_information = get_field('ig_information', 'option');
$i_general = get_field('ig_general', 'option');
$durasi = $i_general['i_f_time'] / 60;


?>
<div class="d-flex wrapper-infobox-nonlogin">
    <div class="el_">
        <i class="fa-solid fa-coins me-2"></i><span id="poin_followers"
            class="me-1"><?= $i_general['i_f_quantity']; ?></span>Poins
    </div>
    <div class="el_">
        <?php if ($i_information['info_status_ig_followers'] === 'Normal') : ?>
            <i class="fa-solid fa-square-check"></i>Aktif
        <?php else : ?>
            <i class="fa-solid fa-wrench"></i>Maintenance
        <?php endif; ?>
    </div>
    <div class="el_">
        <div class="reset-time"><i class="fa-solid fa-clock"></i><?= $durasi; ?> Menit</div>
    </div>
</div>