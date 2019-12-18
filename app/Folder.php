<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Folder extends Model
{
    use Searchable;

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
