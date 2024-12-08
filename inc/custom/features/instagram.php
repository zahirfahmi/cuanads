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
