<?php

namespace Cms\Models;

use Intervention\Image\Facades\Image;


class ImagemCms 
{

    public function inserir($file, $path, $filename, $sizes, $widthOriginal)
    {
        foreach($sizes as $prefixo => $size){
            Image::make($file->getRealPath())->resize($size['width'], $size['height'], function ($constraint) {
                $constraint->aspectRatio();

                //$constraint->upsize();
            })->save($path."/".$prefixo."-".$filename);
        }

        $success = false;
        if($widthOriginal){
            $success = $file->move($path, $filename);
        }

        return $success;
    }


    public function alterar($file, $path, $filename, $sizes, $widthOriginal, $registro)
    {
        foreach($sizes as $prefixo => $size){
            if(file_exists($path."/".$prefixo."-".$registro->imagem)){
                unlink($path."/".$prefixo."-".$registro->imagem);
            }
            Image::make($file->getRealPath())->resize($size['width'], $size['height'], function ($constraint) {
                $constraint->aspectRatio();
            })->save($path."/".$prefixo."-".$filename);
        }

        $success = false;
        if($widthOriginal){
            $success = $file->move($path, $filename);
        }

        if($success) {            
            if (!empty($registro->imagem)) {
                if (file_exists($path . "/" . $registro->imagem)) {
                    unlink($path . "/" . $registro->imagem);
                }
            }
        }
        
        return $success;
    }  
    
    public function excluir($path, $sizes, $registro)
    {
        foreach($sizes as $prefixo => $size){
            if(file_exists($path."/".$prefixo."-".$registro->imagem)){
                unlink($path."/".$prefixo."-".$registro->imagem);
            }
        }

        if(file_exists($path."/".$registro->imagem)) {
            unlink($path . "/" . $registro->imagem);
        }
    }
    
    
}
