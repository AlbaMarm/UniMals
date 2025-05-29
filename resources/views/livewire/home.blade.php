<div wire:poll.30s class="relative min-h-screen bg-cover bg-center overflow-x-hidden" style="background-image: url('{{ asset('images/background_roomm.jpg') }}');">

    {{-- AVISO de resultado del test --}}
    @if (session('pet_result'))
    @php
    $petResult = session('pet_result');
    $names = ['seal' => 'Seal', 'hamster' => 'Hamster', 'fox' => 'Fox'];
    $imagePaths = [
    'seal' => 'seal/sealLoope_happy.png',
    'hamster' => 'hamster/hamsterKoko_happy.png',
    'fox' => 'fox/foxGarnel_happy.png',
    ];
    @endphp

    <div id="pet-alert" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50 transition-opacity duration-500">
        <div class="bg-white text-center p-6 rounded-xl shadow-xl max-w-sm">
            <h2 class="text-2xl font-bold text-pink-600 mb-2">You got: {{ $names[$petResult] }}!</h2>
            <img src="{{ asset('images/sprites/' . $imagePaths[$petResult]) }}" alt="{{ $petResult }}" class="mx-auto h-32 w-32 object-contain mb-4">
            <p class="text-gray-600">Enjoy this adventure !</p>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('pet-alert');
            if (alert) {
                alert.classList.add('opacity-0');
                setTimeout(() => alert.remove(), 1000);
            }
        }, 4000);
    </script>
    @endif

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

    {{-- Panel de estadísticas --}}
    <x-statspanel :statsList="$statsList" background="images/wood_stats.png" />


    {{-- BOTONES INFERIORES --}}
    <!-- <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 z-30">
            <button class="px-6 py-3 bg-white/80 rounded-full shadow-lg font-semibold pointer-events-auto">LOGOUT</button>
            <button class="px-6 py-3 bg-red-600/80 rounded-full shadow-lg font-semibold text-white pointer-events-auto">DELETE</button>
        </div> -->


    @else
    <div class="p-6 text-white">No pet assigned</div>
    @endif
</div>