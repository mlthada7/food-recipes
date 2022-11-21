@extends('recipes.layouts.boilerplate')

@section('content')

<div class="row justify-content-center my-4">
    <div class="col-lg-8">
        <div style="max-height: 350px; overflow:hidden" class="mb-3">
            <img src="{{ asset('storage/' . $recipe->image) }}" class="img-fluid" alt="">
        </div>

        <h1 class="mb-3">{{ $recipe->title }}</h1>

        {{-- <a href="{{ route('recipes.index') }}" class="btn btn-success mb-3"><span data-feather="arrow-left"></span> Back to all recipes</a> --}}

        <section class="my-3">
            <div class="mb-4">
                {{ $recipe->description }}
            </div>
            <div class="mb-4">
                <h2>Bahan-bahan</h2>
                @foreach($ingredients as $bahan)
                <span>{{ $bahan->name }}</span><br>
                @endforeach
            </div>
            <div class="mb-4">
                <h2>Langkah Pembuatan</h2>
                <ol>
                    @foreach($methods as $langkah)
                    <li>{{ $langkah->name }}</li>
                    @endforeach
                </ol>
            </div>
        </section>
    </div>
</div>

@endsection
