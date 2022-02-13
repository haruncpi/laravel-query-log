<?php namespace Haruncpi\QueryLog\Contracts;

interface FileWritable
{
    /**
     * @param string $file_path
     * @param array $data
     * @return void
     */
    public function write($file_path, $data);
}