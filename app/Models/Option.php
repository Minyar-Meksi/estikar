<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'type'];

    protected $searchableFields = ['*'];

    public function sousOptions()
    {
        return $this->hasMany(SousOption::class);
    }

    public function versions()
    {
        return $this->belongsToMany(Version::class);
    }
}
