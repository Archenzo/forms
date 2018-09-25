<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoboContact extends Model
{
    //
    protected $table = 'robo_contact';

    
   public function contactSocial(){
       
    return $this->hasMany('App\RoboContactSocial');
}
}
