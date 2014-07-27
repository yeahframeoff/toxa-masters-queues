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
    public function fire( $job, $data)
    {
        $this->ensureDir();
        
        $time = date('Ymd_His');
        $name = $data['id'].'_'.$time.'.jpg';
        
        $url = $data['source_image_url'];
        try {
        	$img = Image::make($url);    
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            echo 'Couldn\'t resolve file from URL '.$url;
        }
        
        if ($data['save_original'] == true)
        {
            $originalDir = public_path().'/images/original';
            $path = $originalDir.'/'.$name;
            $img->save($path);
        }
                

        $requiredWidth  = $data['resize_to_width'];
        $requiredHeight = $data['resize_to_height'];

        $requiredRatio = $requiredWidth / $requiredHeight;
        
        $width = $img->width();
        $height = $img->height();
        $ratio = $width / $height;

        if ($requiredWidth <= $width && $requiredHeight <= $height)
        {
            if ($ratio > $requiredRatio)
                $img->widen($requiredWidth);
            else
                $img->heighten($requiredHeight);
        }
        
        $smallDir = public_path().'/images/small';
        $path = $smallDir.'/'.$name;

        $img->save($path);
        $img->destroy();
        $job->delete();
    }
    
    public function ensureDir()
    {
        $fs = new Filesystem;
        $dir = public_path();
        $dirs = $fs->directories($dir);
        if (!in_array($dir . '/images', $dirs))
            $fs->makeDirectory($dir . '/images');
        $dir .= '/images';
        $dirs = $fs->directories($dir);
        if (!in_array($dir . '/original', $dirs))
            $fs->makeDirectory($dir . '/original');
        if (!in_array($dir . '/small', $dirs))
            $fs->makeDirectory($dir . '/small');
    }
}