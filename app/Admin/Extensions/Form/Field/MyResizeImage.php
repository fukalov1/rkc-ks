<?php

namespace App\Admin\Extensions\Form\Field;

use Encore\Admin\Form\Field\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagez;

class MyResizeImage extends Image
{
    use \Encore\Admin\Form\Field\ImageField;

    /**
     * {@inheritdoc}
     */
    protected $view = 'admin::form.file';

    /**
     *  Validation rules.
     *
     * @var string
     */
    protected $rules = 'image';

    /**
     * @param array|UploadedFile $image
     *
     * @return string
     */
    public function prepare($image)
    {
        $width = 350;
        $height = 233;
        $result='';
        if (request()->has(static::FILE_DELETE_FLAG)) {
            return $this->destroy();
        }

        $this->name = $this->getStoreName($image);

        $this->callInterventionMethods($image->getRealPath());

        $filename = $this->uploadAndDeleteOriginal($image);

        $file = public_path('uploads').'/'.$filename;
        $filename = preg_replace('/images\//','', $filename);
        $i = Imagez::make($file);
        $w = $i->width();
        $h = $i->height();

        if ($w/$h > $width/$height) {
            $i->resize(round($height*$w/$h,0), $height);
        }
        else {
            $i->resize($width, round($width*$h/$w,0));
        }
        $i->crop($width,$height);

        $i->save(public_path('uploads').'/images/thumbnail/'.$filename);


        return $filename;
    }

    protected function resizePhoto($img) {
        Image::make($img)
            ->resize(200,200)
            ->save($img);
    }

}
