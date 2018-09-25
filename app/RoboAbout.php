<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoboAbout extends Model
{
    //
    protected $table = 'robo_about';
    public $timestamps = false;
    public function aboutSocial(){
       
        return $this->hasMany('App\RoboAboutSocial');
    }
    
}
