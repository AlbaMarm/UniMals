<div class="relative min-h-screen bg-cover bg-center overflow-x-hidden" style="background-image: url('{{ asset('images/kitchennn.jpg') }}');">

    @if($pet)
        {{-- HUD superior --}}
        <div class="absolute top-6 left-4 md:left-6 flex flex-col space-y-6 z-30">
            {{-- Monedas --}}
            <div class="flex items-center space-x-4 bg-white bg-opacity-90 border border-gray-200 rounded-full px-6 py-4 shadow-2xl">
                <img src="{{ asset('images/icons/money.png') }}" class="h-10 w-10 hover-bounce" alt="Coins">
                <span class="text-gray-800 text-3xl font-extrabold">{{ $coins }}</span>
            </div>

            {{-- Felicidad --}}
            <div class="flex items-center space-x-4 bg-black bg-opacity-70 border border-white rounded-full px-6 py-4 shadow-2xl">
                <img src="{{ asset('images/icons/happy.png') }}" class="h-10 w-10 hover-bounce" alt="Happiness">
                <span id="happiness-value" class="text-white text-3xl font-extrabold">{{ $pet->happiness }}</span>
            </div>
        </div>


        {{-- Mascota centrada --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">

            <div class="bg-white bg-opacity-80 px-4 py-1 rounded-full shadow-md mb-2 inline-block font-semibold text-gray-800 mt-8 md:mt-16">
                {{ ucfirst($pet->petType->name) }}
            </div>
            <img
                id="pet-image"
                data-pet="{{ strtolower($pet->petType->name) }}"
                src="{{ asset('images/sprites/' . strtolower($pet->petType->name) . '/' . $pet->petType->sprite_idle) }}"
                alt="Pet"
                class="h-40 md:h-80 drop-shadow-2xl mx-auto transition-transform duration-300">

            <div class="mt-2 text-2xl font-bold text-purple-700">Lvl: {{ $pet->level }}</div>
        </div>

        {{-- PANEL DE ESTADÍSTICAS --}}
        <aside
            class="fixed bottom-4 left-1/2 transform -translate-x-1/2 w-full max-w-sm md:absolute md:bottom-auto md:top-6 md:right-6 md:left-auto md:translate-x-0 md:w-80 p-4 rounded-2xl shadow-xl z-20"
            style="background-image: url('{{ asset('images/kitchentexture.png') }}'); background-size: cover; background-repeat: no-repeat;">
            <h1 class="text-xl font-bold text-black mb-4">STATS</h1>

            @foreach($statsList as $s)
            <div class="mb-6">
                <div class="flex items-center space-x-3 mb-2 text-black font-bold text-lg md:text-2xl">
                    <img src="{{ asset('images/icons/'.$s['icon']) }}" class="h-8 w-8 md:h-10 md:w-10 hover-bounce" alt="{{ $s['label'] }}">
                    <span>{{ $s['label'] }}</span>
                </div>
                <div class="w-full h-6 md:h-8 bg-white rounded-xl overflow-hidden shadow-inner border-2 border-gray-300">
                    <div class="h-full transition-all duration-300" style="width: {{ $s['value'] }}%; background-color: {{ $s['color'] }};"></div>
                </div>
            </div>
            @endforeach
        </aside>
        
    @else
        <div class="p-6 text-white">No pet assigned</div>
    @endif
</div>