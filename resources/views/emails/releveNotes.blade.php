<x-mail::message>
# Relevé de Notes : {{ $examen->libelle }}
## Etudiant : {{ $etudiant->getDossier->getPersonne->nom . ' ' . $etudiant->getDossier->getPersonne->prenoms }}

Appuyer sur le bouton ci dessous pour accéder au relevé de notes

<x-mail::button :url="route('pdf', ['id' => \Crypt::encrypt($examen->id), 'gp_id' => \Crypt::encrypt($etudiant->groupepedagogique_id), 'etudiant_id' => \Crypt::encrypt($etudiant->id)]) ">
Relevé
</x-mail::button>

Thanks,<br>
{{ __('SCHOOLPRO') }}
</x-mail::message>
