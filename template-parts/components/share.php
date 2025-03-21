<?php
wp_enqueue_style('share-widget', get_stylesheet_directory_uri() . '/assets/css/share.min.css');
wp_enqueue_script('share-widget', get_stylesheet_directory_uri() . '/assets/js/custom/share.js');
?>

<div class="share-box">
    <div class="title">
        <h3>Bagikan Artikel ini</h3>
    </div>
    <div class="social-media">
        <div class="social-media-box">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(get_the_ID()); ?>"
                target="_blank" rel="noopener" class="button-social">
                <svg>
                    <use href="#facebook"></use>
                </svg>
                <span>Facebook</span>
            </a>

            <a href="https://twitter.com/intent/tweet?text=<?php echo get_permalink(get_the_ID()); ?>" target="_blank"
                rel="noopener" class="button-social">
                <svg>
                    <use href="#twitter"></use>
                </svg>
                <span>Twitter</span>
            </a>

            <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_permalink(get_the_ID()); ?>"
                target="_blank" rel="noopener" class="button-social">
                <svg>
                    <use href="#linkedin"></use>
                </svg>
                <span>LinkedIn</span>
            </a>

            <a href="mailto:" target="_blank" rel="noopener" class="button-social">
                <svg>
                    <use href="#email"></use>
                </svg>
                <span>Email</span>
            </a>
        </div>
    </div>
    <div class="copy-link-url">
        <div class="link">
            <div class="pen-url" id="link">
                <?php the_permalink(); ?>
            </div>
            <button class="copy-link" type="button" onclick="copyToClipboard('#link')">Copy Link</button>
        </div>
        <div class="copy-toast" id="copyToast">Copied!</div>
    </div>
    <svg class="hidden">
        <defs>
            <symbol id="share-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="feather feather-share">
                <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                <polyline points="16 6 12 2 8 6"></polyline>
                <line x1="12" y1="2" x2="12" y2="15"></line>
            </symbol>

            <symbol id="facebook" viewBox="0 0 24 24" fill="#3b5998" stroke="#3b5998" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
            </symbol>

            <symbol id="twitter" viewBox="0 0 24 24" fill="#1da1f2" stroke="#1da1f2" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter">
                <path
                    d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                </path>
            </symbol>

            <symbol id="email" viewBox="0 0 24 24" fill="#777" stroke="#fafafa" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-mail">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
            </symbol>

            <symbol id="linkedin" viewBox="0 0 24 24" fill="#0077B5" stroke="#0077B5" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin">
                <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                <rect x="2" y="9" width="4" height="12"></rect>
                <circle cx="4" cy="4" r="2"></circle>
            </symbol>

            <symbol id="close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="9" y1="9" x2="15" y2="15"></line>
                <line x1="15" y1="9" x2="9" y2="15"></line>
            </symbol>
        </defs>
    </svg>
</div>