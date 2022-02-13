<?php namespace Haruncpi\QueryLog\Supports;

use Haruncpi\QueryLog\Contracts\FileWritable;

class JsonLogFileWriter implements FileWritable
{
    public function write($file_path, $data)
    {
        file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
    }
}