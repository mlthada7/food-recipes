@extends('recipes.layouts.boilerplate')

@section('content')

<h1 class="mb-4">Resep Terbaru</h1>

@if($recipes->count())
<div class="row justify-center">
    @foreach($recipes as $recipe)
    <div class="col-10 col-md-6 col-lg-4 mb-3">
        <div class="card">
            <input type="hidden" name="id" value="{{ $recipe->id }}" class="recipe-id">
            <img src="{{ asset('storage/' . $recipe->image) }}" class="img-fluid" alt="">
            <div class="card-body">
                <p>

                    <small class="text-muted">
                        .. Orang Menyukai ini
                    </small>
                </p>
                <h5 class="card-title">{{ $recipe->title }}</h5>
                <p class="card-text">{{ $recipe->description }}</p>
                {{-- <a href="" class="text-decoration-none btn btn-primary">Suka</a> --}}
                <button type="submit" class="btn" id="likeRecipe">Suka</button>
                <a href="{{ route('recipes.show', $recipe->id) }}" class="text-decoration-none btn btn-success">Lihat</a>

            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-center fs-4">No Recipe Found.</p>
@endif

<div class="d-flex justify-content-center">
    {{ $recipes->links() }}
</div>

<script>
    $('#likeRecipe').click(function(e) {
        e.preventDefault();

        let recipe_id = $(this).find(".recipe-id").val();

        $.ajax({
            type: "post"
            , url: "/like-recipe"
            , data: [
                recipe_id: recipe_id
            ]
            , success: function(response) {

            }
        });
    });

</script>

@endsection
