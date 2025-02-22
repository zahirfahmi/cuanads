<?php
wp_enqueue_style('tutorial', get_template_directory_uri() . '/assets/css/tutorial.min.css');
$i_information = get_field('ig_information', 'option');
?>

<div class="tutorial">
    <div class="heading">
        <?= $i_information['info_ig_followers']; ?>
    </div>
    <div class="tutor">
        <i class="fas fa-info-circle"></i>
        <h2>Cara Menggunakan</h2>
    </div>
    <div class="contents">
        <ul>
            <li>Login dengan akun Instagram Kamu di website Kami.</li>
            <li>Diarahkan ke safelink sebelum melanjutkan.</li>
            <li>Masukkan username Instagram Kamu.</li>
            <li>Klik "Submit" dan tunggu followers Kamu bertambah.</li>
        </ul>
        <p>
            Selesai! Sekarang, Kamu hanya perlu menunggu followers baru Kamu bertambah secara gratis. Nikmati
            pertumbuhan
            profil Instagram Kamu dengan cepat dan mudah!
        </p>
    </div>
</div>