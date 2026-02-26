@extends('layouts.admin')

@section('title', 'Tambah TikTok')

@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-gray-800">Tambah TikTok</h3>
        <a href="{{ route('tiktok.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tiktok.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="font-weight-bold" for="title">Judul (opsional)</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title') }}" maxlength="100">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" for="embed_code">Link Embed TikTok</label>
                    <input type="text" class="form-control @error('embed_code') is-invalid @enderror" id="embed_code"
                        name="embed_code" value="{{ old('embed_code') }}" required>
                    @error('embed_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block">Isi URL/embed TikTok.</small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" for="backup_video">Video Backup (opsional)</label>
                    <input type="file" class="form-control-file @error('backup_video') is-invalid @enderror"
                        id="backup_video" name="backup_video" accept=".mp4,.mov,.mkv,.webm">
                    @error('backup_video')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block">Max 50MB. Format: mp4, mov, mkv, webm.</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('tiktok.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
