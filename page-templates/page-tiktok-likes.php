<?php

/**
 * Template Name: Tiktok Likes
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 * @version 6.0.0
 */

get_header();
wp_enqueue_style('tiktok-pages', get_template_directory_uri() . '/assets/css/tiktok-page.min.css');
?>

<div id="content" class="site-content">
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <section class="tiktok">
                <div class="container">
                    <div class="row justify-content-between border p-sm-5 p-4 cta mb-3 mb-md-5 "
                        style="background-color:#e8f3ec ;">
                        <div class="col-md-6">
                            <h1><?= get_the_title(); ?></h1>
                            <p>Nikmati layanan TikTok Likes gratis yang mempermudah Anda untuk meningkatkan popularitas
                                akun Anda! Dapatkan <?= get_likes()['qty']; ?> likes gratis setiap
                                <b><?= get_reset_time_tiktok_likes() / 60; ?>
                                    menit</b> , tanpa biaya apa pun.
                            </p>
                        </div>
                        <div class="col-md-6 pt-3">
                            <div class="row g-3">
                                <form id="linkFormLikes" class="form-tiktok">
                                    <input type="text" id="linkLikes" name="linkLikes"
                                        placeholder="Masukan Link Video TikTok Kamu" required>
                                    <div class="g-recaptcha"
                                        data-sitekey="<?php echo esc_attr(get_recapcha()['site_key']); ?>"></div>
                                    <div class="button_wrap">
                                        <button class="primary_btn" type="submit" id="submitBtnLikes"
                                            disabled>Submit</button>
                                        <a href="https://wa.link/3gayzb" class="secondary_btn">Beli Tiktok Likes</a>
                                    </div>
                                </form>
                                <div id="messageLikes"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <?php echo get_the_content(); ?>
                        </div>
                        <div class="col-12 col-lg-4">
                            <?php get_template_part('template-parts/components/sidebar'); ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
get_footer();
