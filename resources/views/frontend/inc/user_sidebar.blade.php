<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
        <!-- profil etudiant -->
        @if (auth()->user()->profil_id == 2) 
        <div class="list-group list-group-flush mx-3 mt-4">
            <a href="{{route('dashboard_etudiant')}}" id="dashboard" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
            </a>
            <a href="{{route('etudiant.identite')}}" id="identite" class="list-group-item list-group-item-action py-2 ripple active">
                <i class="fas fa-user fa-fw me-3"></i><span>Identité</span>
            </a>
            <a href="{{route('etudiant.dossiers')}}" id="dossier_etudiant" title="Dossier" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-folder fa-fw me-3"></i><span>Dossiers</span>
            </a>
            <a href="{{route('etudiant.dossiers-valide')}}" id="dossier_valide" title="" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-check-square fa-fw me-3"></i><span>Inscriptions</span>
            </a>
            <a href="#" id="evenement" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-chart-line fa-fw me-3"></i><span>Evenement</span></a>
            <a href="#" id="note" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-chart-pie fa-fw me-3"></i><span>Note</span>
            </a>
            <a href="#" id="calendrier" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-chart-bar fa-fw me-3"></i><span>Calendrier</span></a> 
            <a href="{{route('signout')}}" id="se_deconnecter" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-building fa-fw me-3"></i><span>Se déconnecter</span></a> 
        </div>
        @endif

        <!-- profil parent -->
        @if (auth()->user()->profil_id == 3)
            
        <div class="list-group list-group-flush mx-3 mt-4">
            <a href="{{route('dashboard_parent')}}" id="dashboard" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
            </a>
            <a href="{{route('parent.identite')}}" id="identite" class="list-group-item list-group-item-action py-2 ripple active">
                <i class="fas fa-user fa-fw me-3"></i><span>Identité</span>
            </a>
            <a href="{{route('parent.etudiants')}}" id="etudiants" title="Liste des étudiants" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-folder fa-fw me-3"></i><span>Familles</span>
            </a>
            <a href="{{route('parent.dossiers')}}" id="dossiers" title="Dossier" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-folder fa-fw me-3"></i><span>Dossiers</span>
            </a>
            <a href="{{route('parents.inscriptions')}}" id="inscriptions" title="" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-check-square fa-fw me-3"></i><span>Inscriptions</span>
            </a>
            <a href="#" id="evenement" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-chart-line fa-fw me-3"></i><span>Evenement</span></a>
            <a href="#" id="note" class="list-group-item list-group-item-action py-2 ripple">
                <i class="fas fa-chart-pie fa-fw me-3"></i><span>Note</span>
            </a>
            <a href="#" id="calendrier" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-chart-bar fa-fw me-3"></i><span>Calendrier</span></a> 
            <a href="{{route('signout')}}" id="se_deconnecter" class="list-group-item list-group-item-action py-2 ripple"><i
                    class="fas fa-building fa-fw me-3"></i><span>Se déconnecter</span></a> 
        </div>
        @endif
    </div>
</nav>