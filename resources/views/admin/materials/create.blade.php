@include('shared.html')

@include('shared.head', ['pageTitle' => 'Dodaj nowy kraj'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Dodaj nowy materiał</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ route('admin.materials.store') }}" class="needs-validation"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Nazwa</label>
                        <input id="name" name="name" type="text"
                            class="form-control @if ($errors->first('name')) is-invalid @endif"
                            value="{{ old('name') }}">
                        <div class="invalid-feedback">Nieprawidłowa nazwa!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="type" class="form-label">Typ surowca</label>
                        <input id="type" name="type" type="text"
                            class="form-control @if ($errors->first('type')) is-invalid @endif"
                            value="{{ old('type') }}">
                        <div class="invalid-feedback">Nieprawidłowy typ!</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="price_for_ton" class="form-label">Cena za tonę</label>
                        <div class="input-group mb-3">
                            <input id="price_for_ton" name="price_for_ton" type="number" min="1" placeholder="1"
                                class="form-control @if ($errors->first('price_for_ton')) is-invalid @endif"
                                value="{{ old('price_for_ton') }}">
                            <span class="input-group-text"> PLN</span>
                        </div>
                        <div class="invalid-feedback">Nieprawidłowa cena!</div>
                        <div class="form-group mb-2">
                            <label for="img" class="form-label">Zdjęcie</label>
                            <input id="img" name="img" type="file"
                                class="form-control @if ($errors->first('img')) is-invalid @endif"
                                value="{{ old('img') }}">
                            <div class="invalid-feedback">Nieprawidłowe zdjęcie!</div>
                        </div>
                        <div class="text-center mt-4 mb-4">
                            <input class="btn btn-success" type="submit" value="Dodaj">
                        </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
