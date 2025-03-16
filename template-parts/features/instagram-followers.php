<?php
wp_enqueue_script(array(
    'jquery',
    'main',
    'cf-turnstile',
    'auth',
    'instagram-followers',
    'alert'
));

wp_enqueue_style('f-insta', get_template_directory_uri() . '/assets/css/features-instagram.min.css');

$i_general = get_field('ig_general', 'option');
$durasi = $i_general['i_f_time'] / 60;
$url = get_field('ig_information', 'option');
?>
<div class="container px-0">
    <div class="row justify-content-between border p-sm-5 p-2 cta mb-3 mb-md-5 insta_features_form"
        style="background-color:#e8f3ec;">
        <div class="col-12 col-lg-6">
            <?php get_template_part('template-parts/components/infobar-nonlogin'); ?>
            <?php get_template_part('template-parts/instagram/login'); ?>
            <?php get_template_part('template-parts/components/account-logout'); ?>

            <div class="card-features my-3" id="check_username_body" style="display: none;">
                <form id="check_username_form" class="form">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="input_check_username"
                            aria-describedby="check_username" placeholder="username" required>
                        <div class="form-text">Cek akun instagram yang ingin ditambahkan followersnya</div>
                    </div>
                    <div class="button_wrap">
                        <button type="submit" id="ig_followers_check" class="primary_btn">
                            Check
                        </button>
                        <a class="secondary_btn" href="<?= $url['url_harga']; ?>">
                            beli Followers
                        </a>
                    </div>
                </form>
            </div>
            <div class="card-features my-3" id="ig_followers_body" style="display: none;">
                <form id="ig_followers_form" class="form">
                    <div class="d-flex justify-content-center flex-column align-items-center gap-2">
                        <div class="avatar w-100 text-center">
                            <img src="" id="avatar" width="120" height="120" class="rounded-circle img-fluid" />
                        </div>
                        <div class="username fw-bold" id="username">
                            @dagelan
                        </div>
                        <div class="d-flex flex-row justify-content-center gap-3">
                            <div id="post">120 Posts</div>
                            <div id="following">120 Following</div>
                            <div id="followers">120 Followers</div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label class="form-label bf">Jumlah followers yang diinginkan:</label>
                        <div class="input-group">
                            <input type="text" id="quantity_followers" class="form-control" placeholder="10" value="10"
                                required>
                        </div>
                        <input type="hidden" id="username_followers" value="">
                    </div>
                    <div class="button_wrap">
                        <button type="submit" id="ig_followers_submit" class="primary_btn">
                            Submit
                        </button>
                        <a class="secondary_btn" href="<?= $url['url_harga']; ?>">
                            beli Followers
                        </a>
                    </div>
                </form>
            </div>
            <!-- Google Adsense -->
            <script async
                src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5537730164062705"
                crossorigin="anonymous"></script>
            <!-- In-features -->
            <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-5537730164062705"
                data-ad-slot="3783966797" data-ad-format="auto" data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            <!-- Google Adsense -->
        </div>
        <div class="col-12 col-lg-6">
            <?php get_template_part('template-parts/components/tabs-features'); ?>
        </div>
    </div>
</div>