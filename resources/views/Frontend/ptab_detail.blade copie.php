@extends('Templates.form_master')

@section('titre')
    ptab detail
@endsection


@php
use Carbon\Carbon;

$current = Carbon::now();
$active="active";
$open="open";
$show="show";
$d="#";
$page="evaluation";
$sm="ptab";

$agent_function = Session::get('function_key');
$responsable_userid = get_responsableid( $ptab->responsable );
//dd($agent_function,$ptab,$responsable_userid, auth()->user()->id);
$isptabadmin= $agent_function->isptabadmin;
$level= $agent_function->level;
if($tid=='tache'){$grade=1;}
if($tid=='activite'){$grade=2;}
if($tid=='action'){$grade=3;}

$isptabHelper= get_ptab_helper(auth()->user()->id);

//dd($isptabHelper , $isptabadmin);

@endphp

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{{asset('lib/gritter/css/jquery.gritter.css')}}" />
@endsection

@section('content')

<section class="wrapper">
  <div class="row mt">
          <div class="col-lg-12">

            <a class="btn btn-info btn-bold opacity-2" href="javascript:history.go(-1)" >Retour</a>
            <div class="form-panel">
              <h4 class="mb"> PTAB Détails</h4>
               @if (session('success'))
                     <div class="form-group ">
                      <div class="col-xs-12">
                        <div class="alert alert-success">
                               {{ session('success') }}
                        </div>
                      </div>
                    </div>
                 @endif
                 @if (session('error'))
                     <div class="form-group ">
                      <div class="col-xs-12">
                        <div class="alert alert-danger">
                               {{ session('error') }}
                        </div>
                      </div>
                    </div>
                @endif
            <div class="row">

                <div class="modal-body ace-scrollbar">
                 <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('update.ptab.detail') }}">
                   {{ csrf_field() }} 
                  <div class="form-group">
                     @if($ptab->type_id==3)
                    <label class="col-sm-2 col-sm-2 control-label">Action:</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="3" readonly>{{getInstanceName('action','id',$ptab->action_id,'intitule')}}</textarea>
                      </div>

                  <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Activité :</label>
                  <div class="col-sm-10" style="padding-top: 10px;">
                    <textarea class="form-control" rows="3" readonly>{{getInstanceName('action','id',$ptab->activite_id,'intitule')}}</textarea>
                  </div>
                  @endif
                  @if($ptab->type_id==2)
                    <label class="col-sm-2 col-sm-2 control-label">Action:</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" rows="3" readonly>{{getInstanceName('action','id',$ptab->action_id,'intitule')}}</textarea>
                  </div>
                  @endif

                 <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">
                   @if($ptab->type_id==1)
                       Action
                   @elseif($ptab->type_id==2)
                       Activité
                   @else
                       Tâche
                   @endif:
                </label>
                  <div class="col-sm-10" style="padding-top: 10px;">
                    <textarea class="form-control" rows="3" name="intitule" readonly >{{getInstanceName('action','id',$ptab->id,'intitule')}}</textarea>
                  </div>

                  <label class="col-sm-2 col-sm-2 control-label" style="padding-top: 10px;">Responsable :</label>
                  <div class="col-sm-10" style="padding-top: 10px;">
                    <select class="form-control" name="responsable_" disabled >
                          <option value=""></option>
                          @foreach($agents as $agent)
                           <option value="{{$agent->nomprenoms}}" <?php if($agent->nomprenoms == $ptab->responsable){echo 'selected';} ?> >{{ $agent->nomprenoms }}</option>
                          @endforeach
                    </select>
                  </div>
                </div>

               <div class="form-group" >
                <label class="col-sm-2 col-sm-2 control-label" for="cible_globale" style="padding-top: 10px;">Cible Global :</label>
                    <div class="col-sm-4" style="padding-top: 10px;">
                    <textarea class="form-control" name="cible_globale" <?php if($isptabadmin==1 || $isptabHelper==1){echo '';}else{echo 'readonly';} ?>>{{$ptab->cible_glo}}</textarea>
                  </div>
                  
                  <label class="col-sm-2 col-sm-2 control-label"style="padding-top: 10px;">Coût global:</label>
                  <div class="col-sm-4"style="padding-top: 10px;">
    <input type="text" class="form-control" name="cout_global" value="{{$ptab->cout_glo}}" <?php if($isptabadmin==1 || $isptabHelper==1){echo '';}else{echo 'readonly';} ?> >
                  </div>
                </div>

                <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="ajouter">
                  Modifier
                </button>
              </div>

                  </form>
                </div>
              
            </div>

          </div>

          <div class="form-panel">
              <div class="panel-heading">
                <ul class="nav nav-tabs nav-justified">
                 
                  <li class="active">
                    <a data-toggle="tab" href="#trimestr1" class="">Premier Trimestre</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#trimestr2" class="">Deuxième Trimestre</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#trimestr3" class="contact-map">Troisième Trimestre</a>
                  </li>
                  <li>
                    <a data-toggle="tab" href="#trimestr4" class="parcours-map">Quatrième Trimestre</a>
                  </li>
                </ul>
              </div>

              <div class="panel-body">
                <div class="tab-content">
                  <div id="trimestr1" class="tab-pane active">
                    @include('Frontend.trimestre1')
                  </div>


                <!-- trimestre 2 -->
                   <div id="trimestr2" class="tab-pane">
                    @include('Frontend.trimestre2')
                  </div>


                  <!-- trimestre 3 -->
                   <div id="trimestr3" class="tab-pane ">
                     @include('Frontend.trimestre3')
                  </div>


                  <!-- trimestre 4 -->
                   <div id="trimestr4" class="tab-pane">
                    @include('Frontend.trimestre4')
                  </div>



                </div>
              </div>


          </div>


          
            
          </div>
  </div>
