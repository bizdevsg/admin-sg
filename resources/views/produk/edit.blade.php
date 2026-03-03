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
                        class="form-control tinymce-editor @error('deskripsi_produk') is-invalid @enderror">{{ old('deskripsi_produk', $produk->deskripsi_produk) }}</textarea>
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
    <script src="https://cdn.tiny.cloud/1/rijrac2uxn06a1q296snq7j1fi420fd29r3lc1o12yzq6fwv/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
    <script>
        tinymce.init({
            selector: '.tinymce-editor',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            content_style: 'img{max-width:100%;height:auto;}',
            image_class_list: [
                { title: 'Responsive', value: 'img-fluid' },
            ],
            setup: (editor) => {
                const sync = () => editor.save();
                editor.on('change input undo redo', sync);
            },
            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();

                xhr.open('POST', '{{ route('tinymce.upload') }}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.withCredentials = true;

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status !== 200) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }

                    let json;
                    try {
                        json = JSON.parse(xhr.responseText);
                    } catch (e) {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    if (!json || typeof json.location !== 'string') {
                        reject('Invalid response: ' + xhr.responseText);
                        return;
                    }

                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed due to a network error.');
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }),
        });
    </script>
@endsection
