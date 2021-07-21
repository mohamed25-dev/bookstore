<?php

namespace App\Traits;
use Intervention\Image\ImageManagerStatic as Image;

trait ImageUploadTrait 
{
  protected $imagePath = 'app/public/images/covers';
  protected $imageHieght = 600;
  protected $imageWidth = 600;

  public function uploadImage ($img)
  {
    $imageName  = $this->imageName($img);

    Image::make($img)
      ->resize($this->imageWidth, $this->imageHieght)
      ->save(storage_path($this->imagePath . '/' .$imageName));

      return 'images/covers/' . $imageName;
  }

  public function imageName ($img) 
  {
    return time() . '-' .$img->getClientOriginalName();
  }

}