@extends('layouts.app')

@section('content')
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="mt-5">
                <h1 class="app-page-title">Invoice Masuk</h1>
                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-12">
                        <div class="app-card app-card-settings shadow-sm p-4">
                            <form method="POST" action="{{ route('invoiceIn.store') }}">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="p-1">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="nomor">
                                                    <h6 class="mb-0 fw-bold">Nomor</h6>
                                                </label>
                                                <input type="text" name="nomor" id="nomor" class="form-control"
                                                    required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="tgl">
                                                    <h6 class="mb-0 fw-bold">Tanggal</h6>
                                                </label>
                                                <input type="date" name="tgl" id="tgl" class="form-control"
                                                    required>
                                            </div>
                                        </div>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sepatu</th>
                                                    <th class="text-center">Jumlah</th>
                                                    <th class="text-center">Harga</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="items-container">
                                                <tr class="item-row">
                                                    <td class="col-md-6">
                                                        <select name="items[0][sepatu_id]"
                                                            class="form-control sepatu-select" required
                                                            onchange="updatePrice(this)">
                                                            @foreach ($sepatuItems as $sepatu)
                                                                <option value="{{ $sepatu->id }}"
                                                                    data-price="{{ $sepatu->harga }}">{{ $sepatu->kode }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="col-md-2">
                                                        <div class="d-flex">
                                                            <button class="btn btn-link px-2" type="button"
                                                                onclick="changeQuantity(this, -1)">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                            <input type="number" name="items[0][jumlah]"
                                                                class="form-control form-control-sm jumlah-input text-center"
                                                                min="1" value="1" required
                                                                oninput="updatePrice(this)" />
                                                            <button class="btn btn-link px-2" type="button"
                                                                onclick="changeQuantity(this, 1)">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="col-md-4">
                                                        <input type="number" name="items[0][harga]"
                                                            class="form-control harga-input" required placeholder="Rp."
                                                            readonly />
                                                    </td>
                                                    <td class="col-md-1">
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="removeItem(this)">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="col d-flex justify-content-start mb-3">
                                            <button type="button" class="btn btn-outline-success"
                                                style="background-color: white;
                                            color: black;
                                            border: 2px solid #04AA6D; /* Green */"
                                                onclick="addItemRow()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <hr class="my-4">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-4 bg-grey">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <h5 class="text-uppercase">Total price</h5>
                                                    <h5 id="total-price">Rp. 0</h5>
                                                    <input type="hidden" name="total" id="totali">
                                                </div>
                                                <button type="submit" class="btn btn-dark btn-block btn-lg"
                                                    data-mdb-button-init data-mdb-ripple-init
                                                    data-mdb-ripple-color="dark">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--//app-card-->
                    </div>
                </div>
            </div><!--//row-->
        </div><!--//container-fluid-->
    </div><!--//app-content-->

    <script>
        let itemCount = 1; // initialize the item count

        function updatePrice(element) {
            const itemRow = element.closest('.item-row');
            const select = itemRow.querySelector('.sepatu-select');
            const jumlahInput = itemRow.querySelector('.jumlah-input');
            const hargaInput = itemRow.querySelector('.harga-input');

            const selectedOption = select.options[select.selectedIndex];
            const unitPrice = parseFloat(selectedOption.getAttribute('data-price'));
            const quantity = parseInt(jumlahInput.value);

            if (!isNaN(unitPrice) && !isNaN(quantity)) {
                const totalPrice = unitPrice * quantity * 20;
                hargaInput.value = totalPrice.toFixed();
            } else {
                hargaInput.value = '';
            }

            updateTotalPrice();
        }

        function changeQuantity(button, delta) {
            const input = button.closest('.d-flex').querySelector('input[type=number]');
            let value = parseInt(input.value);
            value += delta;
            if (value < 1) value = 1;
            input.value = value;
            updatePrice(input);
        }

        function removeItem(button) {
            const itemRow = button.closest('.item-row');
            itemRow.remove();
            updateTotalPrice();
        }

        function addItemRow() {
            const itemContainer = document.getElementById('items-container');
            const newItemRow = document.createElement('tr');
            newItemRow.classList.add('item-row');
            newItemRow.innerHTML = `
            <td class="col-md-6">
                <select name="items[${itemCount}][sepatu_id]" class="form-control sepatu-select" required onchange="updatePrice(this)">
                    @foreach ($sepatuItems as $sepatu)
                        <option value="{{ $sepatu->id }}" data-price="{{ $sepatu->harga }}">{{ $sepatu->kode }}</option>
                    @endforeach
                </select>
            </td>
            <td class="col-md-2">
                <div class="d-flex">
                    <button class="btn btn-link px-2" type="button" onclick="changeQuantity(this, -1)">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" name="items[${itemCount}][jumlah]" class="form-control form-control-sm jumlah-input text-center" min="1" value="1" required oninput="updatePrice(this)" />
                    <button class="btn btn-link px-2" type="button" onclick="changeQuantity(this, 1)">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </td>
            <td class="col-md-4">
                <input type="number" name="items[${itemCount}][harga]" class="form-control harga-input" required placeholder="Rp." readonly />
            </td>
            <td class="col-md-1">
                <button type="button" class="btn btn-danger" onclick="removeItem(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>
        `;
            itemContainer.appendChild(newItemRow);
            itemCount++;
        }

        function updateTotalPrice() {
            let totalPrice = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const harga = parseFloat(row.querySelector('.harga-input').value);
                if (!isNaN(harga)) {
                    totalPrice += harga;
                }
            });
            document.getElementById('total-price').innerText = `Rp. ${totalPrice.toFixed()}`;
            document.getElementById('totali').value = totalPrice;
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotalPrice(); // update total price on page load
        });
    </script>
@endsection
