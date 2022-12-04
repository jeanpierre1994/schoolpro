@if ($message = Session::get('success'))
@mobile
<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:; 8rem;">
    <center><strong>{{ $message }}</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elsemobile
<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:; 6rem;">
    <center><strong>{{ $message }}</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endmobile
@endif

@if ($message = Session::get('error'))
    @mobile
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:; 8rem;">
        <center><strong>{{ $message }}</strong></center>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elsemobile
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:; 6rem;">
        <center><strong>{{ $message }}</strong></center>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endmobile
@endif

@if ($message = Session::get('warning'))
@mobile
<div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-top:; 8rem;">
    <center><strong>{{ $message }}</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elsemobile
<div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-top:; 6rem;">
    <center><strong>{{ $message }}</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endmobile
@endif

@if ($message = Session::get('info'))
@mobile
<div class="alert alert-info alert-dismissible fade show" role="alert" style="margin-top:; 8rem;">
    <center><strong>{{ $message }}</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elsemobile
<div class="alert alert-info alert-dismissible fade show" role="alert" style="margin-top:; 6rem;">
    <center><strong>{{ $message }}</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endmobile
@endif

@if ($message = Session::get('message'))
@mobile
<div class="alert alert-info alert-dismissible fade show" role="alert" style="margin-top:; 8rem;">
    <center><strong>{{ $message }}</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elsemobile
<div class="alert alert-info alert-dismissible fade show" role="alert" style="margin-top:; 6rem;">
    <center><strong>{{ $message }}</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endmobile
@endif

@if ($errors->any())
@mobile
<div class="alert alert-info alert-dismissible fade show" role="alert" style="margin-top:; 8rem;">
    <center><strong>Veuillez vérifier le formulaire ci-dessous pour les erreurs</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elsemobile
<div class="alert alert-info alert-dismissible fade show" role="alert" style="margin-top:; 6rem;">
    <center><strong>Veuillez vérifier le formulaire ci-dessous pour les erreurs</strong></center>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endmobile
@endif
