<div class="row">
<form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('update.ptab.trim') }}">
  {{ csrf_field() }} 

   <input type="hidden" name="instance_id" id="instance_id" value="{{$ptab->id}}">
   <input type="hidden" name="t_id" id="t_id" value="{{$tid}}">
  <input type="hidden" name="trimestre" id="trimestre" value="4">
  <div class="modal-footer"></div>
                 <div class="row form-group" >
                    <label class="col-sm-2 col-sm-2 control-label" for="cible_t4">Cible 4ème Trim :</label>
                    <div class="col-sm-4">
                    <input type="text" class="form-control" name="cible_t4" id="cible_t4" value="{{$ptab->cible_t4}}" <?php if($isptabadmin==1 || $isptabHelper==1){echo '';}else{echo 'readonly';} ?>  >
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label">Coût 4ème Trim:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="cout_t4" id="cout_t4" value="{{$ptab->cout_t4}}" <?php if($isptabadmin==1 || $isptabHelper==1){echo '';}else{echo 'readonly';} ?>>
                  </div>

                </div>

                <div class="row form-group">
                    <label class="col-sm-2 col-sm-2 control-label" for="valeur_t4" >Valeur Trim 4 : 
                      <a id="add-without-image1" class="badge bg-warning" href="javascript:;">?</a>
                    </label>

                    <div class="col-sm-4" >
                    <textarea class="form-control" name="valeur_t4" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_readonly(4,$grade,$ptab->cible_t4,$ptab->user_id); } ?> >{{$ptab->valeur_t4}}</textarea>
                  </div>
                  
                </div>
<div class="modal-footer"></div>
                 <div class="modal-body ace-scrollbar">
                    
                    <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0">
                      <button type="button" onclick="addElement4()" class="btn btn-success radius-round">
                             <span class="fa fa-plus"></span>
                      </button>
                    </div>

                    <div class="col-sm-4 input-floating-label text-blue-d2 brc-blue-m1">
                       <input type="file" class="form-control" name="livrable_t4[]" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_disables(4,$grade,$ptab->cible_t4,$ptab->user_id);} ?> >
                      <span class="floating-label text-grey-m3">
                        livrables/pièces justificatives  <span style="color:red;">Taille Max: 50 Mo</span>
                    </span>
                    </div>
                    <div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1">
                      <textarea class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="commentaire_lt4[]" placeholder="Commentaire" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_readonly(4,$grade,$ptab->cible_t4,$ptab->user_id); } ?>></textarea>
                    </div>
                  </div>
                  <div id="link_section4" >
                    
                  </div>
                  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-success" id="ajouter">
      Enregistrer
    </button>
  </div>
</form>
 @php 
        if($tid=='tache'){$type_id=3;}elseif($tid=='activite'){$type_id=2;}else{$type_id=1;}
        
        if($ptab->user_id == Auth::user()->id){ $autre_livrableT=getOtherLivrable($ptab->id,4,$type_id);  }
    else{$autre_livrableT=getOtherLivrableHierachie($ptab->id,4,$type_id); }

        $autre_livrable=getOtherLivrableState($ptab->id,4,$type_id,1);
        $i = 1;@endphp
<div class="modal-footer"></div>
<table class="table table-striped table-advance table-hover">
<h4 class="mb">Liste des livrables</h4>
@if(count($autre_livrable) && $ptab->user_id == Auth::user()->id)
 <a data-toggle="modal" data-target="#envoiModal4" class="btn btn-success" id="ajouter">
      Envoyer au superieux hiérachique
    </a>
  @endif
  <thead class="sticky-nav text-green-m1 text-uppercase text-85" >
          <tr>
            <th class="td-toggle-details border-0 bgc-white shadow-sm">
             #
            </th>

             <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
             Livrable
            </th>

            <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
              Commentaire
            </th>
            <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
              Statut
            </th>
            <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
              Action
            </th>
          </tr>
        </thead>
      <tbody class="pos-rel">
       
        @foreach($autre_livrableT as $livrable)
        <tr class="d-style bgc-h-orange-l4">
            <td>{{$i}}</td>
            <td><a href="{{asset('docs/'.$livrable->livrable)}}" target="_blank" title="Telecharger Livrable"><i class="fa fa-download"></i>
            </a></td>
            <td>{{$livrable->commentaire}}</td>
            <td><?php if($livrable->state== 0){echo 'en attente d\'envoi';}elseif($livrable->state== 1){echo 'envoyé au supérieur hiérachique';}elseif($livrable->state== -1){echo 'Livrable rejété';}else{echo 'Livrable Validé  ';} ?></td>
            <td>
              @if(count($autre_livrable))
              <button data-toggle="modal" data-target="#modifModal4" class="btn btn-primary btn-xs" onclick="modifLivrable({{$livrable->id}},'{{addslashes($livrable->commentaire)}}',4)"><i class="fa fa-pencil"></i></button>
              <button class="btn btn-danger btn-xs" onclick="deleteLivrable({{$livrable->id}})"><i class="fa fa-trash-o "></i></button>
              @endif
            </td>
      </tr>
      @php   $i++; @endphp
      @endforeach
    </tbody>

