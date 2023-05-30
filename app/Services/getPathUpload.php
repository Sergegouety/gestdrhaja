<?php
namespace App\Services;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\File;

class getPathUpload
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
      try
      {
          $file = $request->file($filename);
          $namefile = 'docs_' . uniqid() . '.' . $file->getClientOriginalExtension();
          $path = public_path('docs/'.$filename);
          if(!File::isDirectory($path)){
              File::makeDirectory($path, 0777, true, true);
          }
          $file->move($path, $namefile);
          return $path;
      }
      catch(Exception $e)
      {
        dd($e->getMessage());
         \Log::debug('Erreur lors de l\'upload' .$e->getMessage());
      }
      
    }


}
