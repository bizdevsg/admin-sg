@extends('layouts.admin')

@section('title', $informasi->title)

@section('main-content')
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="d-flex align-items-center">
                <a href="{{ route('informasi.index') }}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <h3 class="m-0 font-weight-bold ml-3">
                    {{ $informasi->title }}
                </h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if ($informasi->image)
                        <img src="{{ asset($informasi->image) }}" alt="{{ $informasi->title }}" class="img-fluid rounded shadow">
                    @else
                        <img src="{{ asset('assets/no-image.png') }}" alt="No Image" class="img-fluid rounded shadow">
                    @endif
                </div>

                <div class="col-md-8">
                    <div>
                        <h5 class="font-weight-bold">- Konten -</h5>
                        <div>
                            {!! $informasi->content !!}
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('informasi.edit', $informasi->id) }}" class="btn btn-warning btn-sm">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>

                        <form action="{{ route('informasi.destroy', $informasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus informasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
