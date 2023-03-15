<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertUpvote extends Model
{
    use HasFactory;

    public function upvote_expert()
    {
        return $this->belongsTo('App\Models\Expert', 'expert_id', 'id');
    }

    public function upvote_question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id', 'id');
    }
}
