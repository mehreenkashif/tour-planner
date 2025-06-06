<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tour;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['tour_id', 'image_path'];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

}
