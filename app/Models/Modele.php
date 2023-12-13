<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modele extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'marque_id'];

    protected $searchableFields = ['*'];

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function versions()
    {
        return $this->hasMany(Version::class);
    }
}
