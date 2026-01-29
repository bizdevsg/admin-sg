@extends('layouts.admin')

@section('title', 'Tambah Informasi')

@section('main-content')
    <h1 class="h3 font-weight-bold mb-3">Tambah Informasi</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Konten</label>
                    <textarea name="content" id="content" rows="6" class="form-control tinymce-editor @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                    @error('content')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                    @error('image')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('informasi.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
   <script src="https://cdn.tiny.cloud/1/zxbb8ss6iclrki0fopl5gcne91neckqc4e004atop3wf0mi2/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
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
