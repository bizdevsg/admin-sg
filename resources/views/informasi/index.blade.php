@extends('layouts.admin')

@section('title', 'Informasi')

@section('main-content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h3 font-weight-bold mb-0">Daftar Informasi</h1>
            <p class="mb-0 text-muted">Daftar informasi umum PT. Solid Gold Berjangka</p>
        </div>

        <div>
            <a href="{{ route('informasi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Informasi
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form method="GET" class="form-inline mb-3">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari judul..." value="{{ $search }}">
                <button type="submit" class="btn btn-secondary mr-2">Cari</button>
                <a href="{{ route('informasi.index') }}" class="btn btn-outline-secondary">Reset</a>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" style="width:5%">#</th>
                            <th>Judul</th>
                            <th class="text-center" style="width:20%">Slug</th>
                            <th class="text-center" style="width:20%">Tanggal Dibuat</th>
                            <th class="text-center" style="width:25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($informasis as $item)
                            <tr>
                                <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $item->title }}</td>
                                <td class="align-middle text-center">{{ $item->slug }}</td>
                                <td class="align-middle text-center">
                                    {{ optional($item->created_at)->format('d M Y H:i') }}
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('informasi.show', $item->id) }}" class="btn btn-sm btn-success w-100 mr-1">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('informasi.edit', $item->id) }}" class="btn btn-sm btn-warning w-100 mx-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('informasi.destroy', $item->id) }}" method="POST" class="d-inline w-100 ml-1" onsubmit="return confirm('Yakin ingin menghapus informasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada informasi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $informasis->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
