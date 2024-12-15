@include('shared.html')

@include('shared.head', ['pageTitle' => 'Profil użytkownika'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        <div class="row mb-1">
            <h1>Profil użytkownika</h1>
        </div>
        @include('shared.session-error')
        <table class="table table-hover table-striped">
            <tbody>
                <tr>
                    <th scope="col">Login</th>
                    <td>{{ $user->login }}</td>
                </tr>
                <tr>
                    <th scope="col">Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th scope="col">Rola</th>
                    <td>{{ $user->role }}</td>
                </tr>
                <tr>
                    <th scope="col">Adres</th>
                    <td>{{ $user->address }}</td>
                </tr>
                <tr>
                    <th scope="col">Numer telefonu</th>
                    <td>{{ $user->phone_number }}</td>
                </tr>
                <tr>
                    <th scope="col"></th>
                    <td><a href="{{ route('user.profile.edit', $user->id) }}" class="btn btn-primary mb-2">Edycja</a>
                        <form method="POST" action="{{ route('user.profile.destroy', $user->id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="btn btn-danger" value="Usuń" />
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @include('shared.footer')
</body>

</html>
