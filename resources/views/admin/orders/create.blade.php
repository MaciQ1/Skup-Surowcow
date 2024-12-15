@include('shared.html')

@include('shared.head', ['pageTitle' => 'Dodaj nowe zamówienie'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Dodaj nowe zamówienie</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ route('admin.orders.store') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group mb-2">
                        <label for="user_id" class="form-label">Użytkownik</label>
                        <select id="user_id" name="user_id"
                            class="form-control @if ($errors->first('user_id')) is-invalid @endif">
                            <option value="">Wybierz użytkownika</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->login }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Nieprawidłowy użytkownik!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="material_id" class="form-label">Materiał</label>
                        <select id="material_id" name="material_id"
                            class="form-control @if ($errors->first('material_id')) is-invalid @endif"
                            onchange="updateMaterialPrice()">
                            <option value="">Wybierz materiał</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" data-price="{{ $material->price_for_ton }}"
                                    {{ old('material_id') == $material->id ? 'selected' : '' }}>{{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Nieprawidłowy materiał!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="quantity_number" class="form-label">Ilość (w tonach)</label>
                        <input id="quantity_number" name="quantity" type="number" min="0.1" step="0.1"
                            class="form-control @if ($errors->first('quantity')) is-invalid @endif"
                            value="{{ old('quantity') }}" oninput="updateTotalPrice()">
                        <div class="invalid-feedback">Nieprawidłowa ilość!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="final_price" class="form-label">Cena końcowa (PLN)</label>
                        <input id="final_price" name="final_price" type="number" min="0.1" step="0.1"
                            class="form-control @if ($errors->first('final_price')) is-invalid @endif"
                            value="{{ old('final_price') }}" readonly>
                        <div class="invalid-feedback">Nieprawidłowa cena końcowa!</div>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <input class="btn btn-success" type="submit" value="Dodaj">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')

    <script>
        function updateMaterialPrice() {
            const materialSelect = document.getElementById('material_id');
            const selectedOption = materialSelect.options[materialSelect.selectedIndex];
            const pricePerTon = selectedOption.getAttribute('data-price');
            updateTotalPrice();
        }

        function updateTotalPrice() {
            const materialSelect = document.getElementById('material_id');
            const selectedOption = materialSelect.options[materialSelect.selectedIndex];
            const pricePerTon = selectedOption.getAttribute('data-price');
            const quantity = document.getElementById('quantity_number').value;

            if (pricePerTon && quantity) {
                const totalPrice = (pricePerTon * quantity).toFixed(2);
                document.getElementById('final_price').value = totalPrice;
            } else {
                document.getElementById('final_price').value = '';
            }
        }
    </script>
</body>

</html>
