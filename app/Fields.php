<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    protected $table = 'LMT_migrations_fields';
    protected $fillable = ['folder', 'name'];

    public function migration()
    {
        return $this->belongsTo(Migration::class);
    }

}
