<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['code', 'name', 'url', 'image_url'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('type')->withTimestamps();
    }
    
    public function item_user()
    {
        return $this->items()->where('type', 'alert');
    }
    
    public function alerteds()
    {
        return $this->items()->where('type', 'alert');
    }

    public function want_users()
    {
        return $this->users()->where('type', 'want');
    }

    public function have_users()
    {
        return $this->users()->where('type', 'have');
    }    

    public function alert_users()
    {
        return $this->users()->where('type', 'alert');
    }      
}