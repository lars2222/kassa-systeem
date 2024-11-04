@if(View::hasSection('title'))
<div class="py-3 border-bottom sticky-top bg-white">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-6">
                <h1 class="h4 mb-0">@yield('title')</h1>
            </div>
            <div class="col-6 text-end">
                @hasSection('back-btn')
                    <a href="@yield('back-btn')" class="btn btn-sm btn-dark">
                        <i class="fas fa-angle-left me-1"></i> Terug
                    </a>
                @endif
                @hasSection('create-btn')
                    <a href="@yield('create-btn')" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> maak aan
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
