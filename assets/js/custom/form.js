jQuery(function ($) {
  $('#linkFormLikes').submit(function (event) {
    event.preventDefault();
    const linkInput = $('#linkLikes').val();

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'submit_free_likes',
        link: linkInput,
        ip_user: getCookie('ip_user'),
      },
      success: function (response) {
        $('#messageLikes').html(response.data || response.error);
        console.log(response);
      },
    });
  });
});

jQuery(function ($) {
  $('#linkFormViews').submit(function (event) {
    event.preventDefault();
    const linkInput = $('#linkViews').val();

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'submit_free_views',
        link: linkInput,
        ip_user: getCookie('ip_user'),
      },
      success: function (response) {
        $('#messageViews').html(response.data || response.error);
        console.log(response);
      },
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

  $('#linkViews').on('input', function () {
    const isValidTikTokLink = tiktokUrlPattern.test($(this).val());

    if (isValidTikTokLink) {
      $('#submitBtnViews').prop('disabled', false);
      $('#messageViews').html('');
    } else {
      $('#submitBtnViews').prop('disabled', true);
      $('#messageViews').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Masukkan link TikTok yang benar.</span></div>");
    }
  });

  $('#submitBtnLikes').on('click', function (e) {
    e.preventDefault();
    const recaptchaResponse = grecaptcha.getResponse();

    if (recaptchaResponse === '') {
      $('#messageLikes').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Mohon verifikasi reCAPTCHA.</span></div>");
      return;
    }

    // Tampilkan spinner
    $('#submitBtnLikes').html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'submit_free_likes',
        'g-recaptcha-response': recaptchaResponse,
        ip_user: '<?php echo $_SERVER["REMOTE_ADDR"]; ?>',
        link: $('#linkLikes').val(),
      },
      success: function (response) {
        if (response.success) {
          $('#messageLikes').html("<div class='message_tiktok grn'><i class='fa-solid fa-circle-check g_message'></i><span class='y_text'>Berhasil, Likes anda akan segera bertambah.</span></div>");
        } else {
          $('#messageLikes').html(response.data);
        }
      },
      complete: function () {
        // Sembunyikan spinner
        $('#submitBtnLikes').html('Submit').prop('disabled', false);
        grecaptcha.reset();
      },
    });
  });

  $('#submitBtnViews').on('click', function (e) {
    e.preventDefault();
    const recaptchaResponse = grecaptcha.getResponse();

    if (recaptchaResponse === '') {
      $('#messageViews').html("<div class='message_tiktok ylw'><i class='fa-solid fa-circle-exclamation y_message'></i><span class='y_text'>Mohon verifikasi reCAPTCHA.</span></div>");
      return;
    }

    // Tampilkan spinner
    $('#submitBtnViews').html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...').prop('disabled', true);

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'submit_free_views',
        'g-recaptcha-response': recaptchaResponse,
        ip_user: '<?php echo $_SERVER["REMOTE_ADDR"]; ?>',
        link: $('#linkViews').val(),
      },
      success: function (response) {
        if (response.success) {
          $('#messageViews').html("<div class='message_tiktok grn'><i class='fa-solid fa-circle-check g_message'></i><span class='y_text'>Berhasil, Views anda akan segera bertambah.</span></div>");
        } else {
          $('#messageViews').html(response.data);
        }
      },
      complete: function () {
        // Sembunyikan spinner
        $('#submitBtnViews').html('Submit').prop('disabled', false);
        grecaptcha.reset();
      },
    });
  });
});