</section>


@endsection

@section('scriptjs')
<script>

    var x = 1;

    function addElement()
   {

    x++;

      $("#link_section").append('<div class="form-group row" id="sec_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"><button type="button" class="btn btn-warning remove_element radius-round" id="'+x+'" onclick="removeElement('+x+')"><span class="fa fa-minus"></span></button></div><div class="col-sm-4 input-floating-label text-blue-d2 brc-blue-m1"><input type="file" class="form-control" name="livrable_t1[]" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_disables(1,$grade,$ptab->cible_t1);} ?>><span class="floating-label text-grey-m3">livrables/pièces justificatives</span></div><div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1"><input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="commentaire_lt1[]"=""/><span class="floating-label text-grey-m3">Commentaire</span></div></div>');
   }

   function addElement2()
   {

    x++;

      $("#link_section2").append('<div class="form-group row" id="sec_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"><button type="button" class="btn btn-warning remove_element radius-round" id="'+x+'" onclick="removeElement('+x+')"><span class="fa fa-minus"></span></button></div><div class="col-sm-4 input-floating-label text-blue-d2 brc-blue-m1"><input type="file" class="form-control" name="livrable_t2[]" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_disables(2,$grade,$ptab->cible_t2);} ?>><span class="floating-label text-grey-m3">livrables/pièces justificatives</span></div><div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1"><input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="commentaire_lt2[]"=""/><span class="floating-label text-grey-m3">Commentaire</span></div></div>');
   }

   function addElement3()
   {

    x++;

      $("#link_section3").append('<div class="form-group row" id="sec_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"><button type="button" class="btn btn-warning remove_element radius-round" id="'+x+'" onclick="removeElement('+x+')"><span class="fa fa-minus"></span></button></div><div class="col-sm-4 input-floating-label text-blue-d2 brc-blue-m1"><input type="file" class="form-control" name="livrable_t3[]" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_disables(3,$grade,$ptab->cible_t3);} ?>><span class="floating-label text-grey-m3">livrables/pièces justificatives</span></div><div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1"><input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="commentaire_lt3[]"=""/><span class="floating-label text-grey-m3">Commentaire</span></div></div>');
   }

   function addElement4()
   {

    x++;

      $("#link_section4").append('<div class="form-group row" id="sec_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"><button type="button" class="btn btn-warning remove_element radius-round" id="'+x+'" onclick="removeElement('+x+')"><span class="fa fa-minus"></span></button></div><div class="col-sm-4 input-floating-label text-blue-d2 brc-blue-m1"><input type="file" class="form-control" name="livrable_t4[]" <?php if($isptabadmin!=1 && $isptabHelper!=1){ echo_disables(4,$grade,$ptab->cible_t4);} ?>><span class="floating-label text-grey-m3">livrables/pièces justificatives</span></div><div class="col-sm-6 input-floating-label text-blue-d2 brc-blue-m1"><input type="text" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="commentaire_lt4[]"=""/><span class="floating-label text-grey-m3">Commentaire</span></div></div>');
   }


      function removeElement(id)
      {
          $('#sec_'+id).remove();
          $('#sec1_'+id).remove();  
           x--;
      }
