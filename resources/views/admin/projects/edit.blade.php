<x-admin-layout>
    <x-slot name="header">Edit Project</x-slot>

    <div class="max-w-4xl">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.projects.update', $project->id) }}">
                @csrf
                @method('PUT')

                <x-admin.form-select
                    label="Category"
                    name="category_id"
                    required
                >
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $project->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-admin.form-select>

                <x-admin.form-input
                    label="Title"
                    name="title"
                    :value="$project->title"
                    required
                />

                <x-admin.form-input
                    label="Slug"
                    name="slug"
                    :value="$project->slug"
                />

                <x-admin.form-input
                    label="Client"
                    name="client"
                    :value="$project->client"
                />

                <x-admin.form-textarea
                    label="Description"
                    name="description"
                    :value="$project->description"
                    rows="3"
                />

                <x-admin.form-textarea
                    label="Content"
                    name="content"
                    :value="$project->content"
                    rows="10"
                />

                <x-admin.form-input
                    label="Project Date"
                    name="project_date"
                    type="date"
                    :value="$project->project_date ? $project->project_date->format('Y-m-d') : ''"
                />

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="featured" value="1" {{ $project->featured ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Featured Project</span>
                    </label>
                </div>

                <x-admin.form-input
                    label="Published At"
                    name="published_at"
                    type="datetime-local"
                    :value="$project->published_at ? $project->published_at->format('Y-m-d\TH:i') : ''"
                />

                <div class="flex space-x-3">
                    <x-admin.button type="submit" variant="primary">
                        Update Project
                    </x-admin.button>

                    <a href="{{ route('admin.projects.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg text-sm font-medium transition">
                        Cancel
                    </a>

                    <form method="POST" action="{{ route('admin.projects.destroy', $project->id) }}" onsubmit="return confirm('Are you sure?')" class="ml-auto">
                        @csrf
                        @method('DELETE')
                        <x-admin.button type="submit" variant="danger">
                            Delete Project
                        </x-admin.button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>