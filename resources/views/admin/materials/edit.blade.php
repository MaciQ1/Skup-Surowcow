@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edytuj dane surowca'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Edytuj dane surowca</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ route('materials.update', $material->id) }}" class="needs-validation"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Nazwa</label>
                        <input id="name" name="name" type="text"
                            class="form-control @if ($errors->first('name')) is-invalid @endif"
                            value="{{ $material->name }}">
                        <div class="invalid-feedback">Nieprawidłowa nazwa!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="type" class="form-label">Typ surowca</label>
                        <input id="type" name="type" type="text"
                            class="form-control @if ($errors->first('type')) is-invalid @endif"
                            value="{{ $material->type }}">
                        <div class="invalid-feedback">Nieprawidłowy surowiec!</div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="price_for_ton" class="form-label">Cena za tonę</label>
                        <div class="input-group mb-3">
                            <input id="price_for_ton" type="number" name="price_for_ton" min="1" placeholder="1"
                                step="any" class="form-control @if ($errors->first('price_for_ton')) is-invalid @endif"
                                value="{{ $material->price_for_ton }}" >
                            <span class="input-group-text"> PLN</span>
                        </div>
                        <div class="invalid-feedback">Nieprawidłowa cena!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="img" class="form-label">Zdjęcie</label>
                        <input id="img" name="img" type="file"
                            class="form-control @if ($errors->first('img')) is-invalid @endif"
                            value="{{ $material->img }}">
                        <div class="invalid-feedback">Nieprawidłowe zdjęcie!</div>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <input class="btn btn-success" type="submit" value="Zaktualizuj">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
