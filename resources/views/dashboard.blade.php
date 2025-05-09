<x-app-layout>
    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
        <div class="relative w-full h-full max-w-4xl mx-auto flex flex-col">
            <!-- Close button -->
            <button id="closeModal" class="absolute top-4 right-4 text-white text-2xl z-20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-8 w-8">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Navigation buttons -->
            <button id="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-2xl z-20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button id="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-2xl z-20">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-10 w-10">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <!-- Image container -->
            <div class="flex-1 flex items-center justify-center">
                <img id="modalImage" src="" alt="Post image" class="max-h-full max-w-full object-contain">
            </div>
            
            <!-- Image counter -->
            <div class="text-center text-white py-2">
                <span id="currentImageNumber">1</span> / <span id="totalImages">1</span>
            </div>
            
            <!-- Thumbnails -->
            <div id="imageThumbnails" class="flex overflow-x-auto gap-2 p-2 bg-black bg-opacity-50">
                <!-- Thumbnails will be inserted here by JavaScript -->
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    
                </div>
                
            @endif
            
            <div class="flex flex-col md:flex-row md:space-x-6">
                <!-- Left Side - Posts Feed -->
                <div class="flex-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium mb-4">{{ __("Create a New Post") }}</h3>
                            
                            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <textarea name="content" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="What's on your mind?" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="images" class="block text-sm font-medium text-gray-700">Add Images (Optional)</label>
                                    <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full" accept="image/*">
                                    @error('images.*')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <!-- Image preview -->
                                <div id="imagePreviewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4 hidden">
                                    <!-- Preview thumbnails will be inserted here -->
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Post
                                    </button>
                                </div>
                                
                            </form>
                            
                        </div>
                        
                    </div>
                    
                   <!-- Announcements Section -->
@if(isset($announcements) && count($announcements) > 0)
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium">{{ __("Barangay Announcements") }}</h3>
            @if(count($announcements) > 1)
                <button id="toggleAnnouncements" class="flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                    <span id="showMoreText">View All</span>
                    <span id="showLessText" class="hidden">Show Less</span>
                    <svg id="arrowDownIcon" xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg id="arrowUpIcon" xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
            @endif
        </div>
        
        <div class="space-y-4">
            @foreach($announcements as $index => $announcement)
                <div class="announcement-item border-l-4 border-blue-500 pl-4 p-4 rounded-lg bg-blue-50 {{ $index >= 1 ? 'hidden' : '' }}" data-index="{{ $index }}">
                    <div class="flex justify-between items-start">
                        <h4 class="text-lg font-semibold">{{ $announcement->title }}</h4>
                        <span class="text-xs text-gray-500 whitespace-nowrap ml-2">{{ $announcement->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="announcement-content mt-2 {{ strlen($announcement->content) > 150 ? 'announcement-truncated' : '' }}">
                        <p class="announcement-preview">
                            {{ strlen($announcement->content) > 150 ? substr($announcement->content, 0, 150) . '...' : $announcement->content }}
                        </p>
                        
                        @if(strlen($announcement->content) > 150)
                            <p class="announcement-full hidden">{{ $announcement->content }}</p>
                            <button class="read-more-btn text-xs text-blue-600 hover:text-blue-800 mt-1">Read more</button>
                        @endif
                    </div>
                    
                    @if($announcement->image_path)
                        <div class="mt-3">
                            <img src="{{ Storage::url($announcement->image_path) }}" alt="Announcement Image" 
                                class="max-w-full h-auto max-h-40 rounded cursor-pointer announcement-image">
                        </div>
                    @endif
                    
                    <div class="mt-2 text-xs text-gray-500">
                        Posted by Admin {{ $announcement->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Announcement Modal for Images -->
        <div id="announcementImageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
            <div class="relative w-full h-full max-w-4xl mx-auto flex items-center justify-center">
                <!-- Close button -->
                <button id="closeAnnouncementModal" class="absolute top-4 right-4 text-white text-2xl z-20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-8 w-8">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Image container -->
                <div class="flex-1 flex items-center justify-center p-4">
                    <img id="modalAnnouncementImage" src="" alt="Announcement image" class="max-h-full max-w-full object-contain">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for announcements functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle show more/less announcements
    const toggleButton = document.getElementById('toggleAnnouncements');
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            const allAnnouncements = document.querySelectorAll('.announcement-item[data-index]');
            const latestAnnouncement = document.querySelector('.announcement-item[data-index="0"]');
            const showMoreText = document.getElementById('showMoreText');
            const showLessText = document.getElementById('showLessText');
            const arrowDownIcon = document.getElementById('arrowDownIcon');
            const arrowUpIcon = document.getElementById('arrowUpIcon');
            
            // Skip the first announcement (already visible)
            for (let i = 1; i < allAnnouncements.length; i++) {
                allAnnouncements[i].classList.toggle('hidden');
            }
            
            showMoreText.classList.toggle('hidden');
            showLessText.classList.toggle('hidden');
            arrowDownIcon.classList.toggle('hidden');
            arrowUpIcon.classList.toggle('hidden');
        });
    }
    
    // Read more/less for announcement content
    const readMoreButtons = document.querySelectorAll('.read-more-btn');
    readMoreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const contentContainer = this.parentElement;
            const preview = contentContainer.querySelector('.announcement-preview');
            const fullText = contentContainer.querySelector('.announcement-full');
            
            preview.classList.toggle('hidden');
            fullText.classList.toggle('hidden');
            
            if (this.textContent === 'Read more') {
                this.textContent = 'Read less';
            } else {
                this.textContent = 'Read more';
            }
        });
    });
    
    // Announcement image modal
    const announcementImages = document.querySelectorAll('.announcement-image');
    const imageModal = document.getElementById('announcementImageModal');
    const modalImage = document.getElementById('modalAnnouncementImage');
    const closeModalBtn = document.getElementById('closeAnnouncementModal');
    
    announcementImages.forEach(img => {
        img.addEventListener('click', function() {
            modalImage.src = this.src;
            imageModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        });
    });
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            imageModal.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scrolling
        });
        
        // Close on outside click
        imageModal.addEventListener('click', function(e) {
            if (e.target === imageModal) {
                imageModal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    }
});
</script>
@else
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            <h3 class="text-lg font-medium mb-4">{{ __("Announcements") }}</h3>
            <p>No announcements yet.</p>
        </div>
    </div>
@endif
                    
<div class="space-y-8">
    @forelse ($posts ?? [] as $post)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Post Header with User Profile Image -->
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <img src="{{ $post->user->profile_picture_url }}" 
                             alt="{{ $post->user->name }}" 
                             class="h-10 w-10 rounded-full object-cover mr-4 cursor-pointer profile-photo" 
                             data-user-id="{{ $post->user->id }}"
                             data-profile-image="{{ $post->user->profile_picture_url }}"
                             data-username="{{ $post->user->name }}">
                        <div>
                            <div class="font-medium text-gray-800">{{ $post->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    @if (Auth::id() === $post->user_id)
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100" 
                             x-transition:enter-start="transform opacity-0 scale-95" 
                             x-transition:enter-end="transform opacity-100 scale-100" 
                             x-transition:leave="transition ease-in duration-75" 
                             x-transition:leave-start="transform opacity-100 scale-100" 
                             x-transition:leave-end="transform opacity-0 scale-95" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Edit
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
                                    
                                   <!-- Improved Post Caption/Content with proper formatting -->
                                   <div class="mb-4">
    <div class="text-gray-800 leading-snug">
        {!! preg_replace('/(^|\s)(#\w+)/', '$1<span class="text-blue-600">$2</span>', 
            nl2br(e($post->content))) !!}
    </div>
</div>
                                    
                                  <!-- Post Images Gallery -->
@if($post->images->count() > 0 || $post->image_path)
    <div class="mb-4">
        <div class="post-image-gallery" data-post-id="{{ $post->id }}">
            @php 
                $totalImages = $post->images->count() + ($post->image_path ? 1 : 0);
                $imageCount = 0;
                $allImageURLs = [];
                
                // Collect all image URLs first
                if($post->image_path) {
                    $allImageURLs[] = asset('storage/' . $post->image_path);
                }
                
                foreach($post->images as $image) {
                    $allImageURLs[] = asset('storage/' . $image->image_path);
                }
            @endphp
            
            @if($totalImages == 1)
                <!-- Single image display - full width -->
                <div class="post-image-item relative overflow-hidden rounded-lg cursor-pointer" 
                    data-image-url="{{ $allImageURLs[0] }}"
                    data-image-index="0">
                    <img src="{{ $allImageURLs[0] }}" 
                        alt="Post image" 
                        class="w-full h-auto max-h-96 object-contain">
                </div>
            @else
                <!-- Two or more images - Facebook style (show max 2) -->
                <div class="grid grid-cols-2 gap-1">
                    <!-- First image (always shown) -->
                    <div class="post-image-item relative aspect-square overflow-hidden rounded-lg cursor-pointer" 
                        data-image-url="{{ $allImageURLs[0] }}"
                        data-image-index="0">
                        <img src="{{ $allImageURLs[0] }}" 
                            alt="Post image" 
                            class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Second image (with overlay if more than 2 images) -->
                    @if(isset($allImageURLs[1]))
                        <div class="post-image-item relative aspect-square overflow-hidden rounded-lg cursor-pointer" 
                            data-image-url="{{ $allImageURLs[1] }}"
                            data-image-index="1">
                            <img src="{{ $allImageURLs[1] }}" 
                                alt="Post image" 
                                class="w-full h-full object-cover">
                            
                            <!-- Show overlay on the 2nd image if there are more than 2 -->
                            @if($totalImages > 2)
                                <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                                    <span class="text-white text-xl font-bold">+{{ $totalImages - 2 }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
            
            <!-- Hidden images data for modal -->
            <div class="hidden">
                <input type="hidden" class="post-images-data" value="{{ json_encode(array_map(function($url) { return ['url' => $url]; }, $allImageURLs)) }}">
            </div>
        </div>
    </div>
@endif
                                    
                                    <div class="flex items-center space-x-4 mb-4 pt-3 border-t">
                                        <form action="{{ route('posts.like', $post) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center space-x-1 {{ $post->isLikedByUser(Auth::id()) ? 'text-blue-600' : 'text-gray-500' }} hover:text-blue-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                </svg>
                                                <span>{{ $post->likes->count() }} {{ Str::plural('Like', $post->likes->count()) }}</span>
                                            </button>
                                        </form>
                                        
                                        <button type="button" class="flex items-center space-x-1 text-gray-500 hover:text-blue-600" onclick="document.getElementById('comment-form-{{ $post->id }}').classList.toggle('hidden')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            <span>{{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}</span>
                                        </button>
                                    </div>
                                    
                                    <!-- Comment Form -->
                                    <div id="comment-form-{{ $post->id }}" class="mt-3 hidden">
                                        <form action="{{ route('comments.store', $post) }}" method="POST" class="flex">
                                            @csrf
                                            <input type="text" name="content" class="flex-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Write a comment..." required>
                                            <button type="submit" class="ml-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Comment
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <!-- Comments List -->
@if ($post->comments->count() > 0)
    <div class="mt-4 space-y-3 pt-3 border-t">
        <h4 class="text-sm font-medium text-gray-900">Comments</h4>
        
        @foreach ($post->comments as $comment)
            <div class="flex">
                <div class="flex-1">
                    <div class="flex items-center mb-1">
                        <span class="font-medium text-sm">{{ $comment->user->name }}</span>
                        <span class="text-xs text-gray-500 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                        
                        @if (Auth::id() === $comment->user_id)
                            <div class="relative ml-auto" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100" 
                                     x-transition:enter-start="transform opacity-0 scale-95" 
                                     x-transition:enter-end="transform opacity-100 scale-100" 
                                     x-transition:leave="transition ease-in duration-75" 
                                     x-transition:leave-start="transform opacity-100 scale-100" 
                                     x-transition:leave-end="transform opacity-0 scale-95" 
                                     class="absolute right-0 mt-1 w-36 bg-white rounded-md shadow-lg py-1 z-10">
                                    <button onclick="toggleEditComment({{ $comment->id }})" class="block w-full text-left px-4 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                        Edit
                                    </button>
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-xs text-red-600 hover:bg-gray-100">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div id="comment-content-{{ $comment->id }}">
                        <p class="text-sm">{{ $comment->content }}</p>
                    </div>
                    
                    <div id="comment-edit-{{ $comment->id }}" class="hidden mt-1">
                        <form action="{{ route('comments.update', $comment) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="flex">
                                <input type="text" name="content" value="{{ $comment->content }}" class="flex-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <button type="submit" class="ml-2 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                    Save
                                </button>
                                <button type="button" onclick="toggleEditComment({{ $comment->id }})" class="ml-1 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- JavaScript for toggling comment edit form (if not already defined elsewhere) -->
<script>
    function toggleEditComment(commentId) {
        const contentDiv = document.getElementById(`comment-content-${commentId}`);
        const editDiv = document.getElementById(`comment-edit-${commentId}`);
        
        if (contentDiv && editDiv) {
            contentDiv.classList.toggle('hidden');
            editDiv.classList.toggle('hidden');
        }
    }
</script>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900 text-center">
                                    <p>No posts yet. Be the first to post something!</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <!-- Profile Photo Modal -->
<div id="profile-photo-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4" onclick="closeProfilePhotoModal()">
    <div class="max-w-4xl w-full max-h-full flex flex-col items-center" onclick="event.stopPropagation()">
        <!-- Modal header -->
        <div class="bg-white w-full p-4 rounded-t-lg flex justify-between items-center">
            <h3 id="profile-modal-username" class="text-lg font-medium text-gray-900"></h3>
            <button onclick="closeProfilePhotoModal()" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Modal content -->
        <div class="bg-gray-800 w-full overflow-auto flex items-center justify-center">
            <img id="profile-modal-image" src="" alt="Profile photo" class="max-w-full max-h-[80vh]">
        </div>
        
        <!-- Optional: Modal footer with user info/actions -->
        <div id="profile-modal-footer" class="bg-white w-full p-4 rounded-b-lg flex justify-between items-center">
            <a id="view-profile-link" href="#" class="text-blue-600 hover:text-blue-800"></a>
            <!-- Add other profile actions here if needed -->
        </div>
    </div>
</div>

<!-- JavaScript for toggling comment edit form -->
<script>
    function toggleEditComment(commentId) {
        const contentDiv = document.getElementById(`comment-content-${commentId}`);
        const editDiv = document.getElementById(`comment-edit-${commentId}`);
        
        if (contentDiv && editDiv) {
            contentDiv.classList.toggle('hidden');
            editDiv.classList.toggle('hidden');
        }
    }
    
    // Profile Photo Modal Functions
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to all profile photos
        const profilePhotos = document.querySelectorAll('.profile-photo');
        profilePhotos.forEach(photo => {
            photo.addEventListener('click', function() {
                openProfilePhotoModal(
                    this.getAttribute('data-profile-image'),
                    this.getAttribute('data-username'),
                    this.getAttribute('data-user-id')
                );
            });
        });
    });
    
    function openProfilePhotoModal(imageUrl, username, userId) {
        // Set modal content
        document.getElementById('profile-modal-image').src = imageUrl;
        document.getElementById('profile-modal-username').textContent = username;
        
        // Set link to user profile
        document.getElementById('view-profile-link').href = `/profile/${userId}`;
        
        // Show modal
        document.getElementById('profile-photo-modal').classList.remove('hidden');
        
        // Prevent body scrolling
        document.body.style.overflow = 'hidden';
    }
    
    function closeProfilePhotoModal() {
        // Hide modal
        document.getElementById('profile-photo-modal').classList.add('hidden');
        
        // Re-enable body scrolling
        document.body.style.overflow = '';
    }
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProfilePhotoModal();
        }
    });
</script>
                </div>
                
                <!-- Right Side - Chat -->
<div class="w-full md:w-1/3 mt-6 md:mt-0">
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
                            <div class="@if($message->user_id === Auth::id()) text-right @else text-left @endif mb-3">
                                <div class="inline-block max-w-[85%] @if($message->user_id === Auth::id()) bg-blue-100 @else bg-gray-100 @endif p-3 rounded-lg">
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
    
    <script>
        // Toggle comment editing
        function toggleEditComment(commentId) {
            document.getElementById(`comment-content-${commentId}`).classList.toggle('hidden');
            document.getElementById(`comment-edit-${commentId}`).classList.toggle('hidden');
        }
        
        // Image Upload Preview
        document.addEventListener('DOMContentLoaded', function() {
            const inputElement = document.getElementById('images');
            const previewContainer = document.getElementById('imagePreviewContainer');
            
            if (inputElement) {
                inputElement.addEventListener('change', function(e) {
                    previewContainer.innerHTML = '';
                    previewContainer.classList.remove('hidden');
                    
                    if (this.files.length === 0) {
                        previewContainer.classList.add('hidden');
                        return;
                    }
                    
                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i];
                        
                        if (file.type.match('image.*')) {
                            const reader = new FileReader();
                            
                            reader.onload = function(e) {
                                const previewItem = document.createElement('div');
                                previewItem.className = 'relative';
                                
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'w-full h-32 object-cover rounded-lg';
                                previewItem.appendChild(img);
                                
                                const removeBtn = document.createElement('button');
                                removeBtn.type = 'button';
                                removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center';
                                removeBtn.innerHTML = '×';
                                removeBtn.onclick = function() {
                                    previewItem.remove();
                                    
                                    // Check if there are no more preview items
                                    if (previewContainer.children.length === 0) {
                                        previewContainer.classList.add('hidden');
                                    }
                                };
                                previewItem.appendChild(removeBtn);
                                
                                previewContainer.appendChild(previewItem);
                            };
                            
                            reader.readAsDataURL(file);
                        }
                    }
                });
            }
            
            // Image Modal Gallery
            const imageModal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const closeModal = document.getElementById('closeModal');
            const prevImage = document.getElementById('prevImage');
            const nextImage = document.getElementById('nextImage');
            const currentImageNumber = document.getElementById('currentImageNumber');
            const totalImages = document.getElementById('totalImages');
            const imageThumbnails = document.getElementById('imageThumbnails');
            
            let currentImages = [];
            let currentIndex = 0;
            
            // Open modal when clicking on an image
            document.querySelectorAll('.post-image-item').forEach(item => {
                item.addEventListener('click', function() {
                    const postGallery = this.closest('.post-image-gallery');
                    const imagesData = JSON.parse(postGallery.querySelector('.post-images-data').value);
                    currentImages = imagesData;
                    
                    // Set current index
                    currentIndex = parseInt(this.getAttribute('data-image-index'));
                    
                    // Display image
                    showImage(currentIndex);
                    
                    // Show modal
                    imageModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling
                });
            });
            
            // Close modal
            closeModal.addEventListener('click', function() {
                imageModal.classList.add('hidden');
                document.body.style.overflow = '';
            });
            
            // Click outside to close
            imageModal.addEventListener('click', function(e) {
                if (e.target === imageModal) {
                    imageModal.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
            
            // Navigate to previous image
            prevImage.addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = currentImages.length - 1;
                }
                showImage(currentIndex);
            });
            
            // Navigate to next image
            nextImage.addEventListener('click', function() {
                if (currentIndex < currentImages.length - 1) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                showImage(currentIndex);
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (imageModal.classList.contains('hidden')) return;
                
                if (e.key === 'ArrowLeft') {
                    prevImage.click();
                } else if (e.key === 'ArrowRight') {
                    nextImage.click();
                } else if (e.key === 'Escape') {
                    closeModal.click();
                }
            });
            
            // Function to display current image
            function showImage(index) {
                if (!currentImages.length) return;
                
                const imageUrl = currentImages[index].url;
                modalImage.src = imageUrl;
                
                // Update counter
                currentImageNumber.textContent = index + 1;
                totalImages.textContent = currentImages.length;
                
                // Generate thumbnails
                generateThumbnails();
                
                // Highlight current thumbnail
                const thumbnails = imageThumbnails.querySelectorAll('.thumbnail');
                thumbnails.forEach((thumb, i) => {
                    if (i === index) {
                        thumb.classList.add('border-2', 'border-blue-500');
                        thumb.classList.remove('opacity-60');
                    } else {
                        thumb.classList.remove('border-2', 'border-blue-500');
                        thumb.classList.add('opacity-60');
                    }
                });
            }
            
            // Generate thumbnail images
            function generateThumbnails() {
                imageThumbnails.innerHTML = '';
                
                currentImages.forEach((image, index) => {
                    const thumbnail = document.createElement('div');
                    thumbnail.className = `thumbnail h-16 w-16 flex-shrink-0 cursor-pointer overflow-hidden rounded ${index === currentIndex ? 'border-2 border-blue-500' : 'opacity-60'}`;
                    thumbnail.innerHTML = `<img src="${image.url}" class="h-full w-full object-cover">`;
                    thumbnail.addEventListener('click', () => {
                        currentIndex = index;
                        showImage(index);
                    });
                    imageThumbnails.appendChild(thumbnail);
                });
            }
        });
    </script>
</x-app-layout>