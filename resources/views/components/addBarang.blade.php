<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: fit-content;
            margin: 2rem auto;
        }
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
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
        }
        .card-header {
            background: linear-gradient(45deg, #4e73df, #224abe);
            padding: 1.5rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="d-flex">
        <div class="container-fluid">
            <div class="form-container">


                        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-4">
                                        <label class="form-label required-field">Kategori</label>
                                        <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror">
                                            <option value="">Pilih Kategori</option>
                                            {{-- @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label required-field">Nama Barang</label>
                                        <input type="text" class="form-control @error('nama_barang') is-invalid @enderror"
                                            name="nama_barang" value="{{ old('nama_barang') }}"
                                            placeholder="Masukkan nama barang">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label required-field">Harga</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                                        name="harga" value="{{ old('harga') }}"
                                                        placeholder="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label class="form-label required-field">Berat (gram)</label>
                                                <input type="number" class="form-control @error('berat') is-invalid @enderror"
                                                    name="berat" value="{{ old('berat') }}"
                                                    placeholder="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label required-field">Stok</label>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                            name="stok" value="{{ old('stok') }}"
                                            placeholder="0">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="product-preview mb-3">
                                        <img id="preview" src="#" alt="Preview" class="preview-image mb-3">
                                        <div id="placeholder-text">
                                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                            <p class="text-muted">Preview foto produk akan muncul di sini</p>
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

    <script>
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
