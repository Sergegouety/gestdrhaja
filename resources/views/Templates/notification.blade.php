 @if(Auth::user()->state==1 || Session::get('function_key')->direction_id==4)
<div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
          <!-- settings start -->
          
          <!-- settings end -->
          <!-- inbox dropdown start-->
          
          <!-- inbox dropdown end -->
          <!-- notification dropdown start-->
           @php

              $demande_conges=demande_congelist(2);
              $count_demande_conge=count($demande_conges);

              $demande_documents=demande_documentlist(1);
              $count_demande_document=count($demande_documents);

              $nouvelle_articles=nouvelle_articlelist(1);
              $count_nouvelle_article=count($nouvelle_articles);

              $tot_notification=$count_demande_conge + $count_demande_document + $count_nouvelle_article;
              //dd($demande_conges,$demande_documents,$nouvelle_articles);

          @endphp
          <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
              <i class="fa fa-bell-o"></i>
              <span class="badge bg-warning">{{ $tot_notification }}</span>
              </a>
            <ul class="dropdown-menu extended notification">
             
              <div class="notify-arrow notify-arrow-yellow"></div>
              <li>
                <p class="yellow">Vous avez {{ $tot_notification }} nouvelles notifications</p>
              </li>
              @foreach($demande_conges as $demande_conge)
              <li>
                <a href="{{ route('super.demande') }}">
                  <span class="label label-success"><i class="fa fa-bell"></i></span>
                  {{ getInstanceName('users','id',$demande_conge->demandeur_id,'nomprenoms') }}
                  <br>
                  <span class="small italic">Demande de Congé / permission.</span>
                  </a>
              </li>
              @endforeach

              @foreach($demande_documents as $demande_document)
              <li>
                <a href="{{ route('super.documentation') }}">
                  <span class="label label-info"><i class="fa fa-bell"></i></span>
                 {{ getInstanceName('users','id',$demande_document->user_id,'nomprenoms') }}
                  <br>
                  <span class="small italic">Demande de document.</span>
                  </a>
              </li>
               @endforeach

              @foreach($nouvelle_articles as $nouvelle_article)
              <li>
                <a href="{{ route('view.communication') }}">
                  <span class="label label-warning"><i class="fa fa-bell"></i></span>
                  {{ getAuteurName($nouvelle_article->article_type) }}
                  <br>
                  <span class="small italic"> Nouvelle article.</span>
                  </a>
              </li>
              @endforeach

              
              
              <li>
                <!-- <a href="index.html#">See all notifications</a> -->
              </li>
            </ul>
          </li>
          <!-- notification dropdown end -->
        </ul>
        <!--  notification end -->
      </div>
    @endif