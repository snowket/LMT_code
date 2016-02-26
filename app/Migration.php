<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Migration extends Model
{
    protected $table = 'LMT_migrations';

    protected $fillable = ['folder', 'name'];

    public function fields()
    {
        return $this->hasMany(Fields::class, 'LMT_migrations_id');
    }

}