</table>

<br>
<div class="modal-footer"></div>
<table class="table table-striped table-advance table-hover">
<h4 class="mb">Liste des Statuts des livrables du 4ème trimestre</h4>
  <thead class="sticky-nav text-green-m1 text-uppercase text-85" >
    
          <tr>

            
            <th class="td-toggle-details border-0 bgc-white shadow-sm">
             #
            </th>

             <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
             Nom & Prenoms
            </th>

            <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
             Fonction
            </th>

            <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
             Statut Livrable
            </th>

            <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
             Statut Avancement
            </th>

            <th class="border-0 bgc-white bgc-h-orange-l3 shadow-sm">
              Commentaire
            </th>
          </tr>
        </thead>
      <tbody class="pos-rel">
        @php $autre_comments=getOtherCommentaire($ptab->id,4,$ptab->type_id);  $j = 1;@endphp
        @foreach($autre_comments as $comment)
        <tr class="d-style bgc-h-orange-l4">
            <td>{{$j}} </td>
            <td>{{ getInstanceName('users','id',$comment->user_id,'nomprenoms')}} </td>
            <td>{{$comment->user_level}}</td>
            <td><?php if($comment->statut_livrable== 0){echo 'en attente d\'envoi';}elseif($comment->statut_livrable== 1){echo 'envoyé au supérieur hiérachique';}elseif($comment->statut_livrable== -1){echo 'Livrable rejété';}else{echo 'Livrable Validé  ';} ?>
            </td>
            <td>@if($comment->statut_avancement==1) Non réalisé @elseif($comment->statut_avancement==2) Partiellement réalisé @else Réalisé @endif
            </td>
            <td>{{$comment->commentaire}}</td>
      </tr>
      @php   $j++; @endphp
      @endforeach
    </tbody>

</table>

<br>
<div class="modal-footer"></div>
@if( $ptab->user_id != Auth::user()->id)      
<form class="form-horizontal m-t-10 p-20 p-b-0" method="post" enctype="multipart/form-data" action="{{ route('update.ptab.commentaire') }}">
  {{ csrf_field() }} 

                      <input type="hidden" name="action_id" id="action_id" value="{{$ptab->id}}">
                      <input type="hidden" name="tid" id="tid" value="{{$tid}}">
                      <input type="hidden" name="trimestre" id="trimestre" value="4">
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Statut livrables/pièces justificatives :</label>
                    <div class="col-sm-2">
                     <select class="form-control" name="statut_t4" id="statut_t4" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_disables2(4,$grade,$ptab->cible_t4); } ?>>
                        <option value=""></option>
                      <option   value="2" <?php if($ptab->is_valide4=='2'){echo 'selected';} ?>>Valider</option>
                      <option   value="-1" <?php if($ptab->is_valide4=='-1'){echo 'selected';} ?>>Réjeter</option>
                    </select>
                    </div>
               <label class="col-sm-2 control-label">Etat d'avancement</label>
                    <div class="col-sm-3">
                     <select class="form-control" name="statut_avancement" id="statut_avancement" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_disables2(4,$grade,$ptab->cible_t4); } ?>  required > 
                        <option value=""></option>
                      <option <?php if($ptab->statut_t4=='3'){echo 'selected';} ?>  value="3">Réalisé</option>
                      <option <?php if($ptab->statut_t4=='2'){echo 'selected';} ?>  value="2">Partiellement Réalisé</option>
                      <option <?php if($ptab->statut_t4=='1'){echo 'selected';} ?>  value="1">Non Réalisé</option>
                    </select>
                    </div>
                    </div>
               
                 <div class="row form-group">
                 <label class="col-sm-3 control-label" for="observation_t1">Observation :</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="5" name="observation_t4" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_readonly2(4,$grade,$ptab->cible_t4); } ?> >{{$ptab->observation_t4}}</textarea>
                </div>
              </div>
