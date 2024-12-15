@include('shared.html')

@include('shared.head', ['pageTitle' => 'Panel admina'])

<body>
    @include('shared.navbar')
    <div class="container mt-5">
        <h1 class="text-center">Panel Administratora</h1>
        <div class="d-flex flex-column align-items-center mt-4">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary mb-3 w-50">Zarządzaj użytkownikami</a>
            <a href="{{ route('admin.materials.index') }}" class="btn btn-primary mb-3 w-50">Zarządzaj materiałami</a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary mb-3 w-50">Zarządzaj zamówieniami</a>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
