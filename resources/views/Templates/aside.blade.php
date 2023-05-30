<aside>
      <div id="sidebar" class="nav-collapse" >
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered">
             @if(Auth::user()->state==1)
               @if(Auth::user()->photodeprofil)
               <img src="{{asset('docs/'.Auth::user()->photodeprofil)}}" class="img-circle" width="80">
               @else
               <img src="{{asset('img/user.png')}}" class="img-circle" width="80">
               @endif
              @else
              <a href="{{route('agent.profil', Illuminate\Support\Facades\Crypt::encrypt(Auth::id()) )}}" >
                @if(Auth::user()->photodeprofil)
               <img src="{{asset('docs/'.Auth::user()->photodeprofil)}}" class="img-circle" width="80">
               @else
               <img src="{{asset('img/user.png')}}" class="img-circle" width="80">
               @endif
              </a>
            @endif
          </p>
          <h5 class="centered">{{Auth::user()->nomprenoms }}</h5>
         @if(Auth::user()->state==1 || Session::get('function_key')->direction_id==4 || Session::get('function_key')->level > 5)
          <li class="mt">
            <a class="@if($page=='dashboard') {{$active}} @endif" href="{{ route('super.dashboard') }}">
              <i class="fa fa-dashboard"></i>
              <span>Tableau de Bord</span>
              </a>
          </li>
          @endif
          <li class="sub-menu">
            <a href="javascript:;" class="@if($page=='communication') {{$active}} @endif">
              <i class="fa fa-tasks"></i>
              <span>Communication</span>
              </a>
            <ul class="sub">
              <li class="@if($sm=='com') {{$active}} @endif"><a href="{{ route('view.communication') }}">Communication</a></li>
              <li class="@if($sm=='dash') {{$active}} @endif"><a href="{{ route('view.comdash') }}">Accueil</a></li>
            </ul>
          </li>
          @if(Auth::user()->state==1)
          <li class="sub-menu">
            <a href="javascript:;" class="@if($page=='parametre') {{$active}} @endif">
              <i class="fa fa-cogs"></i>
              <span>Paramètres</span>
              </a>
            <ul class="sub">
              <li class="@if($sm=='direction') {{$active}} @endif">
                <a href="{{ route('super.direction') }}">Direction</a>
              </li>
              <li class="@if($sm=='sousdirection') {{$active}} @endif"><a href="{{ route('super.sousdirection') }}">Sous-Directions</a></li>
              <li class="@if($sm=='service') {{$active}} @endif"><a href="{{ route('super.service') }}">Services</a></li>
              <!-- <li class="@if($sm=='agent') {{$active}} @endif"><a href="{{ route('super.agent') }}">Agents</a></li> -->
            </ul>
          </li>
          @endif
           @if(Auth::user()->state==1)
          <li class="sub-menu">
            <a href="javascript:;" class="@if($page=='conges') {{$active}} @endif">
              <i class="fa fa-pause"></i>
              <span>Congés / Absences</span>
              </a>
            <ul class="sub">
              <li class="@if($sm=='demande') {{$active}} @endif" ><a href="{{ route('super.demande') }}">Demandes</a></li>
            </ul>
             @if(Auth::user()->state==1)
            <ul class="sub">
              <li class="@if($sm=='planning') {{$active}} @endif" ><a href="{{ route('conge.planning') }}">Planning</a></li>
            </ul>
            @endif
          </li>
          @endif
          @if(Auth::user()->state==1)
          <li class="sub-menu">
            <a href="javascript:;" class="@if($page=='document') {{$active}} @endif">
              <i class="fa fa-book"></i>
              <span>Actes administratifs</span>
              </a>
            <ul class="sub">
              <li class="@if($sm=='demande') {{$active}} @endif"><a href="{{ route('super.documentation') }}">Demande</a></li>
            </ul>
          </li>
          @endif
          @if(Auth::user()->state==1)
          <li class="sub-menu">
            <a href="javascript:;" class="@if($page=='messagerie') {{$active}} @endif">
              <i class="fa fa-tasks"></i>
              <span>Messagérie</span>
              </a>
            <ul class="sub">
              <li class="@if($sm=='inbox') {{$active}} @endif"><a href="{{ route('inbox') }}">Messagérie</a></li>
            </ul>
          </li>
          @endif
           @if(Auth::user()->state==1)
          <li class="sub-menu">
            <a href="javascript:;" class="@if($page=='recherche') {{$active}} @endif">
              <i class="fa fa-tasks"></i>
              <span>Recherche</span>
              </a>
            <ul class="sub">
              <li class="@if($sm=='agent') {{$active}} @endif"><a href="{{ route('search.agent') }}">Agent</a></li>
            </ul>
            <ul class="sub">
              <li class="@if($sm=='organigramme') {{$active}} @endif"><a href="{{ route('organigramme') }}">Organigramme</a></li>
            </ul>
          </li>
          @endif
           <li class="sub-menu">
            <a href="javascript:;" class="@if($page=='evaluation') {{$active}} @endif">
              <i class="fa fa-eye"></i>
              <span>Evaluation</span>
              </a>
            <ul class="sub">
              <li class="@if($sm=='ptab') {{$active}} @endif"><a href="{{ route('ptab') }}">PTAB</a></li>
               @if(Session::get('function_key')->isptabadmin || ptab_gestion_rigth(Auth::user()->id))
              <li class="@if($sm=='ptab') {{$active}} @endif"><a href="{{ route('ptab.gestion') }}">GERER PTAB</a></li>
              @endif
            </ul>
            @if(Session::get('function_key')->isptabadmin)
            <ul class="sub">
              <li class="@if($sm=='reglage') {{$active}} @endif"><a href="{{ route('reglage.ptab') }}">Période</a></li>
               <li class="@if($sm=='bouton') {{$active}} @endif"><a href="{{ route('reglage.bouton') }}">Bouton</a></li>
              @if(Session::get('function_key')->isptabadmin || ptab_gestion_rigth(Auth::user()->id))
              <li class="@if($sm=='droit') {{$active}} @endif"><a href="{{ route('reglage.droit') }}">Droit</a></li>
              @endif
            </ul>
            @endif
          </li>
          <!--
           @if(Auth::user()->state==1)
          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-th"></i>
              <span>Statistiques</span>
              </a>
            <ul class="sub">
              <li><a href="{{ route('stat.conge') }}">Congés / Absences</a></li>
            </ul>
          </li> -->
          @endif
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>