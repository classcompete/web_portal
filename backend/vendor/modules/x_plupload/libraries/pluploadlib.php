<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pluploadlib
{

    private $_ci;
    private $_target_folder;
    private $_execution_time;
    private $_chunks = 0;
    private $_chunk = 0;

    public function __construct()
    {
        $this->_ci = & get_instance();
    }

    public function setTargetFolder($value)
    {
        $this->_target_folder = $value;
    }

    public function setExecutionTime($value)
    {
        $this->_execution_time = $value;
    }

    public function config($config)
    {
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }

        if (!file_exists($this->_target_folder)) {
            @mkdir($this->_target_folder);
        }
        @set_time_limit($this->_execution_time);
    }

    public function isLastChunk()
    {
        $last = false;
        if (($this->_chunks - $this->_chunk) <= 1) {
            $last = true;
        }
        return $last;
    }

    public function process_upload($data, $files)
    {
        // Get parameters
        $chunk = isset($data["chunk"]) ? $data["chunk"] : 0;
        $this->_chunk = $chunk;
        $chunks = isset($data["chunks"]) ? $data["chunks"] : 0;
        $this->_chunks = $chunks;
        $fileName = isset($data["name"]) ? $data["name"] : '';

        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '', $fileName);

        // Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($this->_target_folder . DIRECTORY_SEPARATOR . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($this->_target_folder . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b)) {
                $count++;
            }

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];
        }
        if (isset($_SERVER["CONTENT_TYPE"])) {
            $contentType = $_SERVER["CONTENT_TYPE"];
        }

        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($files['file']['tmp_name']) && is_uploaded_file($files['file']['tmp_name'])) {
                // Open temp file
                $out = fopen($this->_target_folder . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = fopen($files['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }
                    } else {
                        return '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                    }
                    fclose($in);
                    fclose($out);
                    @unlink($files['file']['tmp_name']);
                } else {
                    return '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
                }
            } else {
                return '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
            }
        } else {
            // Open temp file
            $out = fopen($this->_target_folder . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                } else {
                    return '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                }
                fclose($in);
                fclose($out);
            } else {
                return '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
            }
        }

        // Return JSON-RPC response
        return '{"jsonrpc" : "2.0", "result" : "' . $fileName . '", "id" : "id"}';
    }

    private function _load($lib = NULL)
    {
        if ($lib == NULL)
            return FALSE;

        if (isset($this->loaded[$lib])):
            return FALSE; else:
            $this->_ci->load->library($lib);
            $this->loaded[$lib] = TRUE;
            return TRUE;
        endif;
    }

}

