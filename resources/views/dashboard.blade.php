<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Welcome to UniMals 🐾</h1>

        <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-xl shadow text-gray-800 text-center">
            @php
            $pet = Auth::user()->pet;
            @endphp

            @if ($pet && $pet->petType)
            <h1 class="text-2xl font-bold mb-4">Welcome back, {{ Auth::user()->name }}!</h1>
            <h2 class="text-xl font-semibold text-green-600 mb-2">{{ ucfirst($pet->test_result) }}</h2>
            <p class="mb-4 text-gray-600 italic">{{ $pet->petType->description }}</p>

            <div class="flex justify-center">
                <img src="{{ asset($pet->petType->sprite_idle) }}" alt="{{ $pet->test_result }}" class="w-48 h-48 object-contain">
            </div>
            @else
            <p class="text-gray-500">You don't have a pet yet. Please complete the personality test.</p>
            @endif
        </div>
</x-app-layout>