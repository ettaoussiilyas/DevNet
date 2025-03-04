<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($notifications->count() > 0)
                        <div class="mb-4 text-right">
                            <button id="mark-all-read" class="text-sm text-blue-500 hover:text-blue-700">
                                Mark all as read
                            </button>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            @foreach($notifications as $notification)
                                <li class="py-4 flex {{ $notification->read ? 'opacity-75' : 'bg-blue-50' }}">
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $notification->message }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    @if(!$notification->read)
                                        <button 
                                            class="mark-as-read text-xs text-blue-500 hover:text-blue-700"
                                            data-id="{{ $notification->id }}"
                                        >
                                            Mark as read
                                        </button>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">You have no notifications.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mark single notification as read
            document.querySelectorAll('.mark-as-read').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    fetch(`/notifications/${id}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('li').classList.remove('bg-blue-50');
                            this.closest('li').classList.add('opacity-75');
                            this.remove();
                        }
                    });
                });
            });

            // Mark all notifications as read
            document.getElementById('mark-all-read').addEventListener('click', function() {
                fetch('/notifications/mark-all-as-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelectorAll('.bg-blue-50').forEach(el => {
                            el.classList.remove('bg-blue-50');
                            el.classList.add('opacity-75');
                        });
                        document.querySelectorAll('.mark-as-read').forEach(el => {
                            el.remove();
                        });
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>