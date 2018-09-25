<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Robobranch extends Model
{
    //
    protected $table = 'robo_branch_edit';



    
   public function branchesSocial(){
       
    return $this->hasMany('App\RoboBranchSocial');
}
}
