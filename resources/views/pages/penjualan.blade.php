<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        @include('layouts.sideNav')
        <div class="content-wrapper" style="margin-left: 250px; width: calc(100% - 250px);">
            <div class="container-fluid p-4">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Penjualan</h5>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addPenjualanModal">
                            <i class="fas fa-plus"></i> Tambah Penjualan
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Member</th>
                                        <th>Waktu Pemesanan</th>
                                        <th>Batas Waktu</th>
                                        <th>Total</th>
                                        <th>Bukti Bayar</th>
                                        <th>Status</th>
                                        <th>No. Resi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualans as $index => $penjualan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $penjualan->member->username }}</td>
                                            <td>{{ \Carbon\Carbon::parse($penjualan->waktu)->format('d M Y H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($penjualan->batas_waktu)->format('d M Y H:i') }}
                                            </td>
                                            <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                                            <td>
                                                <img src="{{ url('image') }}/{{ $penjualan->bukti_bayar }}"
                                                    alt="Bukti Bayar" class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $penjualan->status === 'Dipesan'
                                                        ? 'warning'
                                                        : ($penjualan->status === 'Dikirim'
                                                            ? 'info'
                                                            : ($penjualan->status === 'Diterima'
                                                                ? 'success'
                                                                : 'danger')) }}">
                                                    {{ $penjualan->status }}
                                                </span>
                                            </td>
                                            <td>{{ $penjualan->no_resi ?: '-' }}</td>
                                            <td>
                                                <div class="flex flex-row">
                                                    <a href="{{ route('penjualan.detail', $penjualan->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eyes">
                                                            <span class="fs-6">Detail</span>
                                                        </i>
                                                    </a>
                                                    <button class="btn btn-sm btn-info" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
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
    </div>

    <div class="modal fade" id="addPenjualanModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('penjualan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Member</label>
                                <select class="form-select" name="id_member" required>
                                    <option value="">Pilih Member</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Batas Waktu</label>
                                <input type="datetime-local" class="form-control" name="batas_waktu" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="Dipesan">Dipesan</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                        <div id="items-container">
                            <div class="item-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Barang</label>
                                        <select class="form-select item-select" name="items[0][nama_barang]" required
                                            onchange="updatePrice(this)">
                                            <option value="" data-price="0">-- Pilih Barang --</option>
                                            @foreach ($barangs as $barang)
                                                <option value="{{ $barang->nama_barang }}"
                                                    data-price="{{ $barang->harga }}">
                                                    {{ $barang->nama_barang }} - Rp
                                                    {{ number_format($barang->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" class="harga-input" name="items[0][harga]">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Jumlah</label>
                                        <input type="number" class="form-control qty-input"
                                            name="items[0][jumlah_jual]" required oninput="calculateTotal()">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm mt-3" onclick="addItem()">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>

                        <hr>
                        <h5 class="text-end">Total: Rp <span id="totalPrice">0</span></h5>
                        <div class="mb-3 mt-3">
                            <label class="form-label">Bukti Bayar</label>
                            <input type="file" class="form-control" name="bukti_bayar" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Resi</label>
                            <input type="text" class="form-control" name="no_resi" id="no_resi" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        let itemCount = 1;

        document.addEventListener("DOMContentLoaded", function() {
            generateResi();
        });

        function generateResi() {
            let timestamp = Date.now();
            let randomNum = Math.floor(Math.random() * 1000);
            document.getElementById("no_resi").value = `RESI-${timestamp}-${randomNum}`;
        }

        function addItem() {
            let container = document.getElementById("items-container");
            let newItem = document.createElement("div");
            newItem.classList.add("item-group", "mt-3");
            newItem.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Barang</label>
                        <select class="form-select item-select" name="items[${itemCount}][nama_barang]" required onchange="updatePrice(this)">
                            <option value="" data-price="0">-- Pilih Barang --</option>
                            @foreach ($barangs as $barang)
                                <option value="{{ $barang->nama_barang }}" data-price="{{ $barang->harga }}">
                                    {{ $barang->nama_barang }} - Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" class="harga-input" name="items[${itemCount}][harga]">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control qty-input" name="items[${itemCount}][jumlah_jual]" required oninput="calculateTotal()">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(newItem);
            itemCount++;
        }

        function removeItem(button) {
            button.closest(".item-group").remove();
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
            select.closest(".item-group").querySelector(".harga-input").value = select.selectedOptions[0].dataset.price;
            calculateTotal();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
