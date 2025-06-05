<div wire:poll.30s class="relative min-h-screen bg-cover bg-center overflow-x-hidden" style="background-image: url('{{ asset('images/Group 1.jpg') }}');">

    @if($pet)
    {{-- HUD superior --}}
    <div class="absolute top-6 left-4 md:left-6 flex flex-col space-y-4 md:space-y-6 z-30 items-start w-full md:w-auto">
        {{-- Monedas --}}
        <div class="flex items-center space-x-2 md:space-x-4 bg-white bg-opacity-90 border border-gray-200 rounded-full px-4 md:px-6 py-2 md:py-4 shadow-2xl">
            <img src="{{ asset('images/icons/money.png') }}" class="h-10 w-10 md:h-14 md:w-14 hover-bounce" alt="Coins">
            <span id="coin-value" class="text-gray-800 text-3xl md:text-5xl font-extrabold">{{ $coins }}</span>
        </div>

        {{-- Felicidad --}}
        <div class="flex items-center space-x-2 md:space-x-4 bg-black bg-opacity-70 border border-white rounded-full px-4 md:px-6 py-2 md:py-4 shadow-2xl">
            <img src="{{ asset('images/icons/happy.png') }}" class="h-10 w-10 md:h-14 md:w-14 hover-bounce" alt="Happiness">
            <span id="happiness-value" class="text-white text-3xl md:text-5xl font-extrabold">{{ $pet->happiness }}</span>
        </div>

        {{-- Botón Bañarse --}}
        <div class="absolute bottom-6 right-4 flex md:static md:mt-6 z-30">
            <button id="clean-button"
                class="bg-green-600 text-white text-xl px-10 py-10 rounded-full shadow-lg hover:bg-green-800 hover:text-green-300 transition font-bold">
                CLEAN <i class="fa-solid fa-shower"></i>
            </button>
        </div>
    </div>


    {{-- Mascota centrada --}}
    <div class="flex flex-col items-center justify-center text-center relative md:absolute inset-0">

        <div ondblclick="document.getElementById('edit-pet-name-form').classList.remove('hidden')"
            class="bg-white bg-opacity-80 px-4 py-1 rounded-full shadow-md mb-2 inline-block font-semibold text-gray-800 mt-8 md:mt-16 cursor-custom-click">
            {{ ucfirst($pet->name) }}
        </div>
        <form id="edit-pet-name-form" method="POST" action="{{ route('pet.rename') }}" class="hidden mt-2">
            @csrf
            <input type="text" name="name" class="rounded px-2 py-1" placeholder="New name" required>
            <!-- <button type="submit" class="ml-2 px-3 py-1 bg-green-600 text-white rounded">Save</button> -->
        </form>

        @php
        $spriteFile = trim($isSad
        ? $pet->petType->sprite_sad
        : $pet->petType->sprite_idle);
        @endphp

        <img
            id="pet-image"
            wire:key="{{ $isSad ? 'sad' : 'idle' }}"
            wire:poll.30s
            src="{{ asset('images/sprites/' . strtolower($pet->petType->name) . '/' . $spriteFile) }}"
            alt="Pet"
            class="h-40 md:h-80 drop-shadow-2xl mx-auto transition-transform duration-300">

        <img id="bubbles-image" src="{{ asset('images/bubbles.png') }}" class="bubbles" />

        <div id="pet-level" class="mt-2 text-4xl font-extrabold text-white outline-white outline-2 outline px-4 py-1 rounded-full" style="text-shadow: 0 0 4px #fff, 0 0 8px #fff;">
            Lvl: {{ $pet->level }}
        </div>
    </div>

    {{-- PANEL DE ESTADÍSTICAS --}}
    <x-statspanel :statsList="$statsList" background="images/bathtexture.png" />

    @else
    <div class="p-6 text-white">NO PET ASSIGNED YET, GO TO HOME !!</div>
    @endif
</div>