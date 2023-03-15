<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertCropQuery extends Model
{
    use HasFactory;

     public function expert_crop_queries()
    {
    	return $this->belongsTo('\App\Models\CropQuery','crop_query_id','id');
    }
}
