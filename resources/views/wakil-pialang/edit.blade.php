@extends('layouts.admin')

@section('title', 'Edit Wakil Pialang')

@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-gray-800">Edit Wakil Pialang</h3>
        <a href="{{ route('wakil-pialang.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
	            <form action="{{ route('wakil-pialang.update', $wakilPialang->id) }}" method="POST" enctype="multipart/form-data">
	                @csrf
	                @method('PUT')

	                <div class="form-group">
	                    <label class="font-weight-bold" for="kantor_cabang_id">Cabang</label>
	                    <select class="form-control @error('kantor_cabang_id') is-invalid @enderror" id="kantor_cabang_id"
	                        name="kantor_cabang_id" required>
	                        <option value="0"
	                            {{ (string) old('kantor_cabang_id', $wakilPialang->kantor_cabang_id ?? 0) === '0' ? 'selected' : '' }}>
	                            {{ $kantorPusatLabel }}
	                        </option>
	                        @foreach ($kantorCabangs as $cabang)
	                            <option value="{{ $cabang->id }}"
	                                {{ (string) old('kantor_cabang_id', $wakilPialang->kantor_cabang_id ?? 0) === (string) $cabang->id ? 'selected' : '' }}>
	                                {{ $cabang->nama_kantor_cabang }}
	                            </option>
	                        @endforeach
	                    </select>
	                    @error('kantor_cabang_id')
	                        <div class="invalid-feedback">{{ $message }}</div>
	                    @enderror
	                </div>

	                {{-- Preview gambar saat ini --}}
	                @if ($wakilPialang->image)
                    <div class="form-group">
                        <label class="font-weight-bold d-block">Foto Saat Ini</label>
                        <img src="{{ asset($wakilPialang->image) }}" alt="{{ $wakilPialang->nama }}"
                            class="img-fluid rounded mb-2" style="max-height: 220px; object-fit: cover;">
                    </div>
                @endif

                {{-- Ganti gambar (opsional) --}}
                <div class="form-group">
                    <label class="font-weight-bold" for="image">Ganti Foto (opsional)</label>
                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image"
                        name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted d-block">Biarkan kosong jika tidak ingin mengubah foto.</small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" for="nomor_id">Nomor ID</label>
                    <input type="text" class="form-control @error('nomor_id') is-invalid @enderror" id="nomor_id"
                        name="nomor_id" value="{{ old('nomor_id', $wakilPialang->nomor_id) }}" maxlength="25" required>
                    @error('nomor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" for="nama">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                        name="nama" value="{{ old('nama', $wakilPialang->nama) }}" maxlength="100" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-weight-bold" for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                        required>
                        <option value="Aktif" {{ old('status', $wakilPialang->status) === 'Aktif' ? 'selected' : '' }}>
                            Aktif</option>
                        <option value="Non-Aktif"
                            {{ old('status', $wakilPialang->status) === 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('wakil-pialang.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
