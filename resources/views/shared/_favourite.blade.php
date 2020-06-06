{{-- favourite a question --}}
<a title="Click to mark as favourite question (click again to undo)"
   class="favourite mt-2 {{ \Illuminate\Support\Facades\Auth::guest() ? 'off' : ($model->is_favourite ? 'favourited' : '') }}"
   onclick="event.preventDefault(); document.getElementById('favourite-question-{{ $model->id }}').submit();"
>
    <i class="fas fa-star fa-2x"></i>

    {{-- total favourite count --}}
    <span class="favourites-count">{{ $model->favourites_count }}</span>
</a>

{{-- mark as favourite question form --}}
<form action="/questions/{{$model->id}}/favourite" method="post" style="display: none" id="favourite-question-{{ $model->id }}">
    @csrf
    @if($model->is_favourite)
        @method('DELETE')
    @endif
</form>
