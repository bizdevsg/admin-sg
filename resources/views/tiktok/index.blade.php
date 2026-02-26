@extends('layouts.admin')

@section('title', 'Daftar TikTok')

@section('main-content')

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="mb-2 d-flex justify-content-between align-items-center">
        <span class="h3 text-gray-800">{{ __('Daftar TikTok') }}</span>

        <div class="d-none d-md-flex align-items-center">
            <form action="{{ route('tiktok.index') }}" method="GET" class="form-inline">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul..."
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <a href="{{ route('tiktok.index') }}" class="btn btn-danger ml-2">
                <i class="fa-solid fa-rotate"></i> Reset
            </a>
            <a href="{{ route('tiktok.create') }}" class="btn btn-primary ml-2">
                <i class="fa-solid fa-plus"></i> Tambah TikTok
            </a>
        </div>
    </div>

    <div class="table-responsive border rounded shadow-sm">
        <table class="table table-hover table-bordered table-striped mb-0">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Judul</th>
                    <th class="text-center">Link Embed</th>
                    <th class="text-center">Video Backup</th>
                    <th class="text-center">Tanggal Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tiktoks as $tiktok)
                    <tr>
                        <td class="align-middle text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="align-middle">
                            {{ $tiktok->title ? Str::limit($tiktok->title, 50) : '-' }}
                        </td>
                        <td class="align-middle text-center">
                            <a href="{{ $tiktok->embed_code }}" target="_blank" class="btn btn-success btn-sm text-dark">
                                <i class="fas fa-external-link-alt"></i> Lihat
                            </a>
                        </td>
                        <td class="align-middle text-center">
                            @if ($tiktok->backup_video_path)
                                <a href="{{ Storage::url($tiktok->backup_video_path) }}" target="_blank"
                                    class="btn btn-info btn-sm text-dark">
                                    <i class="fas fa-video"></i> Video
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            {{ \Carbon\Carbon::parse($tiktok->updated_at)->translatedFormat('l, d F Y, H:i') }}
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('tiktok.edit', $tiktok->id) }}"
                                    class="btn btn-warning btn-sm mx-1 text-dark w-100">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('tiktok.destroy', $tiktok->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus link TikTok ini?');"
                                    class="w-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1 w-100">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Tidak ada data TikTok yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $tiktoks->links() }}
    </div>

@endsection
