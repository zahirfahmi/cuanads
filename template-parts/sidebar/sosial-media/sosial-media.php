<div class="author-social">
    <div class="title">
        <h3 class="spanborder"><span>Visit Social Media</span></h3>
    </div>
    <div class="social-media">
        <?php $get_sosmed = get_field('social_media', 'option'); ?>
        <a href="<?= $get_sosmed['facebook']; ?>" rel="noopener" target="_blank">
            <div class="facebook"><i class="fa-brands fa-facebook-f fa-lg"></i></div>
        </a>
        <a href="<?= $get_sosmed['whatsapp']; ?>" rel="noopener" target="_blank">
            <div class="whatsapp"><i class="fa-brands fa-whatsapp"></i></div>
        </a>
        <a href="<?= $get_sosmed['instagram']; ?>" rel="noopener" target="_blank">
            <div class="instagram"><i class="fa-brands fa-instagram fa-lg"></i></div>
        </a>
        <a href="mailto:<?= $get_sosmed['email']; ?>" rel="noopener" target="_blank">
            <div class="email"><i class="fa-regular fa-envelope fa-lg"></i></div>
        </a>
        <a href="<?= $get_sosmed['tiktok']; ?>" rel="noopener" target="_blank">
            <div class="tiktok"><i class="fa-brands fa-tiktok fa-lg"></i></div>
        </a>
    </div>
</div>