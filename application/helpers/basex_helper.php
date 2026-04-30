<?php
function getcookienya($value, $output = null)
{
    $cookie_value = get_cookie($value);
    $cookiex = json_decode($cookie_value, true);
    if ($output == null) {
        return $cookiex;
    } else {
        return $cookiex[$output];
    }
}
function destroycookie()
{
    foreach ($_COOKIE as $name => $value) {
        // Set the cookie expiration date to one hour ago
        setcookie($name, '', time() - 3600, '/');
    }
}
function encryptjson($jsonData)
{
    // Metode enkripsi
    $cipherMethod = 'AES-256-CBC';

    // Kunci rahasia (harus disimpan dengan aman)
    $secretKey = 'fekusadev';

    // Panjang salt
    $saltLength = 16;
    $salt = openssl_random_pseudo_bytes($saltLength);

    // Vektor inisialisasi (IV) harus memiliki panjang yang sesuai dengan metode enkripsi
    $ivLength = openssl_cipher_iv_length($cipherMethod);
    $iv = openssl_random_pseudo_bytes($ivLength);

    // Tambahkan salt ke data
    $dataWithSalt = $salt . $jsonData;

    // Enkripsi data dengan salt
    $encryptedData = openssl_encrypt($dataWithSalt, $cipherMethod, $secretKey, 0, $iv);

    // Gabungkan salt, IV, dan data enkripsi untuk kemudian didekripsi
    $encryptedDataWithSaltAndIv = base64_encode($salt . $iv . $encryptedData);
    return $encryptedDataWithSaltAndIv;
}
function decryptjson($encryptedDataWithSaltAndIv)
{
    $secretKey = 'fekusadev';

    // Dekripsi data
    $decodedData = base64_decode($encryptedDataWithSaltAndIv);

    // Pisahkan salt, IV, dan data enkripsi
    $saltLength = 16;
    // $salt = substr($decodedData, 0, length: $saltLength);
    // Metode enkripsi
    $cipherMethod = 'AES-256-CBC';

    $ivLength = openssl_cipher_iv_length($cipherMethod);
    $iv = substr($decodedData, $saltLength, $ivLength);
    $encryptedData = substr($decodedData, $saltLength + $ivLength);

    // Dekripsi data menggunakan salt, IV, dan kunci rahasia yang sama
    $decryptedDataWithSalt = openssl_decrypt($encryptedData, $cipherMethod, $secretKey, 0, $iv);

    // Pisahkan salt dari data yang telah didekripsi
    $decryptedData = substr($decryptedDataWithSalt, $saltLength);

    return $decryptedData;
}
function createfilejsoncookie($userId, $data, $name = null)
{
    $datax = encryptjson(json_encode($data));
    if ($name == null) {
        file_put_contents('datauser' . $userId . '.json', $datax);
    } else {
        file_put_contents($name . $userId . '.json', $datax);
    }
}
function readfilejsoncookie($path)
{
    // Construct the file name based on the user ID
    $file_name = $path . '.json';

    // Check if the file exists
    if (file_exists($file_name)) {
        // Read the file contents
        $json_data_raw = file_get_contents($file_name);
        $json_data = decryptjson($json_data_raw);
        // Decode the JSON data into an associative array
        $data = json_decode($json_data, true);

        // Check for JSON decoding errors
        if (json_last_error() === JSON_ERROR_NONE) {
            return $data; // Return the decoded data
        } else {
            // Handle JSON decoding error
            return false;
        }
    } else {
        // Handle the case where the file does not exist
        return false;
    }
}

function deletefilejsoncookie($userId, $name)
{
    $filePath = $name . $userId . '.json'; // Define the file path
    // Check if the file exists
    if (file_exists($filePath)) {
        // Attempt to delete the file
        if (unlink($filePath)) {
            error_log("User data file deleted successfully for user ID: " . $userId);
        } else {
            error_log("Failed to delete user data file for user ID: " . $userId);
        }
    } else {
        error_log("User data file not found for user ID: " . $userId);
    }
}


// HELPER API
if (!function_exists('call_api')) {
    function call_api($method, $url, $data = [], $withToken = false)
    {
        $ch = curl_init();

        $headers = [];
        $defaultHeaders = ["Content-Type: application/json"];
        $body = !empty($data) ? json_encode($data) : "";

        // Tambah HMAC headers jika withToken = true
        if ($withToken) {
            $hmacHeaders = hmac_middleware($body);
            $headers = array_merge($headers, $hmacHeaders);
        }

        $headers = array_merge($defaultHeaders, $headers);

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_POSTFIELDS => $body ?: null,
            CURLOPT_HTTPHEADER => $headers,
            // CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $result = json_decode($response, true);

        return $result;
    }
}

function hmac_middleware($body)
{
    $publicKey = $_ENV["HMAC_PUBLIC_KEY"];
    $secretKey = $_ENV["HMAC_SECRET_KEY"];

    $timestamp = time();
    $token     = hash_hmac("sha256", $body . $timestamp, $secretKey);

    return [
        "X-key: " . $publicKey,
        "X-timestamp: " . $timestamp,
        "X-token: " . $token,
    ];
}

// phone number initial with country code phone number
if (!function_exists('normalizePhoneNumber')) {
    function normalizePhoneNumber(string $number): string
    {
        // Hapus semua karakter selain angka
        $number = preg_replace('/\D+/', '', $number);

        // Jika nomor diawali '0', ganti dengan '62'
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        // Jika nomor sudah diawali '8', tambahkan '62' di depan
        if (str_starts_with($number, '8')) {
            $number = '62' . $number;
        }

        return $number;
    }
}
