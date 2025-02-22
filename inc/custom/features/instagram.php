<?php
function set_url_instagram()
{
    $url = get_field('ig_general', 'option');
    $url_ig = '
    <script> 
    var url_i_f = "' . $url['i_f_url'] . '";
    </script>';
    echo $url_ig;
}
add_action('wp_head', 'set_url_instagram');

function set_url_instagram_likes()
{
    $url = get_field('ig_general', 'option');
    $url_ig_likes = '
    <script> 
    var i_l_url = "' . $url['i_l_url'] . '";
    </script>';
    echo $url_ig_likes;
}
add_action('wp_head', 'set_url_instagram_likes');

function ig_information()
{
    $ig_info = get_field('ig_information', 'option');
    $ig_info_ =
        '<script>
            let url_harga = "' . $ig_info['url_harga'] . '";
        </script>';
    echo $ig_info_;
}
add_action('wp_head', 'ig_information');

add_action('wp_ajax_ig_login', 'ig_login');
add_action('wp_ajax_nopriv_ig_login', 'ig_login');
function ig_login()
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $curl = curl_init();
    $field = get_field('ig_credentials', 'option');

    $payload = array("username" => $username, "password" => $password);

    if ($username) {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $field['endpoint_login'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        die();
    }
}

add_action('wp_ajax_ig_check_username', 'ig_check_username');
add_action('wp_ajax_nopriv_ig_check_username', 'ig_check_username');
function ig_check_username()
{
    $username = $_POST['username'];
    $token = $_POST['token'];
    $curl = curl_init();
    $field = get_field('ig_credentials', 'option');

    $payload = $field['endpoint_check_username'] . "?username=" . $username;

    if ($username) {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $var = json_decode($response, true);

        // Validasi respons API
        if (empty($var) || !isset($var['profile_pic_url']) || empty($var['profile_pic_url'])) {
            echo json_encode(array(
                "error" => true,
                "message" => "Profile picture URL not found or invalid response."
            ));
            die();
        }

        // Konversi avatar ke base64
        $profile_pic_url = str_replace("http:", "https:", $var['profile_pic_url']);
        if (filter_var($profile_pic_url, FILTER_VALIDATE_URL)) {
            $avatar = "data:image/png;base64, " . base64_encode(file_get_contents($profile_pic_url));
        } else {
            $avatar = null; // Atau berikan placeholder avatar
        }

        $result = array(
            "data" => $response,
            "avatar_ig" => $avatar
        );
        echo json_encode($result, JSON_PRETTY_PRINT);
        die();
    } else {
        echo json_encode(array(
            "error" => true,
            "message" => "Username is required."
        ));
        die();
    }
}

