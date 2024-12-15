@include('shared.html')

@include('shared.head', ['pageTitle' => 'Panel użytkownika'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        <h1 class="text-center">Panel użytkownika</h1>
        <div class="d-flex flex-column align-items-center mt-4">
            <a href="{{ route('user.profile.show', ['profile' => Auth::user()->id]) }}" class="btn btn-primary mb-3 w-50">Zarządzaj swoimi danymi</a>
            <a href="{{ route('user.orders.show', ['order' => Auth::user()->id]) }}" class="btn btn-primary mb-3 w-50">Zarządzaj swoimi zamówieniami</a>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
