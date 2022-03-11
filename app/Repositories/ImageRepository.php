<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository
{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function create(array $image_data)
    {
        $this->image->create($image_data);
    }
}
