@include('shared.html')

@include('shared.head', ['pageTitle' => 'Skup surowców'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        <div class="row">
            <h1>Użytkownicy</h1>
        </div>
        @include('shared.validation-error')
        <div class="row mb-2">
            <a href="{{ route('admin.users.create') }}">Dodaj nowego użytkownika</a>
        </div>
        @include('shared.session-error')
        <div class="table-responsive-sm">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Login</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rola</th>
                        <th scope="col">Adres</th>
                        <th scope="col">Numer telefonu</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->login }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td><a href="{{ route('admin.users.edit', $user) }}">Edycja</a></td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" value="Usuń"
                                        style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" />
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th scope="row" colspan="6">Brak użytkowników.</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('shared.footer')

    </html>
