<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use Carbon\Carbon;
use App\Models\Cour;
use Illuminate\Support\Facades\Redirect;
use App\Models\Demande;
use App\Models\Demande_details;
use App\Models\Stock;
use App\Models\Message;



class DirectionRepository
{

public function getByDirectionID($id)
        {
                 $sd  = DB::table('sousdirection')
                 ->where('direction_id','=',$id)
                 ->get();
                
                return $sd;
        }

        public function getBySousDirectionID($id)
        {
                 $serv  = DB::table('service')
                 ->where('sousdirection_id','=',$id)
                 ->get();
                
                return $serv;
        }


        public function getUserByOption($direction_id,$sousdirection_id,$service_id,$user_id)
       {

     $users =DB::table('users')
               ->join('agent_fonction','users.id','agent_fonction.user_id')
               ->select('users.id','users.nomprenoms','users.email','agent_fonction.direction_id','agent_fonction.sousdirection_id','agent_fonction.service_id')
               ->when($direction_id, function ($query, $direction_id) 
                                    {return $query->where('agent_fonction.direction_id', $direction_id);}
                                        )
               ->when($sousdirection_id, function ($query, $sousdirection_id) 
                                    {return $query->where('agent_fonction.sousdirection_id', $sousdirection_id);}
                                        )
               ->when($service_id, function ($query, $service_id) 
                                    {return $query->where('agent_fonction.service_id', $service_id);}
                                        )
               ->when($user_id, function ($query, $user_id) 
                                    {return $query->wherein('users.id', $user_id);}
                                        )
               
               ->get();
       
       
         return $users;
    
       } 



        public function storeMessage($sender_id,$destinataire,$sujet,$content,$mail_doc,$state)
    {

     $message = new Message();

            $message->sender_id = $sender_id;
            $message->destinataire_id = $destinataire;
            $message->sujet = $sujet;
            $message->contenu = $content;
            $message->document = $mail_doc;
            $message->state = $state;

            $message->save();
            
            return $message->id;
    }

     public function getMessagebyUser($destinataire,$type)
    {

     $message =DB::table('message')
               ->join('users','message.sender_id','users.id')
               ->select('message.id','message.sender_id','message.destinataire_id','message.sujet','message.contenu','message.created_at','message.state','users.nomprenoms','users.created_at')
               ->when($destinataire, function ($query, $destinataire) 
                                    {return $query->where('message.destinataire_id', $destinataire);}
                                        )
               ->when($type, function ($query, $type) 
                                    {return $query->where('message.state', $type);}
                                        )
               ->get();
       
       
         return $message;
    }

     public function getMessagebyId($id)
    {

     $message =DB::table('message')
               ->join('users','message.sender_id','users.id')
               ->select('message.id','message.sender_id','message.destinataire_id','message.sujet','message.contenu','message.document','message.created_at','message.state','users.nomprenoms','users.created_at')
               ->when($id, function ($query, $id) 
                                    {return $query->where('message.id', $id);}
                                        )
               ->first();
       
       
         return $message;
    }

     public function getMessageSentbyUser($sender,$type)
    {

     $message =DB::table('message')
               ->join('users','message.sender_id','users.id')
               ->select('message.id','message.sender_id','message.destinataire_id','message.sujet','message.contenu','message.document','message.created_at','message.state','users.nomprenoms','users.created_at')
               ->when($sender, function ($query, $sender) 
                                    {return $query->where('message.sender_id', $sender);}
                                        )
               ->when($type, function ($query, $type) 
                                    {return $query->where('message.state', $type);}
                                        )
               ->get();
       
       
         return $message;
    }
  





}

