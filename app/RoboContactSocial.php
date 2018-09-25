<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoboContactSocial extends Model
{
    //
    protected $table = 'robo_contact_social';

    
   public function contact(){
       
    return $this->belongsTo('App\RoboContact');
}
}
