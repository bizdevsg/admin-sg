@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('main-content')
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Edit Produk</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk"
                        class="form-control @error('nama_produk') is-invalid @enderror"
                        value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                    @error('nama_produk')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kategori (Dropdown) -->
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror"
                        required>
                        <option value="" disabled>Pilih Kategori</option>
                        <option value="SPA" {{ old('kategori', $produk->kategori) == 'SPA' ? 'selected' : '' }}>
                            Bilateral (SPA)</option>
                        <option value="JFX" {{ old('kategori', $produk->kategori) == 'JFX' ? 'selected' : '' }}>
                            Multilateral (JFX)</option>
                    </select>
                    @error('kategori')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Deskripsi Produk (TinyMCE) -->
                <div class="form-group">
                    <label for="deskripsi_produk">Deskripsi Produk</label>
                    <textarea name="deskripsi_produk" id="deskripsi_produk" rows="5"
                        class="form-control @error('deskripsi_produk') is-invalid @enderror">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
                    @error('deskripsi_produk')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Spesifikasi Produk (TinyMCE) -->
                <div class="form-group">
                    <label for="specs">Spesifikasi Produk</label>
                    <textarea name="specs" id="specs" rows="5"
                        class="form-control tinymce-editor @error('specs') is-invalid @enderror">{{ old('specs', $produk->specs) }}</textarea>
                    @error('specs')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Upload Gambar -->
                <div class="form-group">
                    <label for="image">Gambar Produk</label><br>
                    @if ($produk->image)
                        <div class="mb-2">
                            <img src="{{ asset($produk->image) }}" alt="Gambar Produk" class="img-thumbnail"
                                width="150">
                        </div>
                    @endif
                    <input type="file" name="image" id="image"
                        class="form-control-file @error('image') is-invalid @enderror">
                    @error('image')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning">Update</button>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- TinyMCE CDN -->
    <script src="https://cdn.tiny.cloud/1/zxbb8ss6iclrki0fopl5gcne91neckqc4e004atop3wf0mi2/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: '.tinymce-editor',
            height: 500,
            menubar: 'file edit view insert format tools table help',
            plugins: `
                advlist autolink lists link image charmap preview anchor 
                searchreplace visualblocks code fullscreen 
                insertdatetime media table emoticons template help 
                wordcount autosave directionality quickbars pagebreak
            `,
            toolbar: `
                undo redo | bold italic underline strikethrough | 
                fontselect fontsizeselect formatselect | 
                alignleft aligncenter alignright alignjustify | 
                outdent indent | numlist bullist checklist | 
                forecolor backcolor | removeformat | 
                link image media table | 
                charmap emoticons | pagebreak insertdatetime | 
                fullscreen preview code help
            `,
            toolbar_sticky: true,
            autosave_interval: '30s',
            autosave_restore_when_empty: true,
            autosave_retention: '2m',
            image_advtab: true,
            content_style: `
                body { font-family:Helvetica,Arial,sans-serif; font-size:14px }
            `
        });
    </script>
@endsection
