<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RoboAbout;
use App\RoboAboutSocial;
use App\Robobranch;
use App\RobobranchSocial;
use App\RoboContact;
use App\RoboContactSocial;
use App\RoboMission;
use App\RoboVision;


class ApiController extends Controller
{
    //
    public $application_id=1;

    public function index(){
       
        $this->getAll();

    }

    public function getBranches(){

        $data=Robobranch::where('application_id',$this->application_id)->get();
                            
       // dd($data);                        
           
        if($data) {
           
                            $branch=array();
                         
                            foreach ($data as $result) {

                               //  dd($result['page_name']);                 
                               $branch['id'] = $result['id'];
                               $branch['name'] = $result['page_name'];
                               $branch['title_en'] = $result['page_name_en'];
                               $branch['description'] = $result['page_description'];
                               $branch['description_en'] = $result['page_description_en'];
                               $branch['image'] = $result['image'];
                               $branch['image_title'] = $result['image_title'];
                               $branch['image_alt'] = $result['image_alt'];
                               $branch['email'] = $result['info_email'];
                               $branch['tel'] = $result['info_telephone'];
                               $branch['fax'] = $result['info_fax'];
                               $branch['mob'] = $result['info_mobile'];
                               $branch['address'] = $result['address'];
                               $branch['address_en'] = $result['address_en'];
                               $branch['coordinates_longitude'] = $result['coordinates_longitude'];
                               $branch['coordinates_latitude'] = $result['coordinates_latitude'];
            
                           $social_account = array();

                           $social_data = RoboBranchSocial::where('application_id',$this->application_id)->where('id',$result['id'])->get();

                               if(count($social_data)) {
                                $social_accounts = [];
                               foreach ($social_data as $socialinfo) {
            
                                   $socialinfo = get_object_vars($socialinfo);
                                   $social_account['social_title'] = $socialinfo['social_title'];
                                   $social_account['social_link'] = $socialinfo['social_link'];
                                   $social_account['icon_image'] = $socialinfo['icon_image'];
                                   $social_account['icon_code'] = $socialinfo['icon_code'];
                                    $social_accounts[] = $social_account;

            
                               }
                                   $branch['social'] = $social_accounts;
                                   }else {
                                       $social_account['social_title'] = "";
                                       $social_account['social_link'] = "";
                                       $social_account['icon_image'] = "";
                                       $social_account['icon_code'] = "";
                                       
                                   $branch['social'][] = $social_account;
                                   }
            
                               $this->json['Data']['places'][] = $branch;
                               }
            
                       }  else {
                           $branch['title'] = "";
                           $branch['title_en'] = "";
                           $branch['description'] = "";
                           $branch['description_en'] ="";
                           $branch['image']="";
                           $branch['image_title'] = "";
                           $branch['image_alt'] = "";
                           $branch['email'] = "";
                           $branch['telephone'] = "";
                           $branch['fax'] = "";
                           $branch['mobile'] = "";
                           $branch['address'] ="";
                           $branch['address_en'] = "";
                           $branch['coordinates_longitude'] = "";
                           $branch['coordinates_latitude'] = "";
            
                           $social_account['social_title'] = "";
                           $social_account['social_link'] = "";
                           $social_account['icon_image'] = "";
                           $social_account['icon_code'] = "";
                           
                           $this->json['Data']['places'] = $branch;
                           $this->json['Data']['places']['social'][] = $social_account;
            
                       }

    }

    public function getVision(){

        //$data = RoboVision::findFirst(["application_id = :application_id:","bind"=>['application_id'=>$application_id]]);
        $data = RoboVision::where('application_id',$this->application_id)->first();
          // dd($data);
        if($data) {
            
   
            $result['id'] = $data['id'];
            $result['name'] = $data['page_name'];
            $result['name_en'] = $data['page_name_en'];
            $result['content'] = $data['page_description'];
            $result['content_en'] = $data['page_description_en'];
            $result['image'] = $data['image'];
            $result['image_title'] = $data['image_title'];
            $result['image_alt'] = $data['image_alt'];
   
   
        }else {
            $result['id'] = "";
            $result['name'] = "";
            $result['name_en'] = "";
            $result['content'] = "";
            $result['content_en'] = "";
            $result['image'] = "";
            $result['image_title'] = "";
            $result['image_alt'] = "";
   
            //echo "not found";
        }
        $this->json['Data']['info']['vision']=$result;

    }

