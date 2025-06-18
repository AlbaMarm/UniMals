<x-app-layout>
    {{-- Fondo amarillo claro (yellow-100) --}}
    <div class="min-h-screen bg-yellow-100 py-10">
        <x-self.base>
            <h3 class="text-2xl font-bold text-center mb-6">Give me some feedback!</h3>

            @if (session('mensaje'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    x-transition.opacity.duration.300ms
                    class="mx-auto w-full md:w-1/2 mb-6 px-4 py-3 
                        {{ session('mensaje') === 'Email sent successfully!' 
                            ? 'bg-green-100 border-green-400 text-green-800' 
                            : 'bg-red-100 border-red-400 text-red-800' }} 
                        border rounded-lg shadow-sm transition-opacity duration-500">
                    {{ session('mensaje') }}
                </div>
            @endif

            <div class="mx-auto w-full md:w-1/2 bg-white border border-gray-200 rounded-2xl shadow-yellow-200 shadow-lg p-6">
                <form action="{{ route('contacto.procesar') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Your name (min 4 characters)"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg 
                                   bg-white text-gray-900 placeholder-gray-400 
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="body" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea
                            id="body"
                            name="body"
                            rows="5"
                            placeholder="Write your feedback, suggestion, or question... (min 10 characters)"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg 
                                   bg-white text-gray-900 placeholder-gray-400 
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >{{ old('body') }}</textarea>
                        @error('body')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end mt-6">
                        <button
                            type="submit"
                            class="flex items-center bg-blue-600 text-white px-6 py-2 rounded-lg 
                                   hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-800 transition"
                        >
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </x-self.base>
    </div>
</x-app-layout>
