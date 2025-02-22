<?php

/**
 * Template Name: Instagram Likes
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */

get_header();

wp_enqueue_script(array(
    'jquery',
    'main',
    'auth',
    'new-instagram-likes',
    'cf-turnstile',
    'alert'
));

wp_enqueue_style(
    'fitur',
    get_stylesheet_directory_uri() . '/assets/css/fitur.min.css',
    false,
    filemtime(get_theme_file_path('/assets/css/fitur.min.css')),
    'all'
);
wp_enqueue_style('f-insta', get_template_directory_uri() . '/assets/css/features-instagram.min.css');

$url = get_field('ig_information', 'option');
?>
<div class="entry-content">
    <!-- Hook to add something nice -->
    <?php bs_after_primary(); ?>
    <section class="content" style="padding:32px 0">
        <div class="container">
            <div class="row">
                <div class="title mb-4">
                    <h1><?php echo get_the_title(); ?></h1>
                </div>
                <div class="col-12">
                    <div class="container px-0">
                        <div class="row justify-content-between border p-sm-5 p-2 cta mb-3 mb-md-5 insta_features_form"
                            style="background-color:#e8f3ec;">
                            <div class="col-12 col-lg-6">
                                <?php get_template_part('template-parts/components/infobar-nonlogin-likes'); ?>
                                <div class="card-features" id="before_submit">
                                    <form id="new-login-form" data-id="likes">
                                        <div class="title mb-4">
                                            <h3>Login Instagram</h3>
                                            <div class="sub-title">Login dengan akun Instagram kamu</div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="username_ig">Username</label>
                                            <input type="text" class="form-control" id="username_ig"
                                                aria-describedby="username_ig" autocomplete="on"
                                                placeholder="isi dengan username ig kamu" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password_ig">Password</label>
                                            <input type="password" class="form-control" id="password_ig"
                                                aria-describedby="password_ig" placeholder="isi dengan password ig kamu"
                                                required>
                                        </div>
                                        <div class="cf-turnstile"
                                            data-sitekey="<?php echo get_turnstile()['site_key']; ?>"></div>
                                        <div class="mt-3 small">Dengan mengklik tombol di bawah ini, Anda menyetujui
                                            Syarat dan ketentuan.
                                        </div>
                                        <div class="button_wrap">
                                            <button type="submit" id="ig_login_btn" class="primary_btn">
                                                Login
                                            </button>
                                            <a class="secondary_btn" href="<?= $url['url_harga']; ?>">
                                                Beli Followers
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                <?php get_template_part('template-parts/components/account-logout'); ?>
                                <div class="card-features my-3" id="url-form" style="display: none;">
                                    <form id="check_username_form" class="form">
                                        <div class="form-group">
                                            <label class="form-label">Url Instagram</label>
                                            <input type="text" class="form-control" id="instagram-url"
                                                placeholder="https://www.instagram.com/p/EXAMPLE/"
                                                aria-describedby="check_post_instagram" required>
                                            <div class="form-text">Masukan Link Post instagram yang ingin ditambahkan
                                                Likes</div>
                                        </div>
                                        <div class="button_wrap">
                                            <button type="submit" id="ig_post_check" class="primary_btn">
                                                Check
                                            </button>
                                            <a class="secondary_btn" href="<?= $url['url_harga']; ?>">
                                                beli Followers
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-features my-3" id="like-form" style="display: none;">
                                    <form id="ig_followers_form" class="form">
                                        <div class="d-flex justify-content-center flex-column align-items-center gap-2">
                                            <div class="avatar w-100 text-center" id="media-preview">
                                            </div>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="form-label bf">Jumlah Like yang diinginkan:</label>
                                            <div class="input-group">
                                                <input type="text" id="total-likes" class="form-control"
                                                    placeholder="10" value="10" required>
                                            </div>
                                        </div>
                                        <div class="button_wrap">
                                            <button type="submit" id="ig_likes_submit" class="primary_btn">
                                                Submit
                                            </button>
                                            <a class="secondary_btn" href="<?= $url['url_harga']; ?>">
                                                beli Followers
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <?php get_template_part('template-parts/components/tabs-features-likes'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="post-content">
                        <?php echo the_content(); ?>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <?php get_template_part('template-parts/components/sidebar'); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    var new_login = {
        nonce: "<?php echo wp_create_nonce('new_login_nonce'); ?>"
    };
</script>

<?php
get_footer();
