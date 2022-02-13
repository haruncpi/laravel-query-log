<?php namespace Haruncpi\QueryLog\Supports;

use Haruncpi\QueryLog\Contracts\FileWritable;

class TextLogFileWriter implements FileWritable
{
    private $file_path;

    public function write($file_path, $data)
    {
        $this->file_path = $file_path;

        foreach ($data['meta'] as $key => $value) {
            $this->writeLine($this->addSpace($key, 12) . ": $value");
        }

        $this->writeLine("--------------------\n");

        foreach ($data['queries'] as $q) {
            foreach ($q as $key => $val) {
                if (is_array($val)) {
                    $this->writeLine($this->addSpace($key, 12) . ": " . implode("|", $val));
                } else {
                    $this->writeLine($this->addSpace($key, 12) . ": " . $val);
                }
            }

            $this->writeLine("");
        }
    }

    private function addSpace($key, $max)
    {
        return $key . str_repeat(' ', $max - strlen($key));
    }

    private function writeLine($txt)
    {
        file_put_contents($this->file_path, $txt . "\n", FILE_APPEND);
    }
}