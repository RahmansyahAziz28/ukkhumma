<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .product-preview {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            display: none;
        }

        .required-field::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
    </style>
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
                                @foreach ($pembelian as $a)
                                    <tr>
                                        <td>{{ $a->id }}</td>
                                        <td>{{ $a->supplier->nama_supplier }}</td>
                                        <td>{{ $a->tgl_beli }}</td>
                                        <td>Rp {{ number_format($a->total, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('pembelian.detail', $a->id) }}"
                                                class="btn btn-sm btn-info">
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

    <div class="modal fade" id="addBarangModal" tabindex="-1" aria-labelledby="addBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addBarangModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('barang.new') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label required-field">Kategori</label>
                                    <select name="id_kategori"
                                        class="form-select @error('id_kategori') is-invalid @enderror">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">
                                                {{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label required-field">Nama Barang</label>
                                        <input type="text"
                                            class="form-control @error('nama_barang') is-invalid @enderror"
                                            name="nama_barang" value="{{ old('nama_barang') }}"
                                            placeholder="Masukkan nama barang">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label required-field">Berat
                                            (gram)</label>
                                        <input type="number" step="any"
                                            class="form-control @error('berat') is-invalid @enderror" name="berat"
                                            value="{{ old('berat') }}" placeholder="0">
                                    </div>
                                </div>



                                <div class="mb-4">
                                    <label class="form-label required-field">Detail Barang</label>
                                    <input type="text"
                                        class="form-control @error('detail_barang') is-invalid @enderror"
                                        name="detail_barang" value="{{ old('detail_barang') }}"
                                        placeholder="Masukkan Detail barang">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label required-field">Harga
                                                Beli</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number"
                                                    class="form-control @error('harga_beli') is-invalid @enderror"
                                                    name="harga_beli" value="{{ old('harga_beli') }}" placeholder="0">
                                                @error('harga_beli')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label required-field">Harga
                                                Jual</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number"
                                                    class="form-control @error('harga_jual') is-invalid @enderror"
                                                    name="harga_jual" value="{{ old('harga_jual') }}"
                                                    placeholder="0">
                                                @error('harga_jual')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label required-field">Stok</label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                        name="stok" value="{{ old('stok') }}" placeholder="0">
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="product-preview mb-3">
                                    <img id="preview" src="#" alt="Preview" class="preview-image mb-3">
                                    <div id="placeholder-text">
                                        <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                        <p class="text-muted">Preview foto produk akan muncul di
                                            sini</p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label required-field">Foto Produk</label>
                                    <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                        name="foto" accept="image/*" onchange="previewImage(this)">
                                    <div class="form-text">Format: JPG, PNG, GIF (Max. 2MB)</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-light">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>

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
                                <div class="d-flex align-items-center w-100">
                                    <select class="form-control item-select flex-grow-1" name="items[0][nama_barang]"
                                        required onchange="updatePrice(this)">
                                        <option value="" data-price="0">-- Pilih Barang --</option>
                                        @foreach ($barangs as $barang)
                                            <option value="{{ $barang->nama_barang }}"
                                                data-price="{{ $barang->harga_beli }}">
                                                {{ $barang->nama_barang }} - Rp
                                                {{ number_format($barang->harga_beli, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                        data-bs-target="#addBarangModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>


                                <input type="hidden" class="harga_beli-input" name="items[0][harga_beli]">
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
                        <option value="{{ $barang->nama_barang }}" data-price="{{ $barang->harga_beli }}">
                            {{ $barang->nama_barang }} - Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}
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
            select.closest(".item-group").querySelector(".harga_beli-input").value = price;
            calculateTotal();
        }

        function previewImage(input) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder-text');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
