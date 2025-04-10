<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes,Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'deleted_by',
        'created_by',
        'updated_by'
    ];

    public function sluggable(): array
    {
        return[
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
