<div style="display:flex; justify-content:center; align-items:center;">
    <img src="{{ \Illuminate\Support\Facades\Storage::url($record->path ?? $record->image_path) }}" alt="Photo" style="max-width: 100%; border-radius: 8px; max-height: 75vh; object-fit: contain;">
</div>
