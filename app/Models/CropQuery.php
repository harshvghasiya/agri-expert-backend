<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropQuery extends Model
{
    use HasFactory;

    public function queries()
    {
    	return $this->belongsTo('\App\Models\Query','query_id','id');
    }

    public function crops()
    {
    	return $this->belongsTo('\App\Models\Crop','crop_id','id');
    }

    public function expert_query_crop()
    {
    	return $this->hasMany('\App\Models\ExpertCropQuery','crop_query_id','id');
    }
}
