<?php namespace App\Controllers;

class UsersController extends BaseController
{
 
   public function index(){
      
      return view('users');
   }

   public function fileUpload(){
      
      // Validation
      $input = $this->validate([
          'file' => 'uploaded[file]|max_size[file,1024]|ext_in[file,jpg,jpeg,docx,pdf],'
      ]);

      if (!$input) { // Not valid
          $data['validation'] = $this->validator; 
          return view('users',$data);  
      }else{ // Valid

          if($file = $this->request->getFile('file'))
          {
              if ($file->isValid() && ! $file->hasMoved())
              {
                  // Get file name and extension
                  $name = $file->getName();
                  $ext = $file->getClientExtension();

                  // Get random file name
                  $newName = $file->getRandomName(); 
                  
                  // Store file in public/uploads/ folder
                  $file->move('../public/uploads', $newName);
                  
                  // File path to display preview
                  $filepath = base_url()."/uploads/".$newName;
                  
                  session()->setFlashdata('message', 'Updated Successfully!');
                  session()->setFlashdata('alert-class', 'alert-success');
                  session()->setFlashdata('filepath', $filepath);
                  session()->setFlashdata('extension', $ext);

              }else{
                  session()->setFlashdata('message', 'Data not saved!');
                  session()->setFlashdata('alert-class', 'alert-danger');

              }
          }
      
      }

      return redirect()->route('/'); 
   }

   
}