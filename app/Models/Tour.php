<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Image;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'created_by'

    ];

    public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
public function images()
{
    return $this->hasMany(Image::class);
}

}

