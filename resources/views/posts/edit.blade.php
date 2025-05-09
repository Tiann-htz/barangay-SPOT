<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea id="content" name="content" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Current Images -->
                        @if($post->images->count() > 0 || $post->image_path)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @if($post->image_path)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="h-40 w-full object-cover rounded-lg">
                                            <label class="absolute top-0 right-0 mt-2 mr-2 bg-white p-1 rounded-lg shadow">
                                                <input type="checkbox" name="delete_legacy_image" value="1">
                                                <span class="text-xs">Delete</span>
                                            </label>
                                        </div>
                                    @endif
                                    
                                    @foreach($post->images as $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Post image" class="h-40 w-full object-cover rounded-lg">
                                            <label class="absolute top-0 right-0 mt-2 mr-2 bg-white p-1 rounded-lg shadow">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                                <span class="text-xs">Delete</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <!-- Add New Images -->
                        <div class="mb-4">
                            <label for="images" class="block text-sm font-medium text-gray-700">Add New Images</label>
                            <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full" accept="image/*">
                            @error('images.*')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="flex justify-between">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Update Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>