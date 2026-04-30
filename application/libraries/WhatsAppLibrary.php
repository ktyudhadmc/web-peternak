<?php

defined('BASEPATH') or exit('No direct script access allowed');

class WhatsAppLibrary
{
    protected $ci;
    protected $baseUrl;
    protected $secretKey;
    protected $publicKey;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->config->load('whatsapp');

        $this->baseUrl   = rtrim($this->ci->config->item('whatsapp_base_url'), '/');
        $this->secretKey = $this->ci->config->item('whatsapp_hmac_secret_key');
        $this->publicKey = $this->ci->config->item('whatsapp_hmac_public_key');
    }

    // ─── Transport ───────────────────────────────────────────────────────────

    /**
     * Generate HMAC headers.
     * $payload disertakan dalam signature agar request tidak bisa di-replay.
     */
    private function generateHmacHeaders(string $payload = ''): array
    {
        $timestamp = (string) time();
        // $token     = hash_hmac('sha256', $timestamp . $payload, $this->secretKey);
        $token     = hash_hmac('sha256', $timestamp, $this->secretKey);

        return [
            "X-key: {$this->publicKey}",
            "X-timestamp: {$timestamp}",
            "X-token: {$token}",
            'Content-Type: application/json',
        ];
    }

    /**
     * Eksekusi cURL dan kembalikan response terstandarisasi.
     * Semua method publik bermuara ke sini.
     */
    private function execute(array $curlOptions): array
    {
        $ch = curl_init();

        // Default di kiri, curlOptions di kanan agar bisa override
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 0, // infinity cmiww :v
            CURLOPT_CONNECTTIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => true,
        ] + $curlOptions);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            $errno = curl_errno($ch);
            curl_close($ch);

            log_message('error', "WhatsApp cURL error [{$errno}]: {$error}");

            return $this->errorResponse($error, $errno);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'WhatsApp JSON parse error: ' . json_last_error_msg());

            return $this->errorResponse('Invalid JSON response: ' . json_last_error_msg());
        }

        $success = $httpCode >= 200 && $httpCode < 300;

        if (! $success) {
            log_message('error', "WhatsApp HTTP {$httpCode}: " . json_encode($decoded));
        }

        return [
            'status'   => $success,
            'http_code' => $httpCode,
            'data'      => $decoded,
        ];
    }

    /**
     * JSON request — GET atau POST.
     */
    private function request(string $method, string $endpoint, array $payload = []): array
    {
        $method = strtoupper($method);
        $url    = $this->baseUrl . $endpoint;
        $body   = '';

        if ($method === 'GET') {
            if (! empty($payload)) {
                $url .= '?' . http_build_query($payload);
            }
        } else {
            $body = json_encode($payload, JSON_UNESCAPED_UNICODE);
        }

        // Semua method pakai generateHmacHeaders() tanpa argumen
        $options = [
            CURLOPT_URL        => $url,
            CURLOPT_HTTPHEADER => $this->generateHmacHeaders(),
        ];

        if ($method === 'POST') {
            $options[CURLOPT_POST]       = true;
            $options[CURLOPT_POSTFIELDS] = $body;
        }

        return $this->execute($options);
    }

    /**
     * Multipart upload (kirim file langsung).
     * Content-Type tidak di-set manual — cURL menanganinya otomatis.
     */
    private function sendMultipart(string $endpoint, array $fields): array
    {
        $timestamp = (string) time();
        $token     = hash_hmac('sha256', $timestamp, $this->secretKey);

        $headers = [
            "X-key: {$this->publicKey}",
            "X-timestamp: {$timestamp}",
            "X-token: {$token}",
        ];

        return $this->execute([
            CURLOPT_URL        => $this->baseUrl . $endpoint,
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => $headers,
        ]);
    }

    /**
     * Format error response yang konsisten.
     */
    private function errorResponse(string $message, int $code = 0): array
    {
        return [
            'status'   => false,
            'http_code' => $code,
            'data'      => null,
            'error'     => $message,
        ];
    }

    // ─── Global ──────────────────────────────────────────────────────────────

    public function sendMessageGlobal(string $to, string $message): array
    {
        return $this->request('POST', '/api/whatsapp/send-message-global', [
            'to'      => $to,
            'message' => $message,
        ]);
    }

    /**
     * Kirim file media (upload langsung) ke nomor tujuan.
     */
    public function sendMediaGlobal(string $to, string $filePath, string $caption = ''): array
    {
        if (! file_exists($filePath) || ! is_readable($filePath)) {
            return $this->errorResponse("File tidak ditemukan atau tidak bisa dibaca: {$filePath}");
        }

        return $this->sendMultipart('/api/whatsapp/send-media-global', [
            'file'    => new CURLFile($filePath, mime_content_type($filePath), basename($filePath)),
            'to'      => $to,
            'caption' => $caption,
        ]);
    }

    // ─── Chats ───────────────────────────────────────────────────────────────

    public function getChat(): array
    {
        return $this->request('GET', '/api/whatsapp/chats');
    }

    public function sendMessage(string $to, string $message): array
    {
        return $this->request('POST', '/api/whatsapp/send-message', [
            'to'      => normalizePhoneNumber($to),
            'message' => $message,
        ]);
    }

    public function sendMediaWithUrl(string $to, string $mediaUrl, string $caption = ''): array
    {
        return $this->request('POST', '/api/whatsapp/send-media', [
            'to'       => $to,
            'mediaUrl' => $mediaUrl,
            'caption'  => $caption,
        ]);
    }

    public function getChatMessage(string $to, int $limit = 10): array
    {
        return $this->request('GET', '/api/whatsapp/chat-messages', [
            'to'    => $to,
            'limit' => $limit,
        ]);
    }

    // ─── Groups ──────────────────────────────────────────────────────────────

    public function getGroup(): array
    {
        return $this->request('GET', '/api/whatsapp/groups');
    }

    public function sendGroupMessage(string $groupId, string $message): array
    {
        return $this->request('POST', '/api/whatsapp/send-message-group', [
            'groupId' => $groupId,
            'message' => $message,
        ]);
    }

    public function sendGroupMedia(string $groupId, string $mediaUrl, string $caption = ''): array
    {
        return $this->request('POST', '/api/whatsapp/send-media-group', [
            'groupId'  => $groupId,
            'mediaUrl' => $mediaUrl,
            'caption'  => $caption,
        ]);
    }

    public function getGroupMessage(string $groupId, int $limit = 10): array
    {
        return $this->request('GET', '/api/whatsapp/group-messages', [
            'groupId' => $groupId,
            'limit'   => $limit,
        ]);
    }
}
