@include('shared.html')

@include('shared.head', ['pageTitle' => 'Skup surowców'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Materiały</h1>
        </div>
        <div class="row mb-2">
            <a href="{{ route('admin.materials.create') }}">Dodaj nowy materiał</a>
        </div>
        @include('shared.session-error')
        <div class="table-responsive-sm">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Typ</th>
                        <th scope="col">Cena za tonę</th>
                        <th scope="col">Obrazek</th>
                        <th scope="col"></th>
                        @can('is-admin')
                            <th scope="col"></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materials as $material)
                        <tr>
                            <th scope="row">{{ $material->id }}</th>
                            <td>{{ $material->name }}</td>
                            <td>{{ $material->type }}</td>
                            <td>{{ $material->price_for_ton }}</td>
                            <td>{{ $material->img }}</td>
                            @can('is-admin')
                                <td><a href="{{ route('admin.materials.edit', $material) }}">Edycja</a></td>
                            @endcan
                            <td>
                                <form method="POST" action="{{ route('admin.materials.destroy', $material->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Usuń"
                                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" />
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th scope="row" colspan="6">Brak materiałów.</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('shared.footer')

    </html>