    public function getMission(){

        //$data = \RoboMission::findFirst(["application_id = :application_id:", "bind" => ['application_id' => $application_id]]);
        $data = RoboMission::where('application_id',$this->application_id)->first();

        if ($data) {

        $result['id'] = $data['id'];
        $result['name'] = $data['page_name'];
        $result['name_en'] = $data['page_name_en'];
        $result['content'] = $data['page_description'];
        $result['content_en'] = $data['page_description_en'];
        $result['image'] = $data['image'];
        $result['image_title'] = $data['image_title'];
        $result['image_alt'] = $data['image_alt'];

        //echo json_encode($result);
    }else{
            $result['id'] = "";
            $result['name'] = "";
            $result['name_en'] = "";
            $result['content'] = "";
            $result['content_en'] = "";
            $result['image'] = "";
            $result['image_title'] = "";
            $result['image_alt'] = "";
       // echo "not found";
        }
        $this->json['Data']['info']['mission']=$result;

    }

    public function getAbout(){

        //$data = \RoboAbout::findFirst(["application_id = :application_id:", "bind" => ['application_id' => $application_id]]);
        $data = RoboAbout::where('application_id',$this->application_id)->first();

        if($data) {
         
          $result = $data;
          $about['title'] = $result['page_name'];
          $about['title_en'] = $result['page_name_en'];
          $about['content'] = $result['page_description'];
          $about['content_en'] = $result['page_description_en'];
          $about['link']="";
          $about['image'] = $result['image'];
          $about['image_title'] = $result['image_title'];
          $about['image_alt'] = $result['image_alt'];
          $about['email'] = $result['info_email'];
          $about['telephone'] = $result['info_telephone'];
          $about['fax'] = $result['info_fax'];
          $about['mobile'] = $result['info_mobile'];
          $about['address'] = $result['address'];
          $about['address_en'] = $result['address_en'];
         $about['coordinates_longitude'] = $result['coordinates_longitude'];
         $about['coordinates_latitude'] = $result['coordinates_latitude'];
         
          $this->json ['Data']['info']['about'] = $about;


          //$social_data = \RoboAboutSocial::find(["application_id = :application_id:", "bind" => ["application_id" => $application_id]]);
          $social_data = RoboAboutSocial::where('application_id',$this->application_id)->get();

            $social_account = array();

            if(count($social_data)) {

            foreach ($social_data as $social) {

                $social_account['name'] = $social['social_title'];
                $social_account['url'] = $social['social_link'];
                $social_account['image'] = $social['icon_image'];
                $social_account['icon_code'] = $social['icon_code'];
                //var_dump($social_account);die;
                $this->json['Data']['info']['about']['social_links'][] = $social_account;
            }
              } else{
                  $social_account['name'] ="";
                  $social_account['url'] = "";
                  $social_account['image'] = "";
                  $social_account['icon_code'] = "";
                $this->json['Data']['info']['about']['social_links'] = $social_account;


            }



          //echo json_encode($json);
      }else{
            $about['title'] = "";
            $about['title_en'] = "";
            $about['content'] = "";
            $about['content_en'] = "";
            $about['link']="";
            $about['image'] = "";
            $about['image_title'] = "";
            $about['image_alt'] = "";
            $about['email'] = "";
            $about['telephone'] = "";
            $about['fax'] = "";
            $about['mobile'] = "";
            $about['address'] = "";
            $about['address_en'] = "";
            $about['coordinates_longitude'] = "";
            $about['coordinates_latitude'] = "";
          //  $about['coordinate']= "";
            $this->json['Data']['info']['about'] = $about;


            $social_account['social_title'] = "";
            $social_account['social_link'] = "";
            $social_account['icon_image'] = "";
            $social_account['icon_code'] = "";

            $this->json['Data']['info']['about']['social_links'] = $social_account;
            //echo"not found";
      }


    }

