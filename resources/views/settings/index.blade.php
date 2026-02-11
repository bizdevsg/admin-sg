@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('main-content')
    <div class="mb-3">
        <h1 class="h3 font-weight-bold mb-0">Pengaturan Website</h1>
        <p class="mb-0 text-muted">Pengaturan Website dari Website PT. Solid Gold Berjangka</p>
    </div>

    {{-- Notifikasi sukses / error --}}
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ $setting ? route('settings.update', $setting->id) : route('settings.store') }}" method="POST">
                @csrf
                @if ($setting)
                    @method('PUT')
                @endif

                <!-- Judul Website -->
                <div class="form-group">
                    <label for="web_title" class="font-weight-bold">Judul Website</label>
                    <input type="text" class="form-control @error('web_title') is-invalid @enderror" id="web_title"
                        name="web_title" value="{{ old('web_title', $setting->web_title ?? '') }}" required>
                    @error('web_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi Website -->
                <div class="form-group">
                    <label for="web_description" class="font-weight-bold">Deskripsi Website</label>
                    <textarea class="form-control @error('web_description') is-invalid @enderror" id="web_description"
                        name="web_description" rows="3">{{ old('web_description', $setting->web_description ?? '') }}</textarea>
                    @error('web_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="address" class="font-weight-bold">Alamat</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $setting->address ?? '') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="maps_link" class="font-weight-bold">Link Maps</label>
                    <textarea class="form-control @error('maps_link') is-invalid @enderror" id="maps_link" name="maps_link" rows="2">{{ old('maps_link', $setting->maps_link ?? '') }}</textarea>
                    @error('maps_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="link_pengaduan" class="font-weight-bold">Link Pengaduan</label>
                    <input type="url" class="form-control @error('link_pengaduan') is-invalid @enderror"
                        id="link_pengaduan" name="link_pengaduan"
                        value="{{ old('link_pengaduan', $setting->link_pengaduan ?? '') }}">
                    @error('link_pengaduan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Telepon -->
                <div class="form-group">
                    <label for="phone" class="font-weight-bold">Telepon</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone', $setting->phone ?? '') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Fax -->
                <div class="form-group">
                    <label for="fax" class="font-weight-bold">Fax</label>
                    <input type="text" class="form-control @error('fax') is-invalid @enderror" id="fax"
                        name="fax" value="{{ old('fax', $setting->fax ?? '') }}">
                    @error('fax')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="font-weight-bold">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $setting->email ?? '') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">
                        {{ $setting ? 'Perbarui Pengaturan' : 'Simpan Pengaturan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
