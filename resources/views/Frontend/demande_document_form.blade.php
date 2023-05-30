@extends('Templates.form_master')

@section('titre')
    Noouveau Agent
@endsection

@php
$active="active";
$open="open";
$show="show";
$d="#";
$page="document";
$sm="demande";
@endphp

@section('content')
<section class="wrapper">
       <!--  <h3><i class="fa fa-angle-right"></i> Form Components</h3> -->
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <h4 class="mb"> Nouvelle demande</h4>
              <form class="form-horizontal m-t-10 p-20 p-b-0" method="post" action="{{ route('add.demandeDocument') }}">
                             {{ csrf_field() }}
                         <input type="hidden" name="user_id" value="{{Auth::id()}}" />

                <div class="modal-body ace-scrollbar">
                    

                    <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0">
                      <button type="button" onclick="addElement()" class="btn btn-success radius-round">
                             <span class="fa fa-plus"></span>
                      </button>
                    </div>

                    <div class="col-sm-5 input-floating-label text-blue-d2 brc-blue-m1">
                       <select class="form-control" name="document_id[]" required="">
                        @foreach($documents as $document)
                        <option value="{{ $document->id }}">{{ $document->designation }}</option>
                        @endforeach
                      </select>
                      <span class="floating-label text-grey-m3">
                        Documents
                    </span>
                    </div>
                    <div class="col-sm-2 input-floating-label text-blue-d2 brc-blue-m1">
                      <input type="number" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="nbr_doc[]"required=""/>
                      <span class="floating-label text-grey-m3">
                        Nbre exemplaire
                    </span>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"></div>
                    <div class="col-sm-7 input-floating-label text-blue-d2 brc-blue-m1">
                      <textarea class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" name="motif[]" rows="4" placeholder="Entrez le motif" required></textarea>
                      <span class="floating-label text-grey-m3">
                        Motif
                    </span>
                    </div>
                  </div>

                  <div id="link_section" >
                    
                  </div>


                  </div>


                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">
                      retour
                    </button> -->

                    <button type="submit" class="btn btn-primary">
                      Ajouter
                    </button>
                  </div>
                 </form>
            </div>
          </div>
          <!-- col-lg-12-->
        </div>
       
      </section>

@endsection

@section('scriptjs')
    
    <script>

    var x = 1;

    function addElement()
   {

    x++;

      $("#link_section").append('<div class="form-group row" id="sec_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"><button type="button" class="btn btn-warning remove_element radius-round" id="'+x+'" onclick="removeElement('+x+')"><span class="fa fa-minus"></span></button></div><div class="col-sm-5 input-floating-label text-blue-d2 brc-blue-m1"><select class="form-control" name="document_id[]" required="">@foreach($documents as $document)<option value="{{ $document->id }}">{{ $document->designation }}</option>@endforeach</select><span class="floating-label text-grey-m3">Documents</span></div><div class="col-sm-2 input-floating-label text-blue-d2 brc-blue-m1"><input type="number" class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" id="id-form-field-2" name="nbr_doc[]"required=""/><span class="floating-label text-grey-m3">Nbre exemplaire</span></div></div><div class="form-group row" id="sec1_'+x+'"><div class="mb-1 mb-sm-0 col-sm-2 col-form-label text-sm-right pr-0"></div><div class="col-sm-7 input-floating-label text-blue-d2 brc-blue-m1"><textarea class="form-control form-control-lg col-sm-12 col-md-10 shadow-none" name="motif[]" rows="4" placeholder="Entrez le motif" required></textarea><span class="floating-label text-grey-m3"> Motif</span></div></div>');
   }


      function removeElement(id)
      {
          $('#sec_'+id).remove();
          $('#sec1_'+id).remove();  
           x--;
      }

 function addDocElement(num,name)
   {
      $("#doc_"+num).append('<div class="form-control col-xs-12 col-sm-5" id="file'+num+'"><input type="file" id="id-input-file-2" name="'+name+'" required/></div>');
   }

    function removeDocElement(id)
      {
          $(id).remove();  
      }


</script>

    @endsection