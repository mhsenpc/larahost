<?php


namespace App\Services;


class DotEnvEditor
{
    protected $env_path;
    protected $variables;

    public function __construct(string $env_path) {
        $this->env_path = $env_path;
        $this->loadEnv();
    }

    protected function loadEnv() {
        $lines = file($this->env_path);
        foreach ($lines as $line) {
            $pos = strpos($line, '=');
            if ($pos === false) {
                continue;
            }
            $key                   = substr($line, 0, $pos);
            $value                 = substr($line, $pos + 1);
            $value = str_replace("\r",'',$value);
            $value = str_replace("\n",'',$value);
            $this->variables[$key] = $value;
        }
    }

    public function changeKey($key, $new_value) {
        $this->variables[$key] = $new_value;
    }

    public function flush() {
        $result = "";
        foreach ($this->variables as $key => $value) {
            $result .= "$key=$value\r\n";
        }
        file_put_contents($this->env_path, $result);
    }
}
