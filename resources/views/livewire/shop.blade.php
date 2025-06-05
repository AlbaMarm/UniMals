<div wire:poll.30s class="relative min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/shopBack.jpg') }}')">

    {{-- Coins arriba a la derecha --}}
    <div class="absolute top-2 left-2 md:top-1 md:left-6 bg-white/80 rounded-full px-4 py-2 md:px-5 md:py-3 flex items-center space-x-2 shadow-xl z-20">
        <img src="{{ asset('images/icons/money.png') }}" class="h-10 w-10 md:h-14 md:w-14 hover-bounce" alt="Coins">
        <span id="coin-value" class="text-gray-800 text-3xl md:text-5xl font-extrabold">{{ $coins }}</span>
    </div>


    {{-- Contenido principal --}}
    <div class="flex flex-col-reverse md:flex-row md:items-center md:justify-between px-4 md:px-12 pt-20 space-y-8 md:space-y-0 md:space-x-6">

        {{-- Estantería y productos --}}
        <div class="relative w-full md:w-[350px] z-10">
            <div class="absolute inset-0 z-0 block md:hidden rounded-xl overflow-hidden">
                <img src="{{ asset('images/shopTexture2.png') }}" class="w-full h-full object-cover" alt="Mobile Shop Background">
            </div>
            <img src="{{ asset('images/shelf.png') }}" class="w-full absolute top-0 left-0 z-0 hidden md:block" alt="Shelf">

            <div class="relative z-10 flex flex-col space-y-4 pt-0 md:pt-40 pl-4 md:pl-10">
                @foreach($accessories as $accessory)
                <div class="flex items-center justify-between md:justify-start space-x-4 md:space-x-6
                            p-2 rounded-xl md:p-0 md:rounded-none
                            bg-white/50 md:bg-transparent shadow-md md:shadow-none">
                    <div class="image-with-tooltip">
                        <img src="{{ asset('images/items/' . $accessory->image) }}"
                            class="h-20 w-20 md:h-28 md:w-28 hover-bounce drop-shadow-md"
                            alt="{{ $accessory->name }}">
                        <span class="tooltip-message">Sube felicidad: {{ $accessory->happiness_effect }}</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-xl md:text-2xl text-yellow-600 font-bold">
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
        <div class="relative flex flex-col items-center justify-center text-center md:absolute md:inset-0">

            <div ondblclick="document.getElementById('edit-pet-name-form').classList.remove('hidden')"
                class="bg-white bg-opacity-80 px-4 py-1 rounded-full shadow-md mb-2 inline-block font-semibold text-gray-800 mt-8 md:mt-16 cursor-custom-click">
                {{ ucfirst($pet->name) }}
            </div>
            <form id="edit-pet-name-form" method="POST" action="{{ route('pet.rename') }}" class="hidden mt-2">
                @csrf
                <input type="text" name="name" class="rounded px-2 py-1" placeholder="New name" required>
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
                class="h-40 md:h-80 drop-shadow-2xl mx-auto transition-transform duration-300 z-40">

            <div id="pet-level" class="mt-2 text-3xl md:text-4xl font-extrabold text-white outline-white outline-2 outline px-4 py-1 rounded-full" style="text-shadow: 0 0 4px #fff, 0 0 8px #fff;">
                Lvl: {{ $pet->level }}
            </div>
        </div>

        {{-- Stats --}}
        <div class="hidden md:block">
            <x-statspanel :statsList="$statsList" background="images/shopTexture.png" />
        </div>
    </div>
</div>