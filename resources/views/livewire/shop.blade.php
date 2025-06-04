<div wire:poll.30s class="relative min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/shopBack.jpg') }}')">

    {{-- Coins arriba a la derecha --}}
    <div class="absolute top-1 left-6 bg-white/80 rounded-full px-5 py-3 flex items-center space-x-2 shadow-xl z-20">
        <img src="{{ asset('images/icons/money.png') }}" class="h-14 w-14 hover-bounce" alt="Coins">
        <span id="coin-value" class="text-gray-800 text-5xl font-extrabold">{{ $coins }}</span>
    </div>

    {{-- Contenido principal --}}
    <div class="flex items-center justify-between px-12 pt-20 space-x-6">

        {{-- Estantería y productos --}}
        <div class="relative w-[350px]">
            <img src="{{ asset('images/shelf.png') }}" class="w-full absolute top-0 left-0 z-0" alt="Shelf">

            <div class="relative z-10 flex flex-col space-y-4 pt-40 pl-10">
                @foreach($accessories as $accessory)
                <div class="flex items-center space-x-6">
                    <div class="image-with-tooltip">
                        <img src="{{ asset('images/items/' . $accessory->image) }}"
                            class="h-28 w-28 hover-bounce drop-shadow-md"
                            alt="{{ $accessory->name }}">
                        <span class="tooltip-message">Sube felicidad: {{ $accessory->happiness_effect }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-2xl text-yellow-600 font-bold">
                            {{ number_format($accessory->price, 2) }}
                        </span>

                        <button wire:click="buy({{ $accessory->id }})"
                            @if($coins < $accessory->price)
                            disabled
                            @endif

                            class="border-2 border-yellow-500 text-yellow-600 font-bold px-4 py-1 rounded-lg transition
                            hover:bg-yellow-100 disabled:opacity-50 disabled:cursor-not-allowed">
                            Buy
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

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

            <div id="pet-level" class="mt-2 text-4xl font-extrabold text-white outline-white outline-2 outline px-4 py-1 rounded-full" style="text-shadow: 0 0 4px #fff, 0 0 8px #fff;">
                Lvl: {{ $pet->level }}
            </div>
        </div>

        {{-- Stats --}}
        <x-statspanel :statsList="$statsList" background="images/shopTexture.png" />
    </div>
</div>