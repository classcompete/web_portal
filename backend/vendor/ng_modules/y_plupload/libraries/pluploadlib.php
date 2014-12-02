<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/20/13
 * Time: 12:44 PM
 * To change this template use File | Settings | File Templates.
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pluploadlib{




    public function process_upload(){

        $config = array(
            'upload_path' => X_TEACHER_UPLOAD_PATH,
            'allowed_types' => 'all',
            'max_size' => 15000,
            'encrypt_name' => TRUE
        );
        $config['upload_path'] = str_replace("/", DIRECTORY_SEPARATOR, $config['upload_path']);

//        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//        $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
//        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
//        $this->output->set_header("Pragma: no-cache");


        $cleanupTargetDir = false; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        usleep(5000);


        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';


        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);


        if ($chunks < 2 && file_exists($config['upload_path'])) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($config['upload_path'] . $fileName_a . '_' . $count . $fileName_b))
                $count++;

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }
        $filePath = $config['upload_path'] . DIRECTORY_SEPARATOR . $fileName;
        $filePath = str_replace("/", DIRECTORY_SEPARATOR, $filePath);

        // Create target dir
        if (!file_exists($config['upload_path']))
            @mkdir($config['upload_path']);

    // Remove old temp files
        if ($cleanupTargetDir) {
            if (is_dir($config['upload_path']) && ($dir = opendir($config['upload_path']))) {
                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $config['upload_path'] . DIRECTORY_SEPARATOR . $file;

                    // Remove temp file if it is older than the max age and is not the current file
                    if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
                        @unlink($tmpfilePath);
                    }
                }
                closedir($dir);
            } else {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }
        }


        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];
        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = @fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    } else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    @fclose($in);
                    @fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
            // Open temp file
            $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = @fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

                @fclose($in);
                @fclose($out);
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);

            $image_name = basename($filePath).PHP_EOL;
            return $image_name;
//            $this->output->set_output(json_encode($image_name));
        }
    }

}