<?php


namespace Tests\Helpers;


trait ResponseApi
{
    public function apiResponse($path)
    {
        $basePath = base_path('/tests/Stubs/'.$path);

        $file = file_get_contents($basePath);

        return  $file;
    }
}
