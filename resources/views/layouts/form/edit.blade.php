<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Catregories') }}
            </h2>
            <div>
                <a href="{{ route('categories.index') }}"
                    class="bg-primary hover:bg-blue-500 hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">All</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('categories.store', $category->slug) }}" method="POST">
                        @csrf

                        <div class="mb-5">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter Name: Ex: Servay"  />
                            @error('name')
                                <div class="valid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="my-5 pt-5">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                            <textarea type="text" name="description" id="description"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Enter Description:">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="valid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-5">
                            <button type="submit"
                            class="bg-primary hover:bg-blue-500 hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Submit</button>
                        </div>    
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
