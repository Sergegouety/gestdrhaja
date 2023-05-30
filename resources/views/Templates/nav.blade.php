@yield('menu')
<nav aria-label="Main">
                <ul class="nav flex-column mt-2 has-active-border">

  @if(Auth::user()->type_id==1)
                  <li class="nav-item @if($page=='dashboard') {{$active}} @endif">

                    <a href="{{ route('super.dashboard') }}" class="nav-link">
                      <i class="nav-icon fa fa-tachometer-alt nav-icon-round bgc-orange-tp1"></i>
                      <span class="nav-text fadeable">
                    	  <span>Dashboard</span>
                      </span>


                    </a>

                    <b class="sub-arrow"></b>

                  </li>

@if(Auth::user()->plateforme_id==1)
                  <li class="nav-item @if($page=='parametre') {{$open}} {{$active}} @endif">

                    <a href="#" class="nav-link dropdown-toggle collapsed">
                      <i class="nav-icon fa fa-cog nav-icon-round bgc-green-tp1"></i>
                      <span class="nav-text fadeable">
                        <span>Paramètres</span>
                      </span>

                      <b class="caret fa fa-angle-left rt-n90"></b>

                      <!-- or you can use custom icons. first add `d-style` to 'A' -->
                      <!--
                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                       -->
                    </a>

                    <div class="hideable submenu collapse @if($page=='parametre') {{$show}}  @endif">
                      <ul class="submenu-inner">

                        <li class="nav-item @if($sm=='direction') {{$active}} @endif">

                          <a href="{{ route('super.direction') }}" class="nav-link">

                            <span class="nav-text">
                              <span>Direction</span>
                            </span>


                          </a>


                        </li>


                        <li class="nav-item @if($sm=='sousdirection') {{$active}} @endif">

                          <a href="{{ route('super.sousdirection') }}" class="nav-link">

                            <span class="nav-text">
                              <span>Sous-Directions</span>
                            </span>
                          </a>
                        </li>


                        <li class="nav-item @if($sm=='service') {{$active}} @endif">

                          <a href="{{ route('super.service') }}" class="nav-link">

                            <span class="nav-text">
                              <span>Services</span>
                            </span>
                          </a>


                        </li>


                        <li class="nav-item @if($sm=='agent') {{$active}} @endif">

                          <a href="{{ route('super.agent') }}" class="nav-link">

                            <span class="nav-text">
                              <span>Agents</span>
                            </span>
                          </a>
                        </li>


                      </ul>
                    </div>

                    <b class="sub-arrow"></b>

                  </li>
@endif
@endif

                  <li class="nav-item @if($page=='stock') {{$open}} {{$active}} @endif">

                    <a href="#" class="nav-link dropdown-toggle collapsed">
                      <i class="nav-icon fa fa-desktop nav-icon-round bgc-orange-tp1"></i>
                      <span class="nav-text fadeable">
                    	  <span>Congés / Absences</span>
                      </span>

                      <b class="caret fa fa-angle-left rt-n90"></b>

                      <!-- or you can use custom icons. first add `d-style` to 'A' -->
                      <!--
                    	 	<b class="caret d-n-collapsed fa fa-minus text-80"></b>
                    	 	<b class="caret d-collapsed fa fa-plus text-80"></b>
                    	 -->
                    </a>

                    <div class="hideable submenu collapse @if($page=='stock') {{$show}}  @endif">
                      <ul class="submenu-inner">

                         <li class="nav-item @if($sm=='demande') {{$active}} @endif">

                          <a href="{{ route('super.demande') }}" class="nav-link">

                            <span class="nav-text">
                              <span>Demandes</span>
                            </span>

                          </a>
                        </li>
                      </ul>
                    </div>

                    <b class="sub-arrow"></b>

                  </li>

                   <li class="nav-item @if($page=='mat_info') {{$open}} {{$active}} @endif">

                    <a href="#" class="nav-link dropdown-toggle collapsed">
                      <i class="nav-icon fa fa-folder-open nav-icon-round bgc-green-tp1"></i>
                      <span class="nav-text fadeable">
                        <span>Documents</span>
                      </span>

                      <b class="caret fa fa-angle-left rt-n90"></b>
                      <!-- or you can use custom icons. first add `d-style` to 'A' -->
                      <!--
                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                       -->
                    </a>


                    <div class="hideable submenu collapse @if($page=='mat_info') {{$show}}  @endif">
                      <ul class="submenu-inner">

                         <li class="nav-item @if($sm=='intervention') {{$active}} @endif">

                          <a href="{{ route('super.documentation') }}" class="nav-link">

                            <span class="nav-text">
                              <span>Demande</span>
                            </span>
                          </a>

                        </li>

                      </ul>
                    </div>

                    <b class="sub-arrow"></b>

                  </li>




                 <li class="nav-item @if($page=='messagerie') {{$open}} {{$active}} @endif">

                    <a href="#" class="nav-link dropdown-toggle collapsed">
                       <i class="nav-icon fa fa-inbox nav-icon-round bgc-orange-tp1"></i>
                      <span class="nav-text fadeable">
                        <span>Messagérie</span>
                      </span>

                      <b class="caret fa fa-angle-left rt-n90"></b>
                      <!-- or you can use custom icons. first add `d-style` to 'A' -->
                      <!--
                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                       -->
                    </a>


                    <div class="hideable submenu collapse @if($page=='messagerie') {{$show}}  @endif">
                      <ul class="submenu-inner">

                         <li class="nav-item @if($sm=='inbox') {{$active}} @endif">

                          <a href="{{ route('inbox') }}" class="nav-link">

                            <span class="nav-text">
                              <span>Messagérie</span>
                            </span>
                          </a>

                        </li>

                      </ul>
                    </div>

                    <b class="sub-arrow"></b>

                  </li>
@if(Auth::user()->type_id==1)
                  <li class="nav-item @if($page=='stats') {{$open}} {{$active}} @endif">

                    <a href="#" class="nav-link dropdown-toggle collapsed">
                       <i class="nav-icon far fa-window-restore nav-icon-round bgc-green-tp1"></i>
                      <span class="nav-text fadeable">
                        <span>Statistiques</span>
                      </span>

                      <b class="caret fa fa-angle-left rt-n90"></b>
                      <!-- or you can use custom icons. first add `d-style` to 'A' -->
                      <!--
                        <b class="caret d-n-collapsed fa fa-minus text-80"></b>
                        <b class="caret d-collapsed fa fa-plus text-80"></b>
                       -->
                    </a>


                    <div class="hideable submenu collapse @if($page=='stats') {{$show}}  @endif">
                      <ul class="submenu-inner">

                         <li class="nav-item @if($sm=='conge_stats') {{$active}} @endif">

                          <a href="{{ route('stat.conge') }}" class="nav-link">

                            <span class="nav-text">
                              <span>Congés / Absences</span>
                            </span>
                          </a>

                        </li>


                      </ul>
                    </div>

                    <b class="sub-arrow"></b>

                  </li>

    
@endif
                </ul>
      </nav>