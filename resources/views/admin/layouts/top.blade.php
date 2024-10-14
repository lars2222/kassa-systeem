@hasSection ('name')
    <div class="py-3 border-bottom sticky-top bg-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <ul class="list-inline mb-0">
                        <h1 class="list-inline-item me-5">@yield('title')</h1>
                        <li class="list-inline-item"></li>
                    </ul>
                </div>
                <div class="col-8 text-end">
                    @hasSection('back-btn')
                    <a href="@yield('back-btn')" class="btn btn-sm btn-dark"><i class="fas fa-angle-left me-1"></i></a>
                </div>
            </div>
        </div>
    </div>
@endif