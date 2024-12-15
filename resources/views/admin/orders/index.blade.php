@include('shared.html')

@include('shared.head', ['pageTitle' => 'Skup surowców'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Zamówienia</h1>
        </div>
        <div class="row mb-2">
            <a href="{{ route('admin.orders.create') }}">Dodaj nowe zamówienie</a>
        </div>
        @include('shared.session-error')
        <div class="table-responsive-sm">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Id użytkownika</th>
                        <th scope="col">Id materiału</th>
                        <th scope="col">Ilość</th>
                        <th scope="col">Cena końcowa</th>
                        <th scope="col"></th>
                        @can('is-admin')
                            <th scope="col"></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <th scope="row">{{ $order->id }}</th>
                            <td>{{ $order->user_id }}</td>
                            <td>{{ $order->material_id }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->final_price }}</td>
                            @can('is-admin')
                                <td><a href="{{ route('admin.orders.edit', $order) }}">Edycja</a></td>
                            @endcan
                            <td>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Usuń"
                                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" />
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th scope="row" colspan="6">Brak zamówień.</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('shared.footer')

    </html>
