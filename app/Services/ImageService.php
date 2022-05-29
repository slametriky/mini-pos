<?php

namespace App\Services;

use LogicException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ImageService
{
    protected $rootPath;

    public function __construct()
    {
        $this->rootPath = public_path('upload/images');        
    }

    public function saveImage($image, $path = 'images', $oldFile = null): array
    {

        if($oldFile != null){

            $deleteFile = $this->rootPath.'/'.$path.'/'.$oldFile;
            
            if (File::exists($deleteFile)) {
                unlink($deleteFile);
            } 
        }

        $filename = Str::snake($image->getClientOriginalName());
        $uniqid = uniqid('', false);
        $imageName = sprintf('%s_%s', $uniqid, $filename);

        $path = '/'.$path.'/';
        $originalPath = $this->rootPath.$path;
        if (!file_exists($originalPath)) {
            if (!mkdir($originalPath, 0777, true) && !is_dir($originalPath)) {
                throw new LogicException(sprintf('Directory "%s" was not created', $originalPath));
            }
        }

        $image->move($originalPath, $imageName);

        return [
            'name' => $imageName,
            'path' => $path,
            'base_path' => $this->rootPath,
            'full_path' => $originalPath.$imageName,
        ];
    }

    
}