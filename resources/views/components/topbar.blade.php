<div class="component">
    <div class="topbar">
        <div class="container-fluid">
            <div class="row justify-content-between py-2 m-0">
                <div class="col-lg-6 p-0 m-0">
                    <ul class="link p-0 m-0">
                        <li class="d-inline-block me-2"><a href="mailto:{{ $email }}"><i data-feather="mail"></i> {{ $email }}</a></li>
                        <li class="d-inline-block mx-2"><a href="tel:{{ $phone }}"><i data-feather="phone"></i> {{ $phone }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 com-info text-end p-0 pt-1">
                    <span>{{ $company }}</span>
                </div>
            </div>
        </div>
    </div>
</div>