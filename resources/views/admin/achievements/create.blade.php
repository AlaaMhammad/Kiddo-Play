<x-admin title="Add Achievement">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New Achievement</h4>
        <div class="mb-4">
            <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.achievements.store') }}" method="POST">
            @csrf
            <x-form.input name="code" label="Code" required />
            <x-form.input name="title" label="Title" required />
            <x-form.textarea name="description" label="Description" />
            <x-form.number name="points_award" label="Points Award" value="0" />
            <x-form.input name="icon_url" label="Icon URL" />
            <x-form.button label="Save" />
        </form>
    </div>
</x-admin>