     public function getContact(){

        //$data = \RoboContact::findFirst(["application_id = :application_id:","bind" =>['application_id'=>$application_id]]);
        $data = RoboContact::where('application_id',$this->application_id)->first();
        if($data) {

            $result = $data;
            $contact['title'] = $result['page_name'];
            $contact['title_en'] = $result['page_name_en'];
            $contact['description'] = $result['page_description'];
            $contact['description_en'] = $result['page_description_en'];
            $contact['image'] = $result['image'];
            $contact['image_title'] = $result['image_title'];
            $contact['image_alt'] = $result['image_alt'];
            $contact['email'] = $result['info_email'];
            $contact['telephone'] = $result['info_telephone'];
            $contact['fax'] = $result['info_fax'];
            $contact['mobile'] = $result['info_mobile'];
            $contact['address'] = $result['address'];
            $contact['address_en'] = $result['address_en'];
            $contact['coordinates_longitude'] = $result['coordinates_longitude'];
            $contact['coordinates_latitude'] = $result['coordinates_latitude'];

            $this->json['Data']['info']['contact'] = $contact;
            
            //$social_data = \RoboContactSocial::find(["application_id = :application_id:", "bind" => ["application_id" => $application_id]]);
            $social_data = RoboContactSocial::where('application_id',$this->application_id)->get();
            
            $social_account = array();
            //$social_data=get_object_vars($social_data);
            if(count($social_data)) {
                foreach ($social_data as $social) {
                   
                    $social_account['social_title'] = $social['social_title'];
                    $social_account['social_link'] = $social['social_link'];
                    $social_account['icon_image'] = $social['icon_image'];
                    $social_account['icon_code'] = $social['icon_code'];

                    $this->json['Data']['info']['contact_social'][] = $social_account;
                }
            }else{
                $social_account['social_title'] = "";
                $social_account['social_link'] = "";
                $social_account['icon_image'] ="";
                $social_account['icon_code'] = "";

                $this->json['Data']['info']['contact_social'] = $social_account;
            }


            //echo json_encode($json);
        }else{

            $contact['title'] ="";
            $contact['title_en'] = "";
            $contact['description'] = "";
            $contact['description_en'] = "";
            $contact['image'] = "";
            $contact['image_title'] = "";
            $contact['image_alt'] = "";
            $contact['email'] = "";
            $contact['telephone'] = "";
            $contact['fax'] = "";
            $contact['mobile'] = "";
            $contact['address'] = "";
            $contact['address_en'] = "";
            $contact['coordinates_longitude'] = "";
            $contact['coordinates_latitude'] = "";
            //$contact['coordinate']="";
            $this->json['Data']['info']['contact'] = $contact;

            $social_account['social_title'] = "";
            $social_account['social_link'] = "";
            $social_account['icon_image'] = "";
            $social_account['icon_code'] = "";
            $this->json['Data']['info']['contact_social'] = $social_account;
           // echo "not found";
        }


     }
     public function getFaq(){
        $faq = array(
            array('question'=>'What is Lorem Ipsum?','answer'=>'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum'),
            array('question'=>'Where does it come from?','answer'=>'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of de Finibus Bonorum et Maloru (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, Lorem ipsum dolor sit amet.., comes from a line in section 1.10.32. The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from de Finibus Bonorum et Malorum by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.'),
            array('question'=>'ما هو لوريم ايبسوم?','answer'=>'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل ليتصور طريقه وضع النصوص بالتصاميم سواء كانت تصاميم مطبوعه ... بروشور او فلاير على سبيل المثال ... او نماذج مواقع انترنت ... وعند موافقه العميل المبدئيه على التصميم يتم ازالة هذا النص من التصميم ويتم وضع النصوص النهائية المطلوبة للتصميم ويقول البعض ان وضع النصوص التجريبية بالتصميم قد تشغل المشاهد عن وضع الكثير من الملاحظات او الانتقادات للتصميم الاساسي. وخلافاَ للاعتقاد السائد فإن لوريم إيبسوم ليس نصاَ عشوائياً، بل إن له جذور في الأدب اللاتيني الكلاسيكي منذ العام 45 قبل الميلاد. من كتاب "حول أقاصي الخير والشر"'));
       $fa_questions = array();
       foreach ($faq as $aq){ 
       $fa_questions['question']=$aq['question'];
       $fa_questions['answer']=$aq['answer'];
      
       $this->json['Data']['info']['faq'][]=$fa_questions;    
   }
       
   }
   
