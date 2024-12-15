@include('shared.html')

@include('shared.head', ['pageTitle' => 'Surowiec ' . $material->name])

<body>
    @include('shared.navbar')

    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card">
                    <img src="{{ asset('storage/img/' . $material->img) }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $material->name }}</h5>
                        <p class="card-text">{{ $material->type }}</p>
                    </div>
                    <div class="card-footer text-center">
                        <h5 class="card-title">Cena za tonę to {{ $material->price_for_ton }} zł</h5>
                    </div>
                    <form action="{{ route('materials.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                        <input type="hidden" name="final_price" id="final_price" value="{{ $totalPrice }}">
                        <div class="card-footer text-center">
                            <label for="quantity">Wybierz ilość ton:</label>
                            <input type="range" class="custom-range" id="quantity_range" name="quantity" min="0.1"
                                max="{{ $in_stock }}" step="0.1" value="{{ $quantity }}" oninput="updateQuantity(this.value)">
                            <input type="number" class="form-control mt-2" id="quantity_number" name="quantity"
                                min="0.1" max="{{ $in_stock }}" step="0.1" value="{{ $quantity }}" oninput="updateRange(this.value)">
                            <p class="mt-2">Wybrana ilość: <span id="quantity_display">{{ $quantity }}</span> ton</p>
                            <p>Łączna cena: <span id="total_price">{{ $totalPrice }}</span> zł</p>
                        </div>
                        @if (Auth::check())
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-2">Kup</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateQuantity(value) {
            document.getElementById('quantity_number').value = value;
            document.getElementById('quantity_display').innerText = value;
            updateTotalPrice(value);
        }

        function updateRange(value) {
            document.getElementById('quantity_range').value = value;
            document.getElementById('quantity_display').innerText = value;
            updateTotalPrice(value);
        }

        function updateTotalPrice(quantity) {
            let pricePerTon = {{ $pricePerTon }};
            let totalPrice = (quantity * pricePerTon).toFixed(2);
            document.getElementById('total_price').innerText = totalPrice;
            document.getElementById('final_price').value = totalPrice;
        }
    </script>

    @include('shared.footer')
</body>

</html>
