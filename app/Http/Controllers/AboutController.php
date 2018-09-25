<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\RoboAbout;
use App\RoboAboutSocial;
class AboutController extends Controller
{
    //

    public function index(Request $request)
    {

        $app_id = 1;

        
        $onload_data = RoboAbout::where('application_id',$app_id)->first();
 // dd($onload_data);

      if ($request->method()=='POST') {

           if($onload_data||true){
            
               $form_data = RoboAbout::where('application_id',$app_id)->first();
           }else{
               $form_data = new RoboAbout() ;
           }
         
            $form_data->application_id=$app_id;
            //$form_data->module_id
            $form_data->page_name = $request->post('title_ar');
            $form_data->page_name_en = $request->post('title_en');
            $form_data->page_description = $request->post('description_ar');
            $form_data->page_description_en = $request->post('description_en');
            $form_data->address = $request->post('address_ar');
            $form_data->address_en = $request->post('address_en');
            $form_data->coordinates_latitude = $request->post('coordinates_latitude');
            $form_data->coordinates_longitude = $request->post('coordinates_longitude');
            $form_data->active = $request->post('active');

            $form_data->image_title = $request->post('image_title');
            $form_data->image_alt = $request->post('image_alt');
            $form_data->info_email = $request->post('email');
            $form_data->info_telephone = $request->post('telephone');
            $form_data->info_mobile = $request->post('mobile');
            $form_data->info_fax = $request->post('fax');

            //set active status
           if($request->post('active')){

               $form_data->active = 1;
           }else {
               $form_data->active = 0;
           }
         
           //upload image if found
        
           if ($request->hasFile('image') && $_FILES['image']['name'] != '') {
           
            $request->image->store('/public/images');   
          
               $baseLocation = url('/').'/storage/images/'.$request->image->hashName();
        
            $form_data->image=$baseLocation;
           }
           //dd($_POST);        
           $form_data->save();

           $sid=$request->post('s_id');
          if (!$sid) {

              $social_form_data = new RoboAboutSocial();

          }else{
             
              $social_form_data= RoboAboutSocial::where('application_id',$app_id)->where('id',$sid)->first();
          }


          $social_form_data->application_id=$app_id;
          //$social_form_data->module_id
          $social_form_data->social_title = $request->post('social_title');
          $social_form_data->social_link = $request->post('social_link');
          $social_form_data->icon_code = $request->post('icon_code');


          if ($request->hasFile('icon_image') && $_FILES['icon_image']['name'] != '') {
                          
               $request->icon_image->store('/public/images');   
          
               $baseLocation = url('/').'/storage/images/'.$request->icon_image->hashName();
               $social_form_data->icon_image  =$baseLocation;

          }


          if($social_form_data->social_title!=null || $social_form_data->social_link !=null || $social_form_data->icon_code !=null || $social_form_data->icon_image !=null){

              $social_form_data->save();
          }
          
        return redirect('about');  

      }

        $social_accounts = RoboAboutSocial::where('application_id',$app_id)->get();
       
        return view('about',array('jsondata'=>$onload_data,'social_accounts'=>$social_accounts));
    }


    public function editSocial($id){

        $sid= $request->post('sid');
        $this->sid=$sid;
        $response_array = [];
        if($sid){
            //$accounts_data= \ RoboAboutSocial::findFirst(["id = :sid:","bind"=>['sid'=>$sid]]);
            $accounts_data= RoboAboutSocial::where('id',$sid)->first();

            $response_array = ['status' => 1,'accounts_data' => $accounts_data];
        }
        return json_encode($response_array);

    }

    public function deleteSocial($id){
        
           $account_data=RoboAboutSocial::where('id',$id)->first();

           if($account_data->delete()){
              
            return redirect()->back()->with('successMsg','social account deleted');
           }
           return redirect()->back()->with('errorMsg','error');
    }


}
