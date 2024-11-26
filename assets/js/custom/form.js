jQuery(function () {
  jQuery('#linkFormLikes').on('submit', function (e) {
    e.preventDefault();

    let ip = getCookie('ip_user');
    let link = jQuery('#linkLikes').val();
    let recaptchaResponse = grecaptcha.getResponse();

    if (!link || link.trim() === '') {
      jQuery('#messageLikes').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Link tidak boleh kosong.</span></div>");
      return;
    }

    if (!recaptchaResponse) {
      jQuery('#messageLikes').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Silakan verifikasi reCAPTCHA.</span></div>");
      return;
    }

    jQuery('#submitBtnLikes').html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

    jQuery
      .post(
        ajaxurl,
        {
          action: 'process_likes',
          ip_address: ip,
          link: link,
          'g-recaptcha-response': recaptchaResponse,
        },
        function (response) {
          jQuery('#submitBtnLikes').html('Submit').prop('disabled', false);

          if (response.success) {
            jQuery('#messageLikes').html("<div class='message_tiktok grn'><i class='fa-solid fa-circle-check g_message'></i><span class='y_text'>" + response.data.message + '</span></div>');
          } else {
            jQuery('#messageLikes').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>" + response.data.message + '</span></div>');
          }
          console.log(response);
        }
      )
      .fail(function () {
        jQuery('#submitBtnLikes').html('Submit').prop('disabled', false);
        jQuery('#messageLikes').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Terjadi kesalahan. Coba lagi nanti.</span></div>");
      });
  });

  jQuery('#linkFormViews').on('submit', function (e) {
    e.preventDefault();

    let ip = getCookie('ip_user');
    let link = jQuery('#linkViews').val();
    let recaptchaResponse = grecaptcha.getResponse();

    if (!link || link.trim() === '') {
      jQuery('#messageViews').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Link tidak boleh kosong.</span></div>");
      return;
    }

    if (!recaptchaResponse) {
      jQuery('#messageViews').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Silakan verifikasi reCAPTCHA.</span></div>");
      return;
    }

    jQuery('#submitBtnViews').html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

    jQuery
      .post(
        ajaxurl,
        {
          action: 'process_views',
          ip_address: ip,
          link: link,
          'g-recaptcha-response': recaptchaResponse,
        },
        function (response) {
          jQuery('#submitBtnViews').html('Submit').prop('disabled', false);

          if (response.success) {
            jQuery('#messageViews').html("<div class='message_tiktok grn'><i class='fa-solid fa-circle-check g_message'></i><span class='y_text'>" + response.data.message + '</span></div>');
          } else {
            jQuery('#messageViews').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>" + response.data.message + '</span></div>');
          }
          console.log(response);
        }
      )
      .fail(function () {
        jQuery('#submitBtnViews').html('Submit').prop('disabled', false);
        jQuery('#messageViews').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Terjadi kesalahan. Coba lagi nanti.</span></div>");
      });
  });
});

jQuery(function ($) {
  const tiktokUrlPattern = /^(https?:\/\/)?(www\.)?(tiktok\.com|vt\.tiktok\.com)\/.+$/;

  $('#linkLikes').on('input', function () {
    const isValidTikTokLink = tiktokUrlPattern.test($(this).val());

    if (isValidTikTokLink) {
      $('#submitBtnLikes').prop('disabled', false);
      $('#messageLikes').text('');
    } else {
      $('#submitBtnLikes').prop('disabled', true);
      $('#messageLikes').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Masukkan link TikTok yang benar.</span></div>");
    }
  });
});

jQuery(function ($) {
  const tiktokUrlPattern = /^(https?:\/\/)?(www\.)?(tiktok\.com|vt\.tiktok\.com)\/.+$/;

  $('#linkViews').on('input', function () {
    const isValidTikTokLink = tiktokUrlPattern.test($(this).val());

    if (isValidTikTokLink) {
      $('#submitBtnViews').prop('disabled', false);
      $('#messageViews').text('');
    } else {
      $('#submitBtnViews').prop('disabled', true);
      $('#messageViews').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Masukkan link TikTok yang benar.</span></div>");
    }
  });
});
