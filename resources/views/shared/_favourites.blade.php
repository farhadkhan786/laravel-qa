<a title="Click to mark as favourite question (Click again to undo)"
   class="favourite mt-2 {{ \Illuminate\Support\Facades\Auth::guest() ? 'off' : ($model->is_favourated ? 'favourated' : '') }}"
   onclick="event.preventDefault(); document.getElementById('favourite-question-{{ $model->id }}').submit();"
>
    <i class="fas fa-star fa-2x"></i>

    <span class="favourites-count">{{ $model->favourates_count }}</span>
</a>

<form id="favourite-question-{{ $model->id }}" action="/questions/{{ $model->id }}/favourites" method="post" style="display:none">
    @csrf
    @if($model->is_favourated)
        @method('DELETE')
    @endif
</form>
