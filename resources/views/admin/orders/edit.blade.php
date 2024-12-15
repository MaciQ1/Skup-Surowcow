@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edycja'])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">

        @include('shared.session-error')

        <div class="row mt-4 mb-4 text-center">
            <h1>Edytuj dane zamówienia</h1>
        </div>

        @include('shared.validation-error')

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="quantity_number" class="form-label">Ilość (w tonach)</label>
                        <input id="quantity_number" name="quantity" type="number" min="0.1" max="100" step="0.1"
                            class="form-control @if ($errors->first('quantity')) is-invalid @endif"
                            value="{{ $order->quantity }}" oninput="updateRange(this.value)">
                        <div class="invalid-feedback">Nieprawidłowa ilość!</div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="final_price" class="form-label">Cena końcowa (PLN)</label>
                        <input id="final_price" name="final_price" type="number"
                            class="form-control @if ($errors->first('final_price')) is-invalid @endif"
                            value="{{ $order->final_price }}" readonly>
                        <div class="invalid-feedback">Nieprawidłowa cena końcowa!</div>
                    </div>
                    <div class="text-center mt-4 mb-4">
                        <input class="btn btn-success" type="submit" value="Zaktualizuj">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')

    <script>
        function updateRange(value) {
            update_total_price(value);
        }

        function update_total_price(quantity) {
            let pricePerTon = {{ $material->price_for_ton }};
            let total_price = (quantity * pricePerTon).toFixed(2);
            document.getElementById('final_price').value = total_price;
        }

        document.addEventListener('DOMContentLoaded', function () {
            update_total_price(document.getElementById('quantity_number').value);
        });
    </script>
</body>

</html>
