<div wire:poll.30s class="relative min-h-screen bg-cover bg-center overflow-x-hidden" style="background-image: url('{{ asset('images/room.jpg') }}');">

    @if($pet)
    {{-- HUD superior --}}
    <div class="absolute top-6 left-4 md:left-6 flex flex-col space-y-6 z-30">
        {{-- Monedas --}}
        <div class="flex items-center space-x-4 bg-white bg-opacity-90 border border-gray-200 rounded-full px-6 py-4 shadow-2xl">
            <img src="{{ asset('images/icons/money.png') }}" class="h-14 w-14 hover-bounce" alt="Coins">
            <span id="coin-value" class="text-gray-800 text-5xl font-extrabold">{{ $coins }}</span>
        </div>

        {{-- Felicidad --}}
        <div class="flex items-center space-x-4 bg-black bg-opacity-70 border border-white rounded-full px-6 py-4 shadow-2xl">
            <img src="{{ asset('images/icons/happy.png') }}" class="h-14 w-14 hover-bounce" alt="Happiness">
            <span id="happiness-value" class="text-white text-5xl font-extrabold">{{ $pet->happiness }}</span>
        </div>

        {{-- Botón Dormir --}}
        <div class="absolute top-60 left-4 z-20">
            <button id="sleep-toggle"
                class="bg-black text-white text-xl px-10 py-10 rounded-full shadow-lg hover:bg-gray-800 transition font-bold">
                OFF
            </button>
        </div>

        <div id="sleep-overlay"></div>
    </div>



    {{-- Mascota centrada --}}
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">

        <div ondblclick="document.getElementById('edit-pet-name-form').classList.remove('hidden')"
            class="bg-white bg-opacity-80 px-4 py-1 rounded-full shadow-md mb-2 inline-block font-semibold text-gray-800 mt-8 md:mt-16 cursor-custom-click">
            {{ ucfirst($pet->name) }}
        </div>
        <form id="edit-pet-name-form" method="POST" action="{{ route('pet.rename') }}" class="hidden mt-2">
            @csrf
            <input type="text" name="name" class="rounded px-2 py-1" placeholder="New name" required>
            <!-- <button type="submit" class="ml-2 px-3 py-1 bg-green-600 text-white rounded">Save</button> -->
        </form>
        <img
            id="pet-image"
            data-pet="{{ strtolower($pet->petType->name) }}"
            src="{{ asset('images/sprites/' . strtolower($pet->petType->name) . '/' . $pet->petType->sprite_idle) }}"
            alt="Pet"
            class="h-40 md:h-80 drop-shadow-2xl mx-auto transition-transform duration-300">

        <div id="pet-level" class="mt-2 text-4xl font-extrabold text-white outline-white outline-2 outline px-4 py-1 rounded-full" style="text-shadow: 0 0 4px #fff, 0 0 8px #fff;">
            Lvl: {{ $pet->level }}
        </div>
    </div>

    {{-- PANEL DE ESTADÍSTICAS --}}
    <x-statspanel :statsList="$statsList" background="images/roomtexture.png" />

    @else
    <div class="p-6 text-white">No pet assigned</div>
    @endif
</div>