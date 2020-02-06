<?php

class Upload
{
    private $upload_input;
    private $name_array;
    private $ext_array;
    private $mime_array;
    private $controller = "classes/blackupload/";
    private $upload_folder;
    private $size;

    public function __construct($upload_input = null, $upload_folder = "upload", $size = 1024)
    {
        $this->upload_input = $upload_input;
        $this->upload_folder = $this->sanitize($upload_folder);
        $this->size = $size;
    }

    public function setUpload($upload_input)
    {
        $this->upload_input = $upload_input;
    }

    public function enableProtection()
    {
        $this->name_array = json_decode(
            file_get_contents(
                $this->sanitize(
                    $this->controller . "forbidden.json"
                )
            )
        );

        $this->ext_array = json_decode(
            file_get_contents(
                $this->sanitize(
                    $this->controller . "extension.json"
                )
            )
        );

        $this->mime_array = json_decode(
            file_get_contents(
                $this->sanitize(
                    $this->controller . "mime.json"
                )
            )
        );
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function setUploadFolder($folder_name)
    {
        $this->upload_folder = $this->sanitize($folder_name);
    }

    public function checkSize()
    {
        if ($this->upload_input['size'] <= $this->size) {
            return true;
        } else {
            throw new RuntimeException('Exceeded filesize limit.');
        }
    }

    public function checkExtension()
    {
        if (in_array($this->getExtension(), $this->ext_array)) {
            return true;
        } else {
            throw new RuntimeException('Invalid file format.');
        }
    }

    public function getExtension()
    {
        return strtolower(
            pathinfo(
                $this->upload_input['name'],
                PATHINFO_EXTENSION
            )
        );
    }

    public function checkMime()
    {
        $mime = mime_content_type($this->upload_input["tmp_name"]);
        if (in_array($mime, $this->mime_array)) {
            if ($mime === $this->getMime()) {
                return true;
            } else {
                throw new RuntimeException('Invalid file format.');
            }
        }
    }

    private function getMime()
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mtype = finfo_file($finfo, $this->upload_input['tmp_name']);
        if (finfo_close($finfo)) {
            return $mtype;
        } else {
            throw new RuntimeException('Failed to get mime type.');
        }
    }

    public function checkForbidden()
    {
        if (!(in_array($this->upload_input['name'], $this->name_array))) {
            return true;
        } else {
            throw new RuntimeException('File is forbidden.');
        }
    }

    public function checkIfEmpty()
    {
        if ($this->upload_input['error'] === UPLOAD_ERR_NO_FILE) {
            return false;
        } else {
            return true;
        }
    }

    public function upload()
    {
        if (is_uploaded_file($this->upload_input["tmp_name"])) {
            if (!(move_uploaded_file($this->upload_input["tmp_name"], $this->upload_folder . "/" . $this->upload_input['name']))) {
                throw new RuntimeException('Failed to move uploaded file.');
            } else {
                return true;
            }
        }
    }

    public function fix_array($file_post)
    {
        $file_array = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_array[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_array;
    }

    public function create_upload_folder($folder_name)
    {
        if (!file_exists($folder_name) && !is_dir($folder_name)) {
            @mkdir($this->sanitize($folder_name));
            @chmod($this->sanitize($folder_name) . "/", 755);
            $this->protect_foler($folder_name);
        }
    }

    public function protect_foler($folder_name)
    {
        if (!file_exists($folder_name . "/" . ".htaccess")) {
            $content = "Options -Indexes";
            $content .= "<Files .htaccess>";
            $content .= "Order allow,deny";
            $content .= "Deny from all";
            $content .= "</Files>";
            @file_put_contents($this->sanitize($folder_name) . "/" . ".htaccess", $content);
        }

        if (!file_exists($folder_name . "/" . "index.php")) {
            $content = "<?php http_response_code(403); ?>";
            @file_put_contents($this->sanitize($folder_name) . "/" . "index.php", $content);
        }
    }

    public function sanitize($value)
    {
        $data = trim($value);
        $data = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
        $data = filter_var($data, FILTER_SANITIZE_STRING);
        return $data;
    }

    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
