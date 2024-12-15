@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edycja'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Edytuj dane użytkownika</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="login" class="form-label">Login</label>
                        <input id="login" name="login" type="text"
                            class="form-control @if ($errors->first('login')) is-invalid @endif"
                            value="{{ $user->login }}">
                        <div class="invalid-feedback">Nieprawidłowy login!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="text"
                            class="form-control @if ($errors->first('email')) is-invalid @endif"
                            value="{{ $user->email }}">
                        <div class="invalid-feedback">Nieprawidłowy email!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password" class="form-label">Hasło (zostaw to puste, gdy nie chcesz
                            wprowadzać zmian)</label>
                        <input id="password" name="password" type="password"
                            class="form-control @if ($errors->first('password')) is-invalid @endif">
                        <div class="invalid-feedback">Nieprawidłowe hasło!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="address" class="form-label">Adres</label>
                        <input id="address" name="address" type="text"
                            class="form-control @if ($errors->first('address')) is-invalid @endif"
                            value="{{ $user->address }}">
                        <div class="invalid-feedback">Nieprawidłowy adres!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone_number" class="form-label">Numer telefonu</label>
                        <input id="phone_number" name="phone_number" type="number" pattern="[0-9]{9}"
                            class="form-control @if ($errors->first('phone_number')) is-invalid @endif"
                            value="{{ $user->phone_number }}">
                        <div class="invalid-feedback">Nieprawidłowy numer telefonu!</div>
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
