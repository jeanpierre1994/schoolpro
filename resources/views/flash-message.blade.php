@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <span class="text-center"><strong>{{ $message }}</strong></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <span class="text-center"><strong>{{ $message }}</strong></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span class="text-center"><strong>{{ $message }}</strong></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <span class="text-center"><strong>{{ $message }}</strong></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
</div>
@endif

@if ($message = Session::get('message'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <span class="text-center"><strong>{{ $message }}</strong></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
    Please check the form below for errors
</div>
@endif