@include('shared.html')

@include('shared.head', ['pageTitle' => 'Zbiór wszystkich surowców'])

<body>
    @include('shared.navbar')
    <div class="container mt-5">
        <div class="row">
            <h1>Nasze oferty</h1>
        </div>
        <div class="row">
            @forelse ($materials as $material)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <img src="{{ asset('storage/img/' . $material->img) }}" class="card-img-top" alt="{{ $material->name }}">
                            <div class="card-img-overlay d-flex justify-content-end align-items-start">
                                <h5 class="badge bg-primary text-white">{{ $material->price_for_ton }} zł/ton</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $material->name }}</h5>
                            <p class="card-text">{{ $material->type }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center">
                            <a href="{{ route('materials.show', $material->id) }}" class="btn btn-primary w-100">Więcej szczegółów...</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Brak ofert.</p>
            @endforelse
        </div>
    </div>
    @include('shared.footer', ['fixedBottom' => true])
</body>
