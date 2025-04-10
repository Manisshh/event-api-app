<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use Sluggable,SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'long_description',
        'event_date',
        'event_time',
        'location',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function sluggable(): array
    {
        return[
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
