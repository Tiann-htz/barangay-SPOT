<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
                <!-- Left Side - Announcements -->
                <div class="w-full md:w-2/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium mb-4">{{ __("Welcome Admin!") }}</h3>
                            <p>Here you can post announcements and manage the Barangay SPOT website.</p>
                            
                            <!-- Add announcement form here -->
                            <form method="POST" action="{{ route('admin.announcements.store') }}" class="mt-6" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <x-input-label for="title" :value="__('Announcement Title')" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>
                                
                                <div class="mt-4">
                                    <x-input-label for="content" :value="__('Announcement Content')" />
                                    <textarea id="content" name="content" rows="4" 
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>{{ old('content') }}</textarea>
                                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                                </div>
                                
                                <div class="mt-4">
                                    <x-input-label for="image" :value="__('Attachment (Image)')" />
                                    <input id="image" name="image" type="file" accept="image/*" 
                                        class="block mt-1 w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100" />
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                                
                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="ms-3">
                                        {{ __('Post Announcement') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- List of Announcements -->
                    <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium mb-4">{{ __("Your Announcements") }}</h3>
                            
                            @if($announcements->isEmpty())
                                <p class="text-gray-500">You haven't posted any announcements yet.</p>
                            @else
                                <div class="space-y-6">
                                    @foreach($announcements as $announcement)
                                        <div class="p-4 border rounded-md">
                                            <div class="flex justify-between items-start">
                                                <h4 class="text-lg font-semibold">{{ $announcement->title }}</h4>
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-blue-600 hover:text-blue-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <p class="mt-2">{{ $announcement->content }}</p>
                                            
                                            @if($announcement->image_path)
                                                <div class="mt-3">
                                                    <img src="{{ Storage::url($announcement->image_path) }}" 
                                                         alt="Announcement: {{ $announcement->title }}" 
                                                         class="max-w-full h-auto max-h-60 rounded cursor-pointer announcement-image hover:opacity-90 transition"
                                                         title="Click to enlarge">
                                                </div>
                                            @endif
                                            
                                            <div class="mt-2 text-sm text-gray-500">
                                                Posted {{ $announcement->created_at->diffForHumans() }}
                                                @if($announcement->created_at != $announcement->updated_at)
                                                    · Updated {{ $announcement->updated_at->diffForHumans() }}
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Chat -->
                <div class="w-full md:w-1/3">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 flex flex-col" style="height: 700px;">
                            <h3 class="text-lg font-medium mb-4">{{ __("Barangay Chat") }}</h3>
                            
                            <!-- Chat Messages Container -->
                            <div id="chat-container" class="flex-1 overflow-y-auto mb-4 border rounded-md p-3" style="height: 550px;">
                                @if($chatMessages->isEmpty())
                                    <p class="text-gray-500 text-center py-4">No messages yet. Start a conversation!</p>
                                @else
                                    <div class="space-y-4">
                                        @foreach($chatMessages->sortBy('created_at') as $message)
                                            <div class="flex space-x-2 @if($message->user_id === Auth::id()) justify-end @endif">
                                                @if($message->user_id !== Auth::id())
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-bold">
                                                        {{ substr($message->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <div class="max-w-[75%] @if($message->user_id === Auth::id()) bg-blue-100 @else bg-gray-100 @endif p-3 rounded-lg">
                                                    <div class="flex justify-between items-start mb-1">
                                                        <p class="text-xs text-gray-600 font-medium">
                                                            {{ $message->user->name }}
                                                            @if($message->user->isAdmin())
                                                                <span class="text-red-600 text-xs">(Admin)</span>
                                                            @endif
                                                        </p>
                                                        @if($message->user_id === Auth::id())
                                                            <div class="flex space-x-1 ml-2">
                                                                <a href="{{ route('chat.messages.edit', $message) }}" class="text-blue-600 hover:text-blue-800">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                    </svg>
                                                                </a>
                                                                <form action="{{ route('chat.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <p class="text-sm break-words">{{ $message->message }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->diffForHumans() }}</p>
                                                </div>
                                                
                                                @if($message->user_id === Auth::id())
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                                        {{ substr(Auth::user()->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Scroll to bottom script -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const chatContainer = document.getElementById('chat-container');
                                    if (chatContainer) {
                                        chatContainer.scrollTop = chatContainer.scrollHeight;
                                    }
                                });
                            </script>

                            <!-- Chat Input Form -->
                            <form action="{{ route('chat.messages.store') }}" method="POST" class="mt-auto">
                                @csrf
                                <div class="flex space-x-2">
                                    <input type="text" name="message" placeholder="Type a message..." required
                                        class="flex-1 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" />
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition text-sm">
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="max-w-4xl w-full mx-4">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-medium" id="modalTitle">Image Preview</h3>
                    <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <img id="modalImage" src="" alt="Announcement Image" class="max-w-full h-auto mx-auto">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all announcement images
            const announcementImages = document.querySelectorAll('.announcement-image');
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const closeModal = document.getElementById('closeModal');
            
            // Add click event to each image
            announcementImages.forEach(image => {
                image.addEventListener('click', function() {
                    // Set the modal image source and title
                    modalImage.src = this.src;
                    modalTitle.textContent = this.alt || 'Announcement Image';
                    
                    // Show the modal
                    imageModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
                });
            });
            
            // Close modal when clicking the close button
            closeModal.addEventListener('click', function() {
                imageModal.classList.add('hidden');
                document.body.style.overflow = ''; // Restore scrolling
            });
            
            // Close modal when clicking outside the image
            imageModal.addEventListener('click', function(event) {
                if (event.target === imageModal) {
                    imageModal.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scrolling
                }
            });
            
            // Close modal when pressing Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !imageModal.classList.contains('hidden')) {
                    imageModal.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scrolling
                }
            });
        });
    </script>
</x-app-layout>