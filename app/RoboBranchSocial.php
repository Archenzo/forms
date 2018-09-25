<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RobobranchSocial extends Model
{
    //
    protected $table = 'robo_branch_edit_social';

    
   public function branches(){
       
    return $this->belongsTo('App\RoboBranch');
}


}
