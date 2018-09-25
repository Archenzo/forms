<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoboAboutSocial extends Model
{
    //
    protected $table = 'robo_about_social';
    public $timestamps = false;
    
   public function about(){
       
    return $this->belongsTo('App\RoboAbout');
}
}
