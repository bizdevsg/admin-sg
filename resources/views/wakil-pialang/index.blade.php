@extends('layouts.admin')

@section('title', 'Daftar Wakil Pialang')

@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-gray-800">Daftar Wakil Pialang</h3>
        <a href="{{ route('wakil-pialang.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Wakil Pialang
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

	    {{-- Pencarian (opsional) --}}
	    <form action="{{ route('wakil-pialang.index') }}" method="GET" class="mb-3">
	        <div class="form-row">
	            <div class="col-12 col-md-4 mb-2 mb-md-0">
	                <select name="kantor_cabang_id" class="form-control">
	                    <option value="">Semua cabang</option>
	                    <option value="0" {{ (string) request('kantor_cabang_id') === '0' ? 'selected' : '' }}>
	                        {{ $kantorPusatLabel }}
	                    </option>
	                    @foreach ($kantorCabangs as $cabang)
	                        <option value="{{ $cabang->id }}"
	                            {{ (string) request('kantor_cabang_id') === (string) $cabang->id ? 'selected' : '' }}>
	                            {{ $cabang->nama_kantor_cabang }}
	                        </option>
	                    @endforeach
	                </select>
	            </div>
	            <div class="col-12 col-md-8">
	                <div class="input-group">
	                    <input type="text" name="search" class="form-control"
	                        placeholder="Cari nomor ID / nama / status..." value="{{ request('search') }}">
	                    <div class="input-group-append">
	                        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </form>

    <div class="row">
        @forelse ($wakilPialangs as $wp)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if ($wp->image)
                        <img src="{{ asset($wp->image) }}" class="card-img-top" alt="{{ $wp->nama }}"
                            style="object-fit: cover; height: 180px;">
                    @endif
	                    <div class="card-body d-flex flex-column">
	                        @if ($wp->kantorCabang)
	                            <div class="mb-2">
	                                <span class="badge badge-info">{{ $wp->kantorCabang->nama_kantor_cabang }}</span>
	                            </div>
	                        @else
	                            <div class="mb-2">
	                                <span class="badge badge-info">Kantor Pusat</span>
	                            </div>
	                        @endif
	                        <h5 class="card-title mb-1">{{ $wp->nama }}</h5>
	                        <p class="mb-1"><strong>No. ID:</strong> {{ $wp->nomor_id }}</p>
                        <p class="mb-2">
                            <strong>Status:</strong>
                            @if ($wp->status === 'Aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Non-Aktif</span>
                            @endif
                        </p>

                        <div class="mt-auto d-flex">
                            <a href="{{ route('wakil-pialang.edit', $wp->id) }}" class="btn btn-sm btn-warning mr-2 w-50">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('wakil-pialang.destroy', $wp->id) }}" method="POST" class="w-50"
                                onsubmit="return confirm('Hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer text-muted small">
                        Diperbarui: {{ \Carbon\Carbon::parse($wp->updated_at)->translatedFormat('d M Y H:i') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada data wakil pialang.</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $wakilPialangs->links() }}
    </div>
@endsection
