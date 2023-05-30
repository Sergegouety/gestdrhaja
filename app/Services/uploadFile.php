<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Illuminate\Support\Facades\File;

class uploadFile
{

   private $directory;
    /**
     * Send SMS
     *
     * @param  $phone
     * @param  $message
     * @return void
     */


     /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @param $directory
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
    }



    public function upload(Request $request,$filename)
    {

      //$this->setDirectory('docs');

      try
      {

          $file = $request->file($filename);
          $namefile = 'docs_' . uniqid() . '.' . $file->getClientOriginalExtension();
          $path = public_path('docs/'.$filename);
          if(!File::isDirectory($path)){
              File::makeDirectory($path, 0777, true, true);
          }
          $file->move($path, $namefile);

       //$file = $request->file($filename);
        //$file = $file ? $request->file($filename)->store($this->getDirectory()) : " ";
      }
      catch(Exception $e)
      {
              //DB::rollback();
              \Log::debug('Erreur lors de l\'upload' .$e->getMessage());
              Session::flash('error',"Une erreur s'est produite lors du chargmement des fichiers Réessayer svp");
              echo $e->getMessage();

              return Redirect::back();
      }

      return $filename.'/'.$namefile;
      
    }

    public function uploadMultiple($file,$repertoire)
    {

      try
      {

          //$file = $request->file($filename);

          $namefile = 'docs_' . uniqid() . '.' . $file->getClientOriginalExtension();
          $path = public_path('docs/'.$repertoire);
          if(!File::isDirectory($path)){
              File::makeDirectory($path, 0777, true, true);
          }
          $file->move($path, $namefile);
      }
      catch(Exception $e)
      {
              //DB::rollback();
              \Log::debug('Erreur lors de l\'upload' .$e->getMessage());
              Session::flash('error',"Une erreur s'est produite lors du chargmement des fichiers Réessayer svp");
              echo $e->getMessage();

              return Redirect::back();
      }

      return $repertoire.'/'.$namefile;
      
    }


}
