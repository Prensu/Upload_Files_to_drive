<?php
class GoogleDriveApi {

    const OAUTH2_TOKEN_URI = 'https://oauth2.googleapis.com/token';
    const DRIVE_FILE_UPLOAD_URL = 'https://www.googleapis.com/upload/drive/v2/files';
    const DRIVE_FILE_META_URL = 'https://www.googleapis.com/drive/v3/files';

    public function GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {
        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri .
            '&client_secret=' . $client_secret . '&code=' . $code .
            '&grant_type=authorization_code';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::OAUTH2_TOKEN_URI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);

        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $error_msg = 'Failed to receive access token';
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }
            throw new Exception('Error ' . $http_code . ': ' . $error_msg);
        }

        return $data;
    }

    public function UploadFileToDrive($access_token, $file_content, $mime_type) {
        $apiURL = self::DRIVE_FILE_UPLOAD_URL . '?uploadType=media';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiURL);

            curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: ' . $mime_type,
                'Authorization: Bearer ' . $access_token
            )
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $file_content);

        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $error_msg = 'Failed to upload file to Google Drive';
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }
            throw new Exception('Error ' . $http_code . ': ' . $error_msg);
        }

        return $data['id'];
    }

    public function UpdateFileMeta($access_token, $file_id, $file_meatadata) {
        $apiURL = self::DRIVE_FILE_META_URI . $file_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token
            )
        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($file_meatadata));

        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

         if ($http_code != 200) {
            $error_msg = 'Failed to update file metadata';
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }
            throw new Exception('Error ' . $http_code . ': ' . $error_msg);
        }

        return $data;
    }
}