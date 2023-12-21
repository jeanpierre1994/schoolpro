@php
    //Variable pour facilement récupérer le role du user
    //$user = Auth()->user();
@endphp
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" id="dashboard" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if (Auth()->user()->profil_id == 2 || Auth()->user()->profil_id == 3)
            <!-- Examens -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#examens-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-newspaper-fill"></i><span>Examens</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="examens-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('admin.etudiants') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Résultat par Dossier</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Examens Nav -->

            <!-- dossier -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#dossiers-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-newspaper-fill"></i><span>Dossiers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dossiers-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('inscription-form') }}" id="dossier-attente" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Inscription en ligne</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-attente" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Par Parent</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Dossier Nav -->
        @elseif (Auth()->user()->profil_id == 4)
            <!-- Configuration des classes -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#class-config-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Configuration Classes</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="class-config-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('admin.etudiants') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste Etudiants</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Emploi du temps</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Programme Scolaire</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Configuration des classes Nav -->
            <!-- Examens -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#examens-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-newspaper-fill"></i><span>Examens</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="examens-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Résultat par Classe</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.anc_sessioncorrections') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Session de correction</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Devoir de maison</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Examens Nav -->
        @elseif (auth()->user()->profil_id == 5)
            <!-- Paramètres établissements -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#etablissements-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Paramètres établissement</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="etablissements-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('etablissements.index') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Etablissement</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sites.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Sites</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('poles.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Poles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('filieres.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Filières</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('niveaux.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Niveaux</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cycles.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Cycles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sections.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Sections</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Catégories matières</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profils.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Profils</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Staff</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Paramètres Etablissement Nav -->
            <!-- Configuration des classes -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#class-config-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Configuration Classes</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="class-config-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('groupepedagogiques.index') }}" id="etudiants-add"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Groupe Pédagogiques</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.etudiants') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste Etudiants</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('matieres.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Matières</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('professeurs.index') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Professeurs</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Emploi du temps</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Programme Scolaire</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Configuration des classes Nav -->

            <!-- Examens -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#examens-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Examens</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="examens-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('examens.index') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Programmation</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Résultat par Classe</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Résultat par Dossier</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.anc_sessioncorrections') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Session de correction</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Devoir de maison</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Examens Nav -->
            <!-- Finances -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#finances-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Finances</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="finances-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.add-etudiant') }}" id="etudiants-add"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Inscription Express</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inscription') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste des inscriptions</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Finances Nav -->

            <!-- dossier -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#dossiers-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Dossiers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dossiers-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('dossiers.en_attente') }}" id="dossier-attente"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>En attente</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dossiers.valide') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Validés</span>
                        </a>
                    </li>
                    {{--                    <li>
                        <a href="{{ route('dossiers.rejete') }}" id="dossier-rejete" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Rejetés</span>
                        </a>
                    </li> --}}

                </ul>
            </li>
            <!-- End Dossier Nav -->
        @elseif (auth()->user()->profil_id == 6)
            <!-- Configuration des classes -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#class-config-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Configuration Classes</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="class-config-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('admin.etudiants') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste Etudiants</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Configuration des classes Nav -->
            <!-- Finances -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#finances-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Finances</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="finances-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.add-etudiant') }}" id="etudiants-add"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Inscription Express</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inscription') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste des inscriptions</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Finances Nav -->

            <!-- dossier -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#dossiers-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Dossiers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dossiers-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('dossiers.en_attente') }}" id="dossier-attente"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>En attente</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Dossier Nav -->
        @elseif (auth()->user()->profil_id == 7)
            <!-- Configuration des classes -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#class-config-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Configuration Classes</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="class-config-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('admin.etudiants') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste Etudiants</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Emploi du temps</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Configuration des classes Nav -->
            <!-- Examens -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#examens-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Examens</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="examens-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Résultat par Classe</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Examens Nav -->

            <!-- Finances -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#finances-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Finances</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="finances-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.add-etudiant') }}" id="etudiants-add"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Inscription Express</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inscription') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste des inscriptions</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Finances Nav -->

            <!-- dossier -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#dossiers-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Dossiers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dossiers-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('dossiers.en_attente') }}" id="dossier-attente"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>En attente</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Dossier Nav -->
        @elseif (auth()->user()->profil_id == 8)
            <!-- Configuration des classes -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#class-config-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Configuration Classes</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="class-config-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('admin.etudiants') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste Etudiants</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Emploi du temps</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Configuration des classes Nav -->
        @else
            <!-- Paramètres généraux -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#generaux-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Paramètres généraux</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="generaux-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('profils.index') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Profils</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('genres.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Genres</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('typesponsors.index') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Types sponsors</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('examentypes.index') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Types examens</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('statuts.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Statuts</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('statutjuridiques.index') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Statuts juridique</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Variables</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Paramètres Généraux Nav -->


            <!-- Paramètres établissements -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#etablissements-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Paramètres établissement</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="etablissements-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('etablissements.index') }}" id="etudiants-add"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Etablissement</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sites.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Sites</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('poles.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Poles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('filieres.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Filières</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('niveaux.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Niveaux</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cycles.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Cycles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('sections.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Sections</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Catégories matières</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profils.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Profils</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Staff</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Paramètres Etablissement Nav -->


            <!-- Configuration des classes -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#class-config-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Configuration Classes</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="class-config-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('groupepedagogiques.index') }}" id="etudiants-add"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Groupe Pédagogiques</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.etudiants') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Liste Etudiants</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('matieres.index') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Matières</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('professeurs.index') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Professeurs</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Emploi du temps</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Programme Scolaire</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Configuration des classes Nav -->

            <!-- Examens -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#examens-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Examens</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="examens-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('examens.index') }}" id="etudiants-add" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Programmation</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Résultat par Classe</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Résultat par Dossier</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.anc_sessioncorrections') }}" id="dossier-valide"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Session de correction</span>
                        </a>
                    </li>
                    <li>
                        <a href="" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Devoir de maison</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Examens Nav -->

            <!-- Finances -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#finances-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Finances</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="finances-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.add-etudiant') }}" id="etudiants-add"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Inscription Express</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dossiers.valide') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Dossiers validés</span>
                        </a>
                    </li>
                   <!-- <li>
                        <a href="{{ route('admin.comptable.paiements-dossier') }}" id="histo-dossiers"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Dossiers</span>
                        </a>
                    </li> -->
                    <li>
                        <a href="{{ route('admin.comptable.paiements-portefeuille') }}" id="histo-portefeuilles"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Portefeuilles</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.paiements') }}" id="import-personnes" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Etat des Paiements</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Finances Nav -->


            <!-- dossier -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#dossiers-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Dossiers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dossiers-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('dossiers.en_attente') }}" id="dossier-attente"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>En attente</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dossiers.valide') }}" id="dossier-valide" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Validés</span>
                        </a>
                    </li>
                    {{--                    <li>
                        <a href="{{ route('dossiers.rejete') }}" id="dossier-rejete" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Rejetés</span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="" id="dossier-attente" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Par Parent</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Dossier Nav -->



            {{-- <!-- Etudiant -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#etudiants-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Etudiants</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="etudiants-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.add-etudiant') }}" id="etudiants-add"
                            style="text-decoration: none;">
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

            <li class="nav-item">
                <a class="nav-link collapsed" id="parametres" href="{{ route('admin.parametres') }}">
                    <i class="ri-settings-3-fill"></i>
                    <span>Paramètres</span>
                </a>
            </li><!-- End paramètre Nav --> --}}
            <!-- Imports -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#imports-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="ri-newspaper-fill"></i><span>Imports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="imports-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('import-personnes') }}" id="import-personnes"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Personnes</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- EndImports -->


            <!-- Frais & Finances -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#frais-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri-newspaper-fill"></i><span>Frais & Finances</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="frais-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('famille_rubriques.index') }}" id="import-personnes"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Famille de Rubriques</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rubriques.index') }}" id="import-personnes"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Rubriques</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('grille_tarifaires.index') }}" id="import-personnes"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Grilles Tarifaire</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.liste_tarif') }}" id="import-personnes"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Détails des G.T.</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.paiements') }}" id="import-personnes"
                            style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Etat des Paiements</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Frais & Finances -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#optimisation-nav" data-bs-toggle="collapse"
                    href="#" style="text-decoration: none;">
                    <i class="ri-repeat-2-fill"></i><span>Optimisation</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="optimisation-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('vider_cache') }}" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Vider le cache</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('active_storage') }}" style="text-decoration: none;">
                            <i class="bi bi-circle"></i><span>Lien symbolique</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Paiement Nav --> --}}
        @endif
        <!-- Annonce -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#annonces-nav" data-bs-toggle="collapse" href="#">
                <i class="ri-newspaper-fill"></i><span>Annonces</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="annonces-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="" id="etudiants-add" style="text-decoration: none;">
                        <i class="bi bi-circle"></i><span>Calendrier</span>
                    </a>
                </li>
                <li>
                    <a href="" id="dossier-valide" style="text-decoration: none;">
                        <i class="bi bi-circle"></i><span>Evênements</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Annonce Nav -->

        <!-- Frais & Finances -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#frais-nav" data-bs-toggle="collapse" href="#">
                <i class="ri-newspaper-fill"></i><span>Frais </span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="frais-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('famille_rubriques.index') }}" id="import-personnes"
                        style="text-decoration: none;">
                        <i class="bi bi-circle"></i><span>Famille de Rubriques</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('rubriques.index') }}" id="import-personnes" style="text-decoration: none;">
                        <i class="bi bi-circle"></i><span>Rubriques</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('grille_tarifaires.index') }}" id="import-personnes"
                        style="text-decoration: none;">
                        <i class="bi bi-circle"></i><span>Grilles Tarifaire</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.liste_tarif') }}" id="import-personnes" style="text-decoration: none;">
                        <i class="bi bi-circle"></i><span>Détails des G.T.</span>
                    </a>
                </li>

            </ul>
        </li>
        <!-- End Frais & Finances -->
 

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('signout') }}" style="text-decoration: none;">
                <i class="ri-logout-box-r-line"></i>
                <span>Se déconnecter</span>
            </a>
        </li><!-- End inportation Nav -->

    </ul>

</aside>
