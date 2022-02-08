<?php
/**
 * @param $file
 * @param $path
 * @param $savePath
 * @return string
 */
function uploadImage($file,$path,$savePath): string
{
    $fileName = time() . '.' . $file->getClientOriginalExtension();
    $file->move($path,$fileName);
    return $savePath.$fileName;
}
