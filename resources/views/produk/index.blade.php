@extends('layouts.admin')

@section('title', 'Produk')

@section('main-content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h3 font-weight-bold mb-0">Daftar Produk</h1>
            <p class="mb-0 text-muted">Daftar produk dari PT. Solid Gold Berjangka</p>
        </div>

        <div>
            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 5%" class="text-center">#</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col" class="text-center">Deskripsi</th>
                            <th scope="col" class="text-center">Kategori</th>
                            <th scope="col" style="width:25%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $produk)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $produk->nama_produk }}</td>
                                <td class="align-middle">{{ Str::limit($produk->deskripsi_produk, 50) }}</td>
                                <td class="align-middle">
                                    @if ($produk->kategori === 'JFX')
                                        <span>Multilateral (JFX)</span>
                                    @else
                                        <span>Bilateral (SPA)</span>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    <a href="{{ route('produk.show', $produk->slug) }}"
                                        class="btn btn-sm btn-success w-100 mr-1">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="{{ route('produk.edit', $produk->id) }}"
                                        class="btn btn-sm btn-warning w-100 mx-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-danger w-100 ml-1 js-delete-produk"
                                        data-toggle="modal"
                                        data-target="#deleteProdukModal"
                                        data-action="{{ route('produk.destroy', $produk->id) }}"
                                        data-nama="{{ $produk->nama_produk }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Produk Modal -->
    <div class="modal fade" id="deleteProdukModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteProdukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProdukModalLabel">Hapus Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Yakin ingin menghapus produk <strong id="deleteProdukName">ini</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                    <form id="deleteProdukForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#deleteProdukModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var action = button.data('action');
                var nama = button.data('nama');

                $('#deleteProdukForm').attr('action', action);
                $('#deleteProdukName').text(nama || 'ini');
            });
        });
    </script>
@endsection
