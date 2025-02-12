<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom p-3">
                <button class="btn btn-link d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 ms-3">Dashboard</h5>
            </nav>

            <div class="container-fluid p-4">
                @if (Auth::user()->hak_akses != 'member')
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6>Products</h6>
                                    <h3>{{ $barang->count() ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6>Orders</h6>
                                    <h3>{{ $totalorder ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6>Customers</h6>
                                    <h3>{{ $totalmember ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6>Revenue</h6>
                                    <h3>Rp {{ number_format($totalRevenue ?? 0) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Products List</h5>
                        @if (Auth::user()->hak_akses != 'member' && Auth::user()->hak_akses != 'kasir')
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBarangModal">
                            <i class="fas fa-plus"></i> Add Barang
                        </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <table class="table table-hover" id="productsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Product Detail</th>
                                    <th>Selling Price</th>
                                    <th>Stock</th>
                                    <th>Photo</th>
                                    @if (Auth::user()->hak_akses != 'member' && Auth::user()->hak_akses != 'kasir')
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang ?? [] as $k)
                                    <tr>
                                        <td>{{ $k->id }}</td>
                                        <td>{{ $k->nama_barang }} ({{ $k->kategori->nama_kategori }})</td>
                                        <td>{{ $k->detail_barang }} - {{ $k->berat }}g</td>
                                        <td>Rp {{ number_format($k->harga_jual) }}</td>
                                        <td>{{ $k->stok }}</td>
                                        <td>
                                            <img src="{{ url('image') }}/{{ $k->foto }}" alt="project-image" x
                                                class="rounded" style="width: 100%; max-width: 100px; height: auto;">
                                        </td>
                                        @if (Auth::user()->hak_akses != 'member' && Auth::user()->hak_akses != 'kasir')
                                            <td>
                                                <button class="btn btn-sm btn-info edit-btn" data-bs-toggle="modal"
                                                    data-bs-target="#editBarangModal{{ $k->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $k->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteBarangModal">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>

                                    <div class="modal fade" id="editBarangModal{{ $k->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Edit Barang</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('barang.update', $k->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="mb-4">
                                                                    <label
                                                                        class="form-label required-field">Kategori</label>
                                                                    <select name="id_kategori"
                                                                        class="form-select @error('id_kategori') is-invalid @enderror">
                                                                        <option value="">Pilih Kategori</option>
                                                                        @foreach ($kategoris as $kategori)
                                                                            <option value="{{ $kategori->id }}"
                                                                                {{ $k->id_kategori == $kategori->id ? 'selected' : '' }}>
                                                                                {{ $kategori->nama_kategori }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="row mb-4">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label required-field">Nama
                                                                            Barang</label>
                                                                        <input type="text"
                                                                            class="form-control @error('nama_barang') is-invalid @enderror"
                                                                            name="nama_barang"
                                                                            value="{{ old('nama_barang', $k->nama_barang) }}"
                                                                            placeholder="Masukkan nama barang">
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <label class="form-label required-field">Berat
                                                                            (gram)</label>
                                                                        <input type="number" step="any"
                                                                            class="form-control @error('berat') is-invalid @enderror"
                                                                            name="berat"
                                                                            value="{{ old('berat', $k->berat) }}"
                                                                            placeholder="0">
                                                                    </div>
                                                                </div>

                                                                <div class="mb-4">
                                                                    <label class="form-label required-field">Detail
                                                                        Barang</label>
                                                                    <input type="text"
                                                                        class="form-control @error('detail_barang') is-invalid @enderror"
                                                                        name="detail_barang"
                                                                        value="{{ old('detail_barang', $k->detail_barang) }}"
                                                                        placeholder="Masukkan Detail barang">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="form-label required-field">Harga
                                                                                Beli</label>
                                                                            <div class="input-group">
                                                                                <span
                                                                                    class="input-group-text">Rp</span>
                                                                                <input type="number"
                                                                                    class="form-control @error('harga_beli') is-invalid @enderror"
                                                                                    name="harga_beli"
                                                                                    value="{{ old('harga_beli', $k->harga_beli) }}"
                                                                                    placeholder="0">
                                                                                @error('harga_beli')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-4">
                                                                            <label
                                                                                class="form-label required-field">Harga
                                                                                Jual</label>
                                                                            <div class="input-group">
                                                                                <span
                                                                                    class="input-group-text">Rp</span>
                                                                                <input type="number"
                                                                                    class="form-control @error('harga_jual') is-invalid @enderror"
                                                                                    name="harga_jual"
                                                                                    value="{{ old('harga_jual', $k->harga_jual) }}"
                                                                                    placeholder="0">
                                                                                @error('harga_jual')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="product-preview mb-3">
                                                                    <img id="preview{{ $k->id }}"
                                                                        src="{{ url('image') }}/{{ $k->foto }}"
                                                                        alt="Preview" class="preview-image mb-3"
                                                                        style="display: block; max-width: 100%; height: auto;">
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="form-label required-field">Foto
                                                                        Produk</label>
                                                                    <input type="file"
                                                                        class="form-control @error('foto') is-invalid @enderror"
                                                                        name="foto" accept="image/*"
                                                                        onchange="previewImage(this, '{{ $k->id }}')">
                                                                    <div class="form-text">Format: JPG, PNG, GIF (Max.
                                                                        2MB)</div>
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
                                @endforeach
                            </tbody>
                        </table>

                        <div class="modal fade" id="deleteBarangModal" tabindex="-1"
                            aria-labelledby="deleteBarangModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="deleteBarangModalLabel">Hapus Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                                        <form id="deleteBarangForm" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" id="delete-id" name="id">
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="addBarangModal" tabindex="-1"
                            aria-labelledby="addBarangModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="addBarangModalLabel">Tambah Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('barang.store') }}" method="POST"
                                            enctype="multipart/form-data">
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
                                                            <label class="form-label required-field">Nama
                                                                Barang</label>
                                                            <input type="text"
                                                                class="form-control @error('nama_barang') is-invalid @enderror"
                                                                name="nama_barang" value="{{ old('nama_barang') }}"
                                                                placeholder="Masukkan nama barang">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label required-field">Berat
                                                                (gram)</label>
                                                            <input type="number" step="any"
                                                                class="form-control @error('berat') is-invalid @enderror"
                                                                name="berat" value="{{ old('berat') }}"
                                                                placeholder="0">
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
                                                                        name="harga_beli"
                                                                        value="{{ old('harga_beli') }}"
                                                                        placeholder="0">
                                                                    @error('harga_beli')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
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
                                                                        name="harga_jual"
                                                                        value="{{ old('harga_jual') }}"
                                                                        placeholder="0">
                                                                    @error('harga_jual')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="product-preview mb-3">
                                                        <img id="preview" src="#" alt="Preview"
                                                            class="preview-image mb-3">
                                                        <div id="placeholder-text">
                                                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                            <p class="text-muted">Preview foto produk akan muncul di
                                                                sini</p>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label required-field">Foto Produk</label>
                                                        <input type="file"
                                                            class="form-control @error('foto') is-invalid @enderror"
                                                            name="foto" accept="image/*"
                                                            onchange="previewImage(this)">
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

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                $('#edit-id').val($(this).data('id'));
                $('#edit-nama').val($(this).data('nama'));
                $('#edit-detail').val($(this).data('detail'));
                $('#edit-harga_jual').val($(this).data('harga_jual'));
                $('#editBarangForm').attr('action', '/barang/' + $(this).data('id'));
            });

            $('.delete-btn').click(function() {
                $('#delete-id').val($(this).data('id'));
                $('#deleteBarangForm').attr('action', '/barang/' + $(this).data('id'));
            });
        });

       function previewImage(input, id = null) {
        if (id) {
            const preview = document.getElementById('preview' + id);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        else {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder-text');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
}
    </script>
</body>

</html>
