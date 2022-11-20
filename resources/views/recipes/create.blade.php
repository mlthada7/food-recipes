@extends('recipes.layouts.boilerplate')

@section('content')

<div class="row">
    <h1>Tulis Resepmu ...</h1>
    <div class="col-lg-8">
        {{-- POST + /dashboard/posts(route::r) mengarah ke store di resource --}}
        <form action="{{ route('recipes.store') }}" method="POST" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" autofocus value="{{ old('title') }}">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea type="text" class="form-control @error('description')
                    is-invalid
                @enderror" id="description" name="description" value="{{ old('description') }}"></textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ingredients" class="form-label">Bahan-bahan</label>
                <textarea type="text" class="form-control @error('ingredients')
                    is-invalid
                @enderror" id="ingredients" name="ingredients" value="{{ old('ingredients') }}"></textarea>
                @error('ingredients')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="methods" class="form-label">Langkah Pembuatan</label>
                <textarea type="text" class="form-control @error('methods')
                    is-invalid
                @enderror" id="methods" name="methods" value="{{ old('methods') }}"></textarea>
                @error('methods')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload Foto Masakan</label>
                <input class="form-control @error('image')
                    is-invalid
                @enderror" type="file" name="image" id="image">
                @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Terbitkan Resep</button>
        </form>
    </div>
</div>

@endsection
