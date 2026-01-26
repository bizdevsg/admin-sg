@extends('layouts.admin')

@section('title', 'Tambah Wakil Pialang')

@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-gray-800">Tambah Wakil Pialang</h3>
        <a href="{{ route('wakil-pialang.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
	            <form action="{{ route('wakil-pialang.store') }}" method="POST" enctype="multipart/form-data">
	                @csrf

	                <div class="form-group">
	                    <label class="font-weight-bold" for="kantor_cabang_id">Cabang</label>
	                    <select class="form-control @error('kantor_cabang_id') is-invalid @enderror" id="kantor_cabang_id"
	                        name="kantor_cabang_id" required>
	                        <option value="" disabled selected>Pilih cabang</option>
	                        <option value="0" {{ (string) old('kantor_cabang_id') === '0' ? 'selected' : '' }}>
	                            {{ $kantorPusatLabel }}
	                        </option>
	                        @foreach ($kantorCabangs as $cabang)
	                            <option value="{{ $cabang->id }}"
	                                {{ (string) old('kantor_cabang_id') === (string) $cabang->id ? 'selected' : '' }}>
	                                {{ $cabang->nama_kantor_cabang }}
	                            </option>
	                        @endforeach
	                    </select>
	                    @error('kantor_cabang_id')
	                        <div class="invalid-feedback">{{ $message }}</div>
	                    @enderror
	                </div>

	                {{-- Gambar (wajib sesuai migration) --}}
	                <div class="form-group">
	                    <label class="font-weight-bold" for="image">Foto</label>
                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                        name="image" accept="image/*" required>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block">Format: jpg, jpeg, png, gif, webp. Maks 3MB.</small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" for="nomor_id">Nomor ID</label>
                    <input type="text" class="form-control @error('nomor_id') is-invalid @enderror" id="nomor_id"
                        name="nomor_id" value="{{ old('nomor_id') }}" maxlength="25" required>
                    @error('nomor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" for="nama">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        name="nama" value="{{ old('nama') }}" maxlength="100" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                        required>
                        <option value="" disabled selected>Pilih status</option>
                        <option value="Aktif" {{ old('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ old('status') === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('wakil-pialang.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