   public function getWeb(){
    $webpage=array(
        array('id'=>'1','url'=>'https://www.google.com/'),
        array('id'=>'2','url'=>'https://www.facebook.com/')
    
    );
    $string='dfdsdfsdf<br><div class="container"><b>fdgdfssssss</b></div>';
    $string=strip_tags($string);



     $string2='<div class="page-content">
     <div class="page-bar " style="position: relative">
         <ul class="page-breadcrumb">
             <li>
                 <i class="fa fa-home" aria-hidden="true"></i>
                 <a href="index.html"><span> الرئيسية </span></a>
                 <i class="fa fa-angle-left" aria-hidden="true"></i>
             </li>
             <li>
                 <span> الفروع </span>
             </li>
         </ul>
     </div>
     <div class="clearfix"></div>
     <div class="col-lg-12">
         <div class="row">
             <div class="col-lg-8 col-lg-offset-2 col-md-12 col-xs-12 hidden-xs">
                 
             </div>
         </div>
     </div>
 
 
     <div class="portlet light clearfix">
         <div class="portlet-title">
             <div class="caption font-dark">
                 <i class="fa fa-globe font-dark"></i>
                 <span class="caption-subject bold uppercase"> الفروع
                             </span>
             </div>
             <div class="actions">
                
                     <span aria-hidden="true" class="icon-plus"></span>
                     إضافة فرع
                 </a>
 
             </div>
         </div>
         <div class="portlet-body">
             <div class="row">
                 <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                     <thead>
                     <tr>
                         <th>
                             <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                 <input type="checkbox" class="group-checkable"
                                        data-set="#sample_1 .checkboxes"/>
                                 <span></span>
                             </label>
                         </th>
                         <th> م </th>
                         <th> اسم الفرع </th>
                         <th> اخر تعديل </th>
                         <th> تفعيل</th>
                         <th> الاجراءات </th>
                     </tr>
                     </thead>
                     <tbody>
                     
 
                         <tr id="" class="odd gradeX">
                             <td>
                                 <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                     <input type="checkbox" class="checkboxes" value=""/>
                                     <span></span>
                                 </label>
                             </td>
                             <td>a</td>
                             <td>b </td>
                             {#<td> c </td>#}
                             <td> 12/8/2018 </td>
                             <td>
                                
                                     <span class="text-center"><i class="fa fa-check-circle-o text-success"></i> مفعل</span>
                                 
                                     <span class="text-center"><i class="fa fa-check-circle-o text-success"></i> غير مفعل</span>

                             </td>
                             <td>
                                 {#<a href="page_branch_edit.html" class="btn btn-xs btn-success"> <i class="fa fa-pencil" aria-hidden="true"></i> </a>#}
                                
                                 <button class="btn btn-xs btn-danger delete_specific"  data-branch_id="xxxx"> <i class="fa fa-trash-o" aria-hidden="true" ></i> </button>
                             </td>
                         </tr>

                     </tbody>
                 </table>
                 <button id="delete_selected" class="btn btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i>حذف المحدد</button>
             </div>
 
         </div>
     </div>
 
     <div class="clearfix"></div>
     <!-- END DASHBOARD -->
 </div>';

   // $string2=urlencode($string2);
   
 //   $string2=htmlspecialchars($string2);
   $webcontent=array(
       array(
           'id'=>'1',
           'content'=>$string
       )
/*
array(
           'id'=>'1',
           'content'=>'dfdsdfsdf<br>
          <div class=\"container\">
          <b>fdgdfgdfgd<\/ b><\/ div>'
       )
*/

          ,
        array(
            'id'=>'2',
             'content'=>$string2
        )
);
   $pages =array();
foreach ($webpage as $page){ 
    $pages['id']=$page['id'];
    $pages['url']=$page['url'];
    
    $this->json['Data']['info']['webpages'][]=$pages;
}
  
$contents =array();
foreach ($webcontent as $content){ 
    $contents['id']=$content['id'];
    $contents['content']=$content['content'];
    
    $this->json['Data']['info']['webcontent'][]=$contents;
}

}

public function getPdf(){
        $pdfarray=array(
          array(
             'id'=>'1', 
             'pdf_link'=>'www.google.com'
          ),
          array(
            'id'=>'2', 
            'pdf_link'=>'https://www.scribd.com/doc/106199759/PHP-Tutorial-w3schools-pdf'
         )

        );
        $pdfinfo=array();
        foreach($pdfarray as $pdf){
            $pdfinfo['id']=$pdf['id'];
            $pdfinfo['pdf_link']=$pdf['pdf_link'];

            $this->json['Data']['info']['pdf'][]=$pdfinfo;
        }

}
   
   
   
    public function getAll(){


        $this->json['Status']=[];
      $this->getAbout();
      $this->getVision();
      $this->getMission();
      $this->getContact();

      $this->getBranches();
      $this->getFaq();
      //$this->getWeb();
      $this->getPdf();
      $this->json['products']= [];
     // $this->json['service']= new stdClass();
      echo json_encode($this->json);

}
}
