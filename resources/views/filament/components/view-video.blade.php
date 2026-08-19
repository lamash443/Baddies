<div style="display:flex; justify-content:center; align-items:center;">
    <video controls style="max-width: 100%; border-radius: 8px; max-height: 75vh;" preload="metadata">
        <source src="{{ \Illuminate\Support\Facades\Storage::url($record->path) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
</div>
