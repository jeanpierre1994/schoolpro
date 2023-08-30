@php
//Variable pour facilement récupérer le role du user 
    //$user = Auth()->user();
@endphp
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link collapsed" id="dashboard" href="{{route('dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->  

@if (Auth()->user()->profil_id == 2)
    
@elseif (Auth()->user()->profil_id == 3)

@else
    
<!-- Etudiant -->
<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#etudiants-nav" data-bs-toggle="collapse" href="#">
    <i class="ri-newspaper-fill"></i><span>Etudiants</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="etudiants-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
    <li>
      <a href="{{route('admin.add-etudiant')}}" id="etudiants-add" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Ajouter</span>
      </a>
    </li> 
    <li>
      <a href="{{ route('admin.etudiants') }}" id="dossier-valide" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Liste</span>
      </a>
    </li>  
  </ul>
</li>
<!-- End Etudiant Nav -->
    
<!-- dossier -->
<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#dossiers-nav" data-bs-toggle="collapse" href="#">
    <i class="ri-newspaper-fill"></i><span>Dossiers</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="dossiers-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
    <li>
      <a href="{{route('dossiers.en_attente')}}" id="dossier-attente" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>En attente</span>
      </a>
    </li> 
    <li>
      <a href="{{route('dossiers.valide')}}" id="dossier-valide" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Validés</span>
      </a>
    </li> 
    <li>
      <a href="{{route('dossiers.rejete')}}" id="dossier-rejete" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Rejetés</span>
      </a>
    </li> 
  </ul>
</li>
<!-- End Dossier Nav -->
 
 <li class="nav-item">
  <a class="nav-link collapsed" id="parametres" href="{{ route("admin.parametres")}}">
    <i class="ri-settings-3-fill"></i>
    <span>Paramètres</span>
  </a>
</li><!-- End paramètre Nav -->
<!-- Imports -->
<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#imports-nav" data-bs-toggle="collapse" href="#">
    <i class="ri-newspaper-fill"></i><span>Imports</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="imports-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
    <li>
      <a href="{{route('import-personnes')}}" id="import-personnes" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Personnes</span>
      </a>
    </li> 
  </ul>
</li>
<!-- EndImports -->


<!-- Frais & Finances -->
<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#frais-nav" data-bs-toggle="collapse" href="#">
    <i class="ri-newspaper-fill"></i><span>Frais & Finances</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="frais-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li>
      <a href="{{route('famille_rubriques.index')}}" id="import-personnes" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Famille de Rubriques</span>
      </a>
    </li> 
    <li>
      <a href="{{route('rubriques.index')}}" id="import-personnes" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Rubriques</span>
      </a>
    </li> 
        <li>
      <a href="{{route('grille_tarifaires.index')}}" id="import-personnes" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Grilles Tarifaire</span>
      </a>
    </li> 
        <li>
      <a href="{{route('import-personnes')}}" id="import-personnes" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Détails des G.T.</span>
      </a>
    </li> 
  </ul>
</li>
<!-- End Frais & Finances -->
  
<li class="nav-item">
  <a class="nav-link collapsed" data-bs-target="#optimisation-nav" data-bs-toggle="collapse" href="#" style="text-decoration: none;">
    <i class="ri-repeat-2-fill"></i><span>Optimisation</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="optimisation-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
      <a href="{{route('vider_cache')}}" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Vider le cache</span>
      </a>
    </li>
    <li>
      <a href="{{route('active_storage')}}" style="text-decoration: none;">
        <i class="bi bi-circle"></i><span>Lien symbolique</span>
      </a>
    </li> 
  </ul>
</li><!-- End Paiement Nav -->  
 
@endif
<li class="nav-item">
  <a class="nav-link collapsed" href="{{route('signout')}}" style="text-decoration: none;">
    <i class="ri-logout-box-r-line"></i>
    <span>Se déconnecter</span>
  </a>
</li><!-- End inportation Nav --> 

  </ul>

</aside>