<x-admin title="Edit Achievement">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Achievement</h4>
        <div class="mb-4">
            <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.achievements.update', $achievement) }}" method="POST">
            @csrf
            @method('PUT')
            <x-form.input name="code" label="Code" value="{{ $achievement->code }}" required />
            <x-form.input name="title" label="Title" value="{{ $achievement->title }}" required />
            <x-form.textarea name="description" label="Description">{{ $achievement->description }}</x-form.textarea>
            <x-form.number name="points_award" label="Points Award" value="{{ $achievement->points_award }}" />
            <x-form.input name="icon_url" label="Icon URL" value="{{ $achievement->icon_url }}" />
            <x-form.button label="Update" />
        </form>
    </div>
</x-admin>
