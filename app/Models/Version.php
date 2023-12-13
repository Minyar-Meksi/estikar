<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Version extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'modele_id', 'picture', 'year'];

    protected $searchableFields = ['*'];

    public function modele()
    {
        return $this->belongsTo(Modele::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class);
    }
}
