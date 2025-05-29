<div class="relative min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('images/shopBack.jpg') }}')">

    {{-- Coins arriba a la derecha --}}
    <div class="absolute top-1 left-6 bg-white/80 rounded-full px-5 py-3 flex items-center space-x-2 shadow-xl z-20">
        <img src="{{ asset('images/icons/money.png') }}" class="h-14 w-14 hover-bounce" alt="Coins">
        <span id="coin-value" class="text-gray-800 text-5xl font-extrabold">{{ $coins }}</span>
    </div>

    {{-- Contenido principal --}}
    <div class="flex items-center justify-between px-12 pt-20 space-x-6">

        {{-- Estantería y productos --}}
        <div class="relative w-[350px]">
            <img src="{{ asset('images/shelf.png') }}" class="w-full" alt="Shelf">

            {{-- Producto 1 --}}
            <div class="absolute top-[140px] left-[40px] flex items-center space-x-4">
                <img src="{{ asset('images/items/basketball.png') }}" class="h-40 w-40 hover-bounce" alt="Ball">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl text-yellow-600 font-bold">3</span>
                    <button class="border-2 border-yellow-500 text-yellow-600 font-bold px-4 py-1 rounded-lg hover:bg-yellow-100 transition">Buy</button>
                </div>
            </div>

            {{-- Producto 2 --}}
            <div class="absolute top-[270px] left-[40px] flex items-center space-x-4">
                <img src="{{ asset('images/items/flower.png') }}" class="h-40 w-40 hover-bounce" alt="Flower">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl text-yellow-600 font-bold">2</span>
                    <button class="border-2 border-yellow-500 text-yellow-600 font-bold px-4 py-1 rounded-lg hover:bg-yellow-100 transition">Buy</button>
                </div>
            </div>

            {{-- Producto 3 --}}
            <div class="absolute top-[400px] left-[40px] flex items-center space-x-4">
                <img src="{{ asset('images/items/teddybear.png') }}" class="h-40 w-40 hover-bounce" alt="Teddy Bear">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl text-yellow-600 font-bold">8</span>
                    <button class="border-2 border-yellow-500 text-yellow-600 font-bold px-4 py-1 rounded-lg hover:bg-yellow-100 transition">Buy</button>
                </div>
            </div>
        </div>

        {{-- Mascota centrada --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">

            <div ondblclick="document.getElementById('edit-pet-name-form').classList.remove('hidden')"
                class="bg-white bg-opacity-80 px-4 py-1 rounded-full shadow-md mb-2 inline-block font-semibold text-gray-800 mt-8 md:mt-16 cursor-pointer">
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

            <div class="mt-2 text-4xl font-extrabold text-white outline-white outline-2 outline px-4 py-1 rounded-full" style="text-shadow: 0 0 4px #fff, 0 0 8px #fff;">
                Lvl: {{ $pet->level }}
            </div>
        </div>

        {{-- Stats --}}
        <x-statspanel :statsList="$statsList" background="images/shopTexture.png" />
    </div>
</div>