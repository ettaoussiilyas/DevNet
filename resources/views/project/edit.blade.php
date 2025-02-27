<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Your Projects</h2>
        <button type="button"
                onclick="openProjectModal()"
                class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors">
            Add Project
        </button>
    </div>

    <div class="p-6">
        <!-- Project Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($projects as $project)
                <div class="group relative bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $project->name }}</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $project->descreption }}</p>
                    <div class="mt-4 flex gap-2">
                        @if($project->technologies)
                            @foreach($project->technologies as $tech)
                                <span class="px-3 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300 rounded-full">
                        {{ $tech }}
                    </span>
                            @endforeach
                        @endif
                    </div>

                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button type="button"
                                onclick="editProject({{ $project->id }})"
                                class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">No projects yet. Create your first project!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Project Modal -->
    <div id="projectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-xl max-w-2xl w-full mx-4 overflow-hidden">
            <form id="projectForm" method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Project</h3>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Project Name -->
                    <div>
                        <label for="project_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Project Name</label>
                        <input type="text" id="project_name" name="name" class="mt-1 w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700"></textarea>
                    </div>

                    <!-- Technologies -->
                    <div>
                        <label for="technologies" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Technologies</label>
                        <input type="text" id="technologies" name="technologies"
                               placeholder="e.g. Laravel, Vue.js, PostgreSQL"
                               class="mt-1 w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>
                </div>
                <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-end space-x-3">
                    <button type="button"
                            onclick="closeProjectModal()"
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">
                        Save Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openProjectModal() {
        document.getElementById('projectModal').classList.remove('hidden');
    }

    function closeProjectModal() {
        document.getElementById('projectModal').classList.add('hidden');
    }

    function editProject(projectId) {
        // Fetch project data and open modal with data
        // Implementation depends on your backend
    }
</script>
