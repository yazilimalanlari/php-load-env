<?php

class ENV {
    private string $path;
    private bool $fileExists = false;
    private const ERROR = array(
        'FILE_EXISTS' => 0
    );
    
    public function __construct(string $path = __DIR__ . '/.env') {
        if (file_exists($path)) {
            $this->path = $path;
            $this->fileExists = true;
        } else {
            $this->error(self::ERROR['FILE_EXISTS'], $path);
        }
    }

    public function init() {
        if ($this->fileExists) {
            $this->load($this->path);
        }
    }

    public function load(string $path) {
        if (!file_exists($path)) return;
        $fileSize = filesize($path);
        if ($fileSize > 0) {
            $open = fopen($path, 'r');
            $content = fread($open, $fileSize);
            fclose($open);

            foreach(explode(PHP_EOL, $content) as $line) {
                if ($line != null && ($index = strpos($line, '='))) {
                    $key = substr($line, 0, $index);
                    $value = trim(substr($line, $index+1));
                    
                    if (in_array(strtolower($value), ['true', 'false'])) {
                        $value = strtolower($value) == 'true';
                    } else if(is_numeric($value)) {
                        if ((int)$value == $value) {
                            $value = intval($value);
                        } else if((float)$value == $value) {
                            $value = floatval($value);
                        }
                    }

                    $_ENV[$key] = $value;
                }
            }
        }
    }

    private function error(int $code, ...$args) {
        $find = array_search($code, self::ERROR);
        if (!$find) return;

        switch ($find) {
            case "FILE_EXISTS":
                echo "$args[0] yolunda dosya bulunamadı.";
            break;
        }
    }

    public static function get(string $key) {
        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        } else {
            return null;
        }
    }
}