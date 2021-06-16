<?php
namespace Arthurmelikyan\Quizable\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class HelperRepo{

    public static function upload_image($image, $path, $size = null, $resize_method = 'resize' , $returnType = 'string')
    {
        // ! $resize_method @param fit or resize
        // ! fit crops image , resize just decrease or increase image resolution
        $extension = $image->extension();
        $filename = self::strong_pwd_generate(18, false).".{$extension}";
        $sdisk = Storage::disk(config('quizable.diskdriver'));
        $filePath = "{$path}/{$filename}";
        $image = Image::make($image);
        $image->encode($extension, 80);

        if (is_array($size)) {
            if (count($size) > 1) {
                $jsonPath = [];
                foreach ($size as $prop => $s) {
                    if ($resize_method == 'resize') {
                        $image->resize(key($s), $size[$prop][key($s)], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        $image->fit(key($s), $size[$prop][key($s)], function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    }

                    $fn = ($prop == 'l') ? $filePath : "{$path}/_{$prop}_{$filename}";
                    $sdisk->put($fn , $image->stream(), 'public');
                    if ($returnType == 'json') {
                        $jsonPath[$prop] = $fn;
                    }
                }
                if (count($jsonPath)) {
                    return json_encode($jsonPath);
                }
            } else {
                if ($resize_method == 'resize') {
                    $image->resize(key($size), $size[key($size)], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                } else {
                    $image->fit(key($size), $size[key($size)], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                $sdisk->put($filePath, $image->stream(), 'public');
            }
        } else if (!$size) {
            $sdisk->put($filePath, $image->stream(), 'public');
        }
        return $filePath;
    }

    public static function strong_pwd_generate($len = 8, $specSymb = true){
        $spec = ($specSymb) ? '!@#$%_-&*' : '';
        return substr(str_shuffle(rand(0, 999999).Str::random().$spec), 0 ,$len);
    }

    public static function upload_file($file, $path){
        $filename = self::strong_pwd_generate(18, false).".{$file->extension()}";
        Storage::disk(config('quizable.diskdriver'))->putFileAs($path, $file, $filename);
        return "{$path}/{$filename}";
    }
}
