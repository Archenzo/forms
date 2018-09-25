<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Robobranch;
use App\RobobranchSocial;

class BranchController extends Controller
{
    public function index($id = null)
    {
        //$app_id = $this->session->get('auth-identity')['id'];
        $app_id = 1;

        if ($id != null) {

            // $form_data = \RoboBranchEdit::findFirst([
            //     'application_id = :app_id: and id = :id:',
            //     'bind' => [
            //         'id' => $id,
            //         'app_id' => $app_id
            //     ]
            // ]);

            $form_data = RoboBranch::where('id',$id)->where('application_id',$app_id)->first();
            
        } else {

            $form_data = new RoboBranch();
        }

        if ($this->request->isPost()) {

            $form_data->application_id = $app_id;
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
            if ($request->post('active')) {

                $form_data->active = 1;
            } else {
                $form_data->active = 0;
            }

            //upload image if found
            if ($request->hasFile('image') && $_FILES['image']['name'] != '') {
                $baseLocation = 'images/';

                foreach ($request->getUploadedFiles() as $file) {
                    //compare image name from element and from file array if there is more than one upload element then Move the file into the application
                    if ($_FILES['image']['name'] == $file->getName() && $file->moveTo($baseLocation . $file->getName())) {
                        $form_data->image = $this->config->application->baseUri.$baseLocation . $file->getName();
                    }
                }
            }
            //social data part
            if ($form_data->save()) {
             //  echo "SAVE";die;
                $id = $form_data->id;

             $sid=$request->post('s_id');
               if (!$sid) {

                    $onload_social_data = new RoboBranchSocial();

              }else{
                     //  echo $sid;die;
                //    $onload_social_data= RoboBranchEditSocial::findFirst([
                //        'id = :sid:',
                //        'bind' => [
                //            'sid' => $sid
                //        ]
                //    ]);

                $onload_social_data= RoboBranchSocial::where('id',$sid)->first();
               }
                $onload_social_data->application_id = $app_id;
                // $$onload_social_data->module_id
                $onload_social_data->bid = $id;
                $onload_social_data->social_title = $request->post('social_title');
                $onload_social_data->social_link = $request->post('social_link');
                $onload_social_data->icon_code = $request->post('icon_code');
               // $onload_social_data->icon_image = $this->request->getPost('icon_image');
                //dump($onload_social_data);die;
                
                if ($request->hasFile() && $_FILES['icon_image']['name'] != '') {
                    //$baseLocation = 'files/';
                    $baseLocation = 'images/';
      
                    foreach ($this->request->getUploadedFiles() as $file) {
      
                        //compare image name from element and from file array if there is more than one upload element then Move the file into the application
                        if($_FILES['icon_image']['name'] == $file->getName() && $file->moveTo($baseLocation . $file->getName()))
                        {
                            $onload_social_data->icon_image = $this->config->application->baseUri.$baseLocation.$file->getName();
                        }
      
                    }
                }
              
              
              
                if($onload_social_data->social_title!=null || $onload_social_data->social_link !=null || $onload_social_data->icon_code !=null || $onload_social_data->icon_image !=null) {

                    $onload_social_data->save();

                }

            }
            return redirect('branch');
        }
        $this->view->jsondata = $form_data;
       // $social_accounts = \RoboBranchEditSocial::find(["bid = :id:","bind"=>["id"=>$id]]);
        $social_accounts = RoboBranchSocial::where('id',$id)->get();
        $this->view->accounts = $social_accounts;
    }

    public function editsocial(){
       // $this->view->disable();

       $sid= $this->request->getPost('sid');
        $this->sid=$sid;
         $response_array = [];
        if($sid){
            //$accounts_data= \RoboBranchEditSocial::findFirst(["id = :sid:","bind"=>['sid'=>$sid]]);
            $accounts_data= RoboBranchSocial::where('id',$sid)->first();
            
               $response_array = ['status' => 1,'accounts_data' => $accounts_data];
        }
        return json_encode($response_array);

    }

}
