<footer class="footer bg-body-tertiary text-white py-3" data-bs-theme="dark">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6 d-flex align-items-center">
                <p>&copy; SkyTel 2024</p>
            </div>
            <div class="col-md-6">
                <ul class="list-inline text-md-end">
                    @foreach ($footerLinks as $link)
                        <li class="list-inline-item">
                            <a href="{{ route($link->route_name) }}" class="text-white">{{ $link->label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>
