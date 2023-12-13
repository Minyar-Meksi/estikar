<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marque extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['categorie_id', 'name'];

    protected $searchableFields = ['*'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function modeles()
    {
        return $this->hasMany(Modele::class);
    }
}
