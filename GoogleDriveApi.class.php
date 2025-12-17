<?php

class GoogleDriveApi
{
    const OAUTH2_TOKEN_URI = 'https://oauth2.googleapis.com/token';
    const DRIVE_UPLOAD_URL = 'https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart';
    const DRIVE_META_URL   = 'https://www.googleapis.com/drive/v3/files/';

    public function GetAccessToken($client_id, $redirect_uri, $client_secret, $code)
    {
        $postFields = http_build_query([
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri'  => $redirect_uri,
            'grant_type'    => 'authorization_code',
            'code'          => $code,
        ]);

        $ch = curl_init(self::OAUTH2_TOKEN_URI);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postFields,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode !== 200) {
            throw new Exception("Error {$httpCode}: Failed to receive access token. Response: {$response}");
        }

        return json_decode($response, true);
    }

    public function UploadFileToDrive($access_token, $file_content, $mime_type, $file_name)
    {
        $boundary = uniqid();
        $metadata = json_encode(['name' => $file_name]);

        $body =
            "--{$boundary}\r\n" .
            "Content-Type: application/json; charset=UTF-8\r\n\r\n" .
            "{$metadata}\r\n" .
            "--{$boundary}\r\n" .
            "Content-Type: {$mime_type}\r\n\r\n" .
            "{$file_content}\r\n" .
            "--{$boundary}--";

        $headers = [
            "Authorization: Bearer {$access_token}",
            "Content-Type: multipart/related; boundary={$boundary}",
            "Content-Length: " . strlen($body),
        ];

        $ch = curl_init(self::DRIVE_UPLOAD_URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => $body,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode !== 200) {
            throw new Exception("Upload failed ({$httpCode}): {$response}");
        }

        $data = json_decode($response, true);
        return $data['id'];
    }
}
