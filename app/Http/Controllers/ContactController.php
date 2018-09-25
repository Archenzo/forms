<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RoboContact;
use App\RoboContactSocial;

class ContactController extends Controller
{
    //
    public function index()
    {
        //$app_id = $this->session->get('auth-identity')['id'];

        return view('contact');
        $app_id =1;



        //$onload_data = \RoboContact::findFirst(["application_id = '$app_id'"]);
        $onload_data = RoboContact::where('application_id',$app_id)->first();

        $this->view->jsondata = $onload_data;

        //retrieve data from form
        if (($this->request->isPost())) {

            if($onload_data){
               // $form_data =\RoboContact::findFirst(["application_id = '$app_id'"]);
                $form_data = RoboContact::where('application_id',$app_id)->first();
            }else{
                $form_data = new RoboContact();
            }

            $form_data->application_id=$app_id;
            //$form_data->module_id
            $form_data->page_name = $this->request->getPost('title_ar');
            $form_data->page_name_en = $this->request->getPost('title_en');
            $form_data->page_description = $this->request->getPost('description_ar');
            $form_data->page_description_en = $this->request->getPost('description_en');
            $form_data->address = $this->request->getPost('address_ar');
            $form_data->address_en = $this->request->getPost('address_en');
            $form_data->coordinates_latitude = $this->request->getPost('coordinates_latitude');
            $form_data->coordinates_longitude = $this->request->getPost('coordinates_longitude');
            $form_data->active = $this->request->getPost('active');

            $form_data->image_title = $this->request->getPost('image_title');
            $form_data->image_alt = $this->request->getPost('image_alt');
            $form_data->info_email = $this->request->getPost('email');
            $form_data->info_telephone = $this->request->getPost('telephone');
            $form_data->info_mobile = $this->request->getPost('mobile');
            $form_data->info_fax = $this->request->getPost('fax');


            //set active status
            if($this->request->getPost('active')){

                $form_data->active = 1;
            }else {
                $form_data->active = 0;
            }

            //upload image if found
            if ($this->request->hasFiles() && $_FILES['image']['name'] != '') {
                //$baseLocation = 'files/';
                $baseLocation = 'images/';


                foreach ($this->request->getUploadedFiles() as $file) {

                    //compare image name from element and from file array if there is more than one upload element then Move the file into the application
                    if($_FILES['image']['name'] == $file->getName() && $file->moveTo($baseLocation . $file->getName()))
                    {
                        $form_data->image = $this->config->application->baseUri.$baseLocation.$file->getName();
                    }

                }
            }

            $form_data->save();


            $sid=$this->request->getPost('s_id');
            if (!$sid) {

                $social_form_data = new RoboContactSocial();

            }else{
               // $social_form_data=\RoboContactSocial::findFirst(["application_id = :app_id: and id = :sid:","bind" =>['app_id'=>$app_id,'sid'=>$sid]]);
                $social_form_data= RoboContactSocial::where('application_id',$app_id)->where('id',$sid)->first();
            }


            $social_form_data->application_id=$app_id;
            //$social_form_data->module_id
            $social_form_data->social_title = $this->request->getPost('social_title');
            $social_form_data->social_link = $this->request->getPost('social_link');
            $social_form_data->icon_code = $this->request->getPost('icon_code');
           // $social_form_data->icon_image =$this->request->getPost('icon_image');
           
           if ($this->request->hasFiles() && $_FILES['icon_image']['name'] != '') {
            //$baseLocation = 'files/';
            $baseLocation = 'images/';

            foreach ($this->request->getUploadedFiles() as $file) {

                //compare image name from element and from file array if there is more than one upload element then Move the file into the application
                if($_FILES['icon_image']['name'] == $file->getName() && $file->moveTo($baseLocation . $file->getName()))
                {
                    $social_form_data->icon_image  = $this->config->application->baseUri.$baseLocation.$file->getName();
                }

            }
        }
           
           if($social_form_data->social_title!=null || $social_form_data->social_link !=null || $social_form_data->icon_code !=null || $social_form_data->icon_image !=null){
                $social_form_data->save();
            }
            return $this->response->redirect($this->url->getStatic('contact/index'));
        }

        //$social_accounts = \RoboContactSocial::find(["application_id = :app_id:","bind"=>["app_id"=>$app_id]]);
        $social_accounts = RoboContactSocial::where('application_id',$app_id)->get();
        $this->view->accounts = $social_accounts;



    }

    public function editsocial(){
        // $this->view->disable();

        $sid= $this->request->getPost('sid');
        $this->sid=$sid;
        $response_array = [];
        if($sid){
           // $accounts_data= \RoboContactSocial::findFirst(["id = :sid:","bind"=>['sid'=>$sid]]);
            $accounts_data= RoboContactSocial::where('id',$sid)->first();

            $response_array = ['status' => 1,'accounts_data' => $accounts_data];
        }
        return json_encode($response_array);

    }

}
