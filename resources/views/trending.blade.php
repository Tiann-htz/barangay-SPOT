<x-app-layout>
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overall Trending Posts Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-blue-800">Popular Posts (3+ Likes)</h3>
                    
                    @if($trendingPosts->isEmpty())
                        <p class="text-gray-600">No trending posts yet. Start liking posts to see them here!</p>
                    @else
                        <div class="space-y-6">
                            @foreach($trendingPosts as $post)
                                <div class="p-4 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ $post->user->profile_picture_url }}" alt="{{ $post->user->name }}">
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex justify-between">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">{{ $post->user->name }}</h4>
                                                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                                </div>
                                                <div class="flex items-center text-yellow-500 font-bold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    {{ $post->likes_count }} Likes
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3">
                                                <p class="text-gray-800 whitespace-pre-line">{{ $post->content }}</p>
                                            </div>
                                            
                                            @if($post->images->count() > 0)
                                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                    @foreach($post->images as $image)
                                                        <div class="relative h-48 bg-gray-100 rounded-lg overflow-hidden">
                                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Post image" class="w-full h-full object-cover">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            <div class="mt-4 flex items-center justify-between">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex items-center">
                                                        <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="flex items-center text-sm {{ $post->isLikedByUser(Auth::id()) ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-500 transition-colors duration-200">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                                </svg>
                                                                <span>{{ $post->isLikedByUser(Auth::id()) ? 'Unlike' : 'Like' }}</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                        <span>{{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Category Based Trending Posts Section -->
            @if(count($postsByCategory) > 0)
                @foreach($postsByCategory as $category => $posts)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-bold mb-4 text-blue-800">Trending in #{{ ucfirst($category) }}</h3>
                            
                            <div class="space-y-6">
                                @foreach($posts as $post)
                                    <div class="p-4 bg-gray-50 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ $post->user->profile_picture_url }}" alt="{{ $post->user->name }}">
                                            </div>
                                            <div class="flex-grow">
                                                <div class="flex justify-between">
                                                    <div>
                                                        <h4 class="font-medium text-gray-900">{{ $post->user->name }}</h4>
                                                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $post->likes_count }} {{ Str::plural('like', $post->likes_count) }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-3">
                                                    <p class="text-gray-800 whitespace-pre-line">{{ $post->content }}</p>
                                                </div>
                                                
                                                @if($post->images->count() > 0)
                                                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                        @foreach($post->images as $image)
                                                            <div class="relative h-48 bg-gray-100 rounded-lg overflow-hidden">
                                                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Post image" class="w-full h-full object-cover">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                
                                                <div class="mt-4 flex items-center justify-between">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex items-center">
                                                            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="flex items-center text-sm {{ $post->isLikedByUser(Auth::id()) ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-500 transition-colors duration-200">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                                    </svg>
                                                                    <span>{{ $post->isLikedByUser(Auth::id()) ? 'Unlike' : 'Like' }}</span>
                                                                </button>
                                                            </form>
                                                        </div>
                                                        <div class="flex items-center text-sm text-gray-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                            </svg>
                                                            <span>{{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            
            <!-- No Categories Found Message -->
            @if(count($postsByCategory) == 0 && $trendingPosts->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">No trending content found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Start creating posts with hashtags like #barangayCleanup, #reports, #events, etc.<br>
                                Or like posts to see them appear in the trending section!
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Go to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>