jQuery(document).ready(function ($) {
  let currentPage = 1;
  let totalPages = $('.page-btn').length;

  function loadPosts(page) {
    $.ajax({
      type: 'POST',
      url: ajaxpagination.ajaxurl,
      data: {
        action: 'load_more_posts',
        page: page,
        nonce: ajaxpagination.nonce,
      },
      beforeSend: function () {
        $('#post-container').fadeTo('fast', 0.5);
      },
      success: function (response) {
        $('#post-container').html(response).fadeTo('fast', 1);
        currentPage = page;
        updatePagination();
      },
    });
  }

  function updatePagination() {
    $('.page-btn').each(function () {
      let page = $(this).data('page');

      // Menghapus kelas current__page dari semua tombol
      $(this).removeClass('current__page');

      // Menambahkan kelas current__page pada tombol halaman yang sedang aktif
      if (page === currentPage) {
        $(this).addClass('current__page');
        $(this).attr('disabled', true); // Menonaktifkan tombol halaman yang sedang aktif
      } else {
        $(this).removeAttr('disabled');
      }
    });

    $('#next-btn').data('page', currentPage + 1);
    $('#prev-btn').data('page', currentPage - 1);

    if (currentPage >= totalPages) {
      $('#next-btn').attr('disabled', true);
    } else {
      $('#next-btn').removeAttr('disabled');
    }

    if (currentPage <= 1) {
      $('#prev-btn').attr('disabled', true);
    } else {
      $('#prev-btn').removeAttr('disabled');
    }
  }

  $('#pagination').on('click', '.page-btn', function () {
    let page = $(this).data('page');
    if (page > 0 && page <= totalPages) {
      loadPosts(page);
    }
  });

  $('#pagination').on('click', '#next-btn', function () {
    let nextPage = $(this).data('page');
    if (nextPage > 0 && nextPage <= totalPages) {
      loadPosts(nextPage);
    }
  });

  $('#pagination').on('click', '#prev-btn', function () {
    let prevPage = $(this).data('page');
    if (prevPage > 0 && prevPage <= totalPages) {
      loadPosts(prevPage);
    }
  });
});
