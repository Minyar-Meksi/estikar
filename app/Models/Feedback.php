<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    use Searchable;
    protected $table = "feedbacks";
    protected $fillable = ['message', 'rating'];

    protected $searchableFields = ['*'];
}