</script>
<script type="text/javascript">
  justif=$("#justif").val();
  if(justif==2){ $("#justif").css("display","block");}else{$("#justif").css("display","none");}

   function displayJustification(id)
  {

       if (id == 2) {
              $("#justif").css("display","block");
            }else {
                  $("#justif").css("display","none");
                  }

  }

  $('#add-without-image1').click(function(){

        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'A lire Attentivement SVP!',
            // (string | mandatory) the text inside the notification
            text: 'LORSQUE LA CIBLE DE L’INDICATEUR EsT DISPONIBLE, vous ne pouvez renseigner que disponible ou non disponible. <br/> LORSQUE LA CIBLE DE L’INDICATEUR EsT oui, vous ne pouvez renseigner que oui ou non. <br/> LORSQUE LA CIBLE DE L’INDICATEUR est un nombre, vous ne pouvez renseigner qu’un nombre.'
        });

        return false;
    });

  $('#add-without-image2').click(function(){

        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'A lire Attentivement SVP!',
            // (string | mandatory) the text inside the notification
            text: 'LORSQUE LA CIBLE DE L’INDICATEUR EsT DISPONIBLE, vous ne pouvez renseigner que disponible ou non disponible. <br/> LORSQUE LA CIBLE DE L’INDICATEUR EsT oui, vous ne pouvez renseigner que oui ou non. <br/> LORSQUE LA CIBLE DE L’INDICATEUR est un nombre, vous ne pouvez renseigner qu’un nombre.'
        });

        return false;
    });

  $('#add-without-image3').click(function(){

        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'A lire Attentivement SVP!',
            // (string | mandatory) the text inside the notification
            text: 'LORSQUE LA CIBLE DE L’INDICATEUR EsT DISPONIBLE, vous ne pouvez renseigner que disponible ou non disponible. <br/> LORSQUE LA CIBLE DE L’INDICATEUR EsT oui, vous ne pouvez renseigner que oui ou non. <br/> LORSQUE LA CIBLE DE L’INDICATEUR est un nombre, vous ne pouvez renseigner qu’un nombre.'
        });

        return false;
    });

  $('#add-without-image4').click(function(){

        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'A lire Attentivement SVP!',
            // (string | mandatory) the text inside the notification
            text: 'LORSQUE LA CIBLE DE L’INDICATEUR EsT DISPONIBLE, vous ne pouvez renseigner que disponible ou non disponible. <br/> LORSQUE LA CIBLE DE L’INDICATEUR EsT oui, vous ne pouvez renseigner que oui ou non. <br/> LORSQUE LA CIBLE DE L’INDICATEUR est un nombre, vous ne pouvez renseigner qu’un nombre.'
        });

        return false;
    });
</script>


<script type="text/javascript" src="{{asset('lib/gritter/js/jquery.gritter.js')}}"></script>

<script type="text/javascript">

  function changestatut(id,opt,trim){

            $("#action_id").val(id);
            $("#opt").val(opt);
            $("#trim").val(trim);
            if(opt==1){
               $("#myModalLabel").html("Valider le Livrable");
             }else if(opt==2){
              $("#myModalLabel").html("Réjeter le livrabre");
             }else{
              $("#myModalLabel2").html("Ajouter un livrable");
             }


          }

function changeLivrable(id,opt,trim){

            $("#action_idl").val(id);
            $("#optl").val(opt);
            $("#triml").val(trim);
            $("#myModalLabel2").html("Ajouter un livrable");
            var livrableName='';
            if (trim ==1) {livrableName = 'livrable_t1';}
            else if(trim==2){livrableName = 'livrable_t1';}
            else if(trim==3){livrableName = 'livrable_t3';}
            else if(trim==4){livrableName = 'livrable_t4';}
            else {livrableName = 'livrable_final';}
            document.getElementById('livrable').name = livrableName;

            }

</script>
  
@endsection



