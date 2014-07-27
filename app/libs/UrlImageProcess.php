<?php
/**
 * Created by PhpStorm.
 * User: Антон
 * Date: 26.07.14
 * Time: 23:32
 */

namespace libs;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Intervention\Image\Facades\Image;

class UrlImageProcess {
    public function fire($job, $data)
    {
        $url = $data['source_image_url'];
        $img = Image::make($url);
        if ($data['save_original'] == true)
        {
            $originalDir = public_path().'/images/original';
            $path = $originalDir.'/'.$data['id'].'.jpg';
            $img->save($path);
        }

        $requiredWidth  = $data['resize_to_width'];
        $requiredHeight = $data['resize_to_height'];

        $requiredRatio = $requiredWidth / $requiredHeight;
        $ratio = $img->width() / $img->height();

        if ($ratio > $requiredRatio)
            $img->widen($requiredWidth);
        else
            $img->heighten($requiredHeight);

        $smallDir = public_path().'/images/small';
        $path = $smallDir.'/'.$data['id'].'.jpg';

        $img->save($path);
        $img->destroy();
        $job->delete();
    }
}