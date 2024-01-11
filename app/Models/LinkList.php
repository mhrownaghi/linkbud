<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkList extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'slug', 'owner_id'];

    public function links()
    {
        return $this->hasMany(Link::class, 'link_list_id');
    }

    public function addLink($attributes)
    {
        return $this->links()->create($attributes);
    }
}