@if($isptabadmin || ptab_gestion_rigth(Auth::user()->id))
              <div class="form-group">
                <label class="col-sm-2 control-label">Statut final</label>
                    <div class="col-sm-2">
                     <select class="form-control" name="statut_final" id="statut_final" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_disables2(4,$grade,$ptab->cible_t4); } ?>>
                        <option value=""></option>
                      <option <?php if($ptab->statut_t4=='3'){echo 'selected';} ?>  value="3">Réalisé</option>
                      <option <?php if($ptab->statut_t4=='2'){echo 'selected';} ?>  value="2">Partiellement Réalisé</option>
                      <option <?php if($ptab->statut_t4=='1'){echo 'selected';} ?>  value="1">Non Réalisé</option>
                    </select>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">Commentaire Final</label>
                    <div class="col-sm-6">
                      <textarea class="form-control" rows="5" name="commentaire_final" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_readonly2(4,$grade,$ptab->cible_t4); } ?> >{{$ptab->commentaire_t4}}</textarea>
                     
                    </div>
                 
                </div>
@endif
                <div class="modal-footer">
    <button type="submit" class="btn btn-success" id="ajouter">
      Enregistrer
    </button>
  </div>

</form>
@endif
                    </div>
        <div class="modal fade" id="envoiModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Vous êtes sur le point de valider vos traveaux et d'envoyer vos livrables au supérieur hiérachique, cette action est irréversible, voulez-vous confirmer?<span class="u_comment"></span> </h4>
                    </div>
                    <div class="modal-body">

                      <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{route('send.livrable')}}" enctype="multipart/form-data" id="arret_form">
                           {{ csrf_field() }} 
                           <input type="hidden" name="tid" id="tid" value="{{ $tid}}">
                           <input type="hidden" name="instance_id" id="instance_id" value="{{$ptab->id}}">
                           <input type="hidden" name="trimestre" id="trimestre" value="4">
                      
                        <div class="modal-body ace-scrollbar">

                  <div class="form-group">
                <label class="col-sm-4 control-label">Etat d'avancement</label>
                    <div class="col-sm-8">
                     <select class="form-control" name="statut_final" id="statut_final"  required > 
                        <option value=""></option>
                      <option <?php if($ptab->statut_t1=='3'){echo 'selected';} ?>  value="3">Réalisé</option>
                      <option <?php if($ptab->statut_t1=='2'){echo 'selected';} ?>  value="2">Partiellement Réalisé</option>
                      <option <?php if($ptab->statut_t1=='1'){echo 'selected';} ?>  value="1">Non Réalisé</option>
                    </select>
                    </div>

                </div>

                      </div>
                      <br>

                       <div class="form-group">
    
                    <label class="col-sm-4 col-sm-4 control-label">Commentaire</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" rows="5" name="commentaire" >{{$ptab->commentaire_t1}}</textarea>
                     
                    </div>
                 
                </div>

                      </div>

                       <div class="modal-footer">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">Non</button>
                        <button type="submit" class="btn btn-success" id="ajouter">
                          Oui
                        </button>
                      </div>


                  
                    </form>
                      
                    </div>
                    
                  </div>
                </div>
<div class="modal fade" id="modifModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Modifier livrable<span class="u_comment"></span> </h4>
              </div>
              <div class="modal-body">

                <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{route('modif.livrable')}}" enctype="multipart/form-data" id="arret_form">
                     {{ csrf_field() }} 
                     <input type="hidden" name="livrable_id4" id="livrable_id4">
            
              <div class="modal-body ace-scrollbar">

                   <div class="form-group">
                    <label class="col-sm-4 col-sm-4 control-label">livrables/pièces justificatives </span></label>
                        <div class="col-sm-8 input-floating-label text-blue-d2 brc-blue-m1">
                               <input type="file" class="form-control" name="livrable_t4" >
                               <span class="floating-label text-grey-m3">
                               <span style="color:red;">Taille Max: 50 Mo</span>
                            </span>
                            </div>
                      </div>
                       
                        <br>
                    <div class="form-group">
                      <label class="col-sm-4 col-sm-4 control-label">Commentaire</label>
                      <div class="col-sm-8">
                        <textarea class="form-control" rows="5" name="liv_com4" id="liv_com4" ></textarea>
                      </div>
                   
                  </div>
              </div>

                 <div class="modal-footer">
                   <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-success" id="ajouter">
                    Modifier
                  </button>
                </div>


            
              </form>
                
              </div>
              
            </div>
          </div>
        </div>