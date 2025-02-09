<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        @include('layouts.sideNav')

        <div class="content-wrapper" style="margin-left: 250px; width: calc(100% - 250px);">
            <div class="container-fluid p-4">
                <div class="card shadow">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Daftar Pembelian</h5>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addPembelianModal">
                            <i class="fas fa-plus"></i> Tambah Pembelian
                        </button>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <table class="table table-hover" id="pembelianTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Supplier</th>
                                    <th>Tanggal Beli</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelian  as $a)
                                    <tr>
                                        <td>{{ $a->id }}</td>
                                        <td>{{ $a->supplier->nama_supplier }}</td>
                                        <td>{{ $a->tgl_beli }}</td>
                                        <td>Rp {{ number_format($a->total, 0, ',', '.') }}</td>
                                        <td>
                                           <a href="{{ route('pembelian.detail', $a->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eyes">
                                                <span class="fs-6">Detail</span>
                                            </i>
                                           </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPembelianModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('pembelian.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Supplier</label>
                            <select class="form-control" name="id_supplier" required>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="items-container">
                            <div class="item-group">
                                <label class="form-label">Barang</label>
                                <div class="flex flex-row items-center gap-2">
                                     <select class="form-control item-select" name="items[0][nama_barang]" required
                                    onchange="updatePrice(this)">
                                    <option value="" data-price="0">-- Pilih Barang --</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->nama_barang }}" data-price="{{ $barang->harga }}">
                                            {{ $barang->nama_barang }} - Rp
                                            {{ number_format($barang->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </select>
                                </div>
                                <input type="hidden" class="harga-input" name="items[0][harga]">
                                <label class="form-label mt-2">QTY</label>
                                <input type="number" class="form-control qty-input" name="items[0][jumlah_beli]"
                                    required oninput="calculateTotal()">
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addItem()">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>

                        <hr>
                        <h5 class="text-end">Total: Rp <span id="totalPrice">0</span></h5>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pembelianTable').DataTable();
        });

        let itemCount = 1;

        function addItem() {
            let container = document.getElementById("items-container");
            let newItem = document.createElement("div");
            newItem.classList.add("item-group", "mt-3");
            newItem.innerHTML = `
                <label class="form-label">Barang</label>
                <select class="form-control item-select" name="items[${itemCount}][nama_barang]" required onchange="updatePrice(this)">
                    <option value="" data-price="0">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->nama_barang }}" data-price="{{ $barang->harga }}">
                            {{ $barang->nama_barang }} - Rp {{ number_format($barang->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                <label class="form-label mt-2">QTY</label>
                <input type="number" class="form-control qty-input" name="items[${itemCount}][jumlah_beli]" required oninput="calculateTotal()">
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeItem(this)">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            `;
            container.appendChild(newItem);
            itemCount++;
        }

        function removeItem(button) {
            button.parentElement.remove();
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll(".item-group").forEach(item => {
                let price = parseFloat(item.querySelector(".item-select").selectedOptions[0].dataset.price);
                let qty = parseInt(item.querySelector(".qty-input").value) || 0;
                total += price * qty;
            });
            document.getElementById("totalPrice").innerText = total.toLocaleString();
        }

        function updatePrice(select) {
            let price = select.selectedOptions[0].dataset.price;
            select.closest(".item-group").querySelector(".harga-input").value = price;
            calculateTotal();
        }
    </script>
</body>

</html>