add_action('wp_ajax_ig_submit_followers', 'ig_submit_followers');
add_action('wp_ajax_nopriv_ig_submit_followers', 'ig_submit_followers');
function ig_submit_followers()
{
    $username = $_POST['username'];
    $quantity = $_POST['total'];
    $token = $_POST['token'];

    $curl = curl_init();
    $field = get_field('ig_credentials', 'option');

    $payload = array("username" => $username, "total" => (int)$quantity);

    if ($username) {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $field['endpoint_send_follow'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        echo $response;
        die();
    }
}

add_action('wp_ajax_ig_get_profile', 'ig_get_profile');
add_action('wp_ajax_nopriv_ig_get_profile', 'ig_get_profile');
function ig_get_profile()
{
    $token = $_POST['token'];

    $curl = curl_init();
    $field = get_field('ig_credentials', 'option');

    if ($token) {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $field['endpoint_get_profile'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        echo $response;
        die();
    }
}


add_action('wp_ajax_ig_likes', 'ig_likes');
add_action('wp_ajax_nopriv_ig_likes', 'ig_likes');
function ig_likes()
{
    $link = $_POST['link'];
    $field = get_field('tiktok_credentials', 'option');
    $smm = get_field('ig_general', 'option');
    $crede = get_field('credentials', 'option');

    $curl = curl_init();
    //data yang dilempar
    $payload = $field['endpoint'] . "?key=" . $field['key'] . "&action=add&service=" . $smm['i_l_order_id'] . "&link=" . $link . "&quantity=" . $smm['i_l_quantity'];

    if ($link) {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $payload,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        bot("Likes Instagram: [" . $link . "]", $crede['webhook_ig_likes']);

        $result = array(
            'status' => $response,
            'link' => $link
        );

        echo json_encode($result, JSON_PRETTY_PRINT);

        die();
    }
}


add_action('wp_ajax_validate_token', 'validate_token');
add_action('wp_ajax_nopriv_validate_token', 'validate_token');
function validate_token()
{
    //area token 
    $token = $_POST['token'];
    $credential = get_field('credentials', 'option');

    $paytoken = $credential['endpoint'] . "?secret=" . $credential['secret_key'] . "&response=" . $token . "";

    $curl = curl_init();
    if (!empty($token)) {
        curl_setopt_array($curl, array(
            CURLOPT_URL => $paytoken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Content-Length: 0'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        die();
    }
}


add_action('wp_ajax_new_login', 'new_login');
add_action('wp_ajax_nopriv_new_login', 'new_login');

function new_login()
{

    if (!isset($_POST['cf-turnstile-response'])) {
        wp_send_json_error(['message' => 'Captcha tidak valid.']);
        wp_die();
    }
    $args = get_turnstile();
    $captcha_token = sanitize_text_field($_POST['cf-turnstile-response']);
    $secret_key = $args['secret_key'];


    $verify_response = wp_remote_post($args['endpoint'], [
        'body' => [
            'secret'   => $secret_key,
            'response' => $captcha_token,
        ],
    ]);

    $body = json_decode(wp_remote_retrieve_body($verify_response), true);

    if (is_wp_error($verify_response)) {
        wp_send_json_error(['message' => 'Gagal menghubungi server captcha.']);
        wp_die();
    }

    if (!isset($body['success']) || $body['success'] !== true) {
        wp_send_json_error(['message' => 'Verifikasi captcha gagal. Coba lagi.']);
        wp_die();
    }

    $username = isset($_POST['username']) ? sanitize_text_field($_POST['username']) : '';
    $password = isset($_POST['password']) ? sanitize_text_field($_POST['password']) : '';

    if (empty($username) || empty($password)) {
        wp_send_json_error(['message' => 'Username dan password harus diisi']);
        wp_die();
    }

    $field = get_field('ig_credentials', 'option');

    if (!$field || empty($field['endpoint_login'])) {
        wp_send_json_error(['message' => 'Konfigurasi endpoint tidak ditemukan']);
        wp_die();
    }

    $payload = ["username" => $username, "password" => $password];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $field['endpoint_login'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    ]);

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    $response_data = json_decode($response, true);

    if (!$response_data) {
        wp_send_json_error([
            'message' => 'Silahkan Gunakan Akun Lain, atau selesaikan Challenge Instagram Anda',
            'raw_response' => htmlentities($response)
        ]);
        wp_die();
    }

    if ($http_code !== 200 || !$response_data) {
        wp_send_json_error(['message' => 'Login gagal. Cek kembali username dan password.', 'response' => $response]);
    } else {
        $token = isset($response_data['data']['token']) ? $response_data['data']['token'] : 'Token tidak tersedia';

        wp_send_json_success([
            'message' => 'Login berhasil',
            'token' => $token,
            'response' => $response_data
        ]);
    }

    wp_die();
}


add_action('wp_ajax_fetch_instagram_media', 'fetch_instagram_media');
add_action('wp_ajax_nopriv_fetch_instagram_media', 'fetch_instagram_media');

function fetch_instagram_media()
{
    $field = get_field('ig_credentials', 'option');

    $token = isset($_POST['token']) ? sanitize_text_field($_POST['token']) : '';
    $target_url = isset($_POST['url']) ? esc_url_raw($_POST['url']) : '';

    if (empty($token) || empty($target_url)) {
        wp_send_json_error(['message' => 'Token atau URL tidak boleh kosong']);
        wp_die();
    }

    $payload = json_encode(["url" => $target_url]);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $field['endpoint_check_feed'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    $response_data = json_decode($response, true);

    if ($http_code !== 200 || !$response_data) {
        wp_send_json_error(['message' => 'Url yang Anda masukan Salah! Silahkan Priksa kembali Url anda', 'response' => $response]);
    } else {
        $media_id = isset($response_data['data']['media_id']) ? $response_data['data']['media_id'] : 'Gambar Tidak Tersedia';
        $media_url = isset($response_data['data']['url_image']) ? $response_data['data']['url_image'] : '';

        $base64_image = null;
        if (!empty($media_url)) {
            $image_data = @file_get_contents($media_url);
            if ($image_data !== false) {
                $image_info = getimagesizefromstring($image_data);
                $mime_type = $image_info['mime'] ?? 'image/png';
                $base64_image = 'data:' . $mime_type . ';base64,' . base64_encode($image_data);
            }
        }

        if (!$base64_image) {
            $base64_image = 'data:image/png;base64,' . base64_encode(file_get_contents('https://via.placeholder.com/150'));
        }

        wp_send_json_success([
            'message'    => 'Berhasil mengambil media ID',
            'media_id'   => $media_id,
            'media_url'  => $base64_image,
        ]);
    }

    wp_die();
}



add_action('wp_ajax_like_instagram_media', 'like_instagram_media');
add_action('wp_ajax_nopriv_like_instagram_media', 'like_instagram_media');

function like_instagram_media()
{
    $field = get_field('ig_credentials', 'option');

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'new_login_nonce')) {
        wp_send_json_error(['message' => 'Invalid request']);
        wp_die();
    }

    $token = isset($_POST['token']) ? sanitize_text_field($_POST['token']) : '';
    $media_id = isset($_POST['media_id']) ? sanitize_text_field($_POST['media_id']) : '';
    $total = isset($_POST['total']) ? intval($_POST['total']) : 0;

    if (empty($token) || empty($media_id) || $total <= 0) {
        wp_send_json_error(['message' => 'Token, Media ID, atau Jumlah Like tidak valid']);
        wp_die();
    }

    $payload = json_encode([
        "media_id" => $media_id,
        "total" => $total
    ]);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $field['endpoint_send_likes'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    $response_data = json_decode($response, true);

    if ($http_code !== 200 || !$response_data) {
        wp_send_json_error(['message' => 'Gagal mengirim like', 'response' => $response]);
    } else {
        wp_send_json_success([
            'message' => 'Like berhasil dikirim',
            'success' => $response_data['data']['success_total']
        ]);
    }

    wp_die();
}
