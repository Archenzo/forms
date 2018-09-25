<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RoboMission;

class MissionController extends Controller
{
    //
    public function index()
    {
       // $app_id = $this->session->get('auth-identity')['id'];
       return view('mission');
        $app_id =1;



        //$onload_data = \RoboMission::findFirst(["application_id = '$app_id'"]);
        $onload_data = RoboMission::where('application_id',$app_id)->first();

        $this->view->jsondata = $onload_data;

        //retrieve data from form
        if (($this->request->isPost())) {
            // dump($_POST);die;


            if($onload_data){
               // $form_data =\RoboMission::findFirst(["application_id = '$app_id'"]);
                $form_data =RoboMission::where('application_id',$app_id)->first();
            }else{
                $form_data = new RoboMission() ;
            }

            $form_data->application_id=$app_id;
            //$form_data->module_id
            $form_data->page_name = $this->request->getPost('title_ar');
            $form_data->page_name_en = $this->request->getPost('title_en');
            $form_data->page_description = $this->request->getPost('description_ar');
            $form_data->page_description_en = $this->request->getPost('description_en');
            $form_data->active = $this->request->getPost('active');

            $form_data->image_title = $this->request->getPost('image_title');
            $form_data->image_alt = $this->request->getPost('image_alt');

            //set active status
            if($this->request->getPost('active')){

                $form_data->active = 1;
            }else {
                $form_data->active = 0;
            }

            //upload image if found
            if ($this->request->hasFiles()) {

                $baseLocation = 'images/';

                foreach ($this->request->getUploadedFiles() as $file) {

                    //Move the file into the application
                    if($file->moveTo($baseLocation . $file->getName()))
                    {
                        $form_data->image = $this->config->application->baseUri.$baseLocation.$file->getName();
                    }
                }
            }

            $form_data->save();

            return $this->response->redirect($this->url->getStatic('mission/index'));
        }

    }
}
