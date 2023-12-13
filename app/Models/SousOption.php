<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SousOption extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['option_id', 'price', 'name'];

    protected $searchableFields = ['*'];

    protected $table = 'sous_options';

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
