@include('shared.html')

@include('shared.head', ['pageTitle' => 'Zamówienia użytkownika'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        <div class="row mb-1">
            <h1>Zamówienia użytkownika</h1>
        </div>
        @include('shared.session-error')
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id użytkownika</th>
                    <th scope="col">Id materiału</th>
                    <th scope="col">Ilość</th>
                    <th scope="col">Cena końcowa</th>
                    <th scope="col"></th>
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
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('user.orders.edit', $order->id) }}" class="btn btn-primary align-middle">Edycja</a>
                                <form method="POST" action="{{ route('user.orders.destroy', $order->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger align-middle">Usuń</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Brak zamówień.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>



    @include('shared.footer')
</body>

</html>
