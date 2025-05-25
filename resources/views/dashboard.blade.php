<x-app-layout>
    <div class="relative min-h-screen bg-cover bg-center overflow-x-hidden" style="background-image: url('{{ asset('images/background_roomm.jpg') }}');">

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
                    setTimeout(() => alert.remove(), 500);
                }
            }, 4000);
        </script>
        @endif

        @php
        $pet = Auth::user()->pet;
        $coins = Auth::user()->coins->balance ?? 0;
        $status = $pet->status ?? null;
        @endphp

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

        {{-- Panel de estadísticas --}}
        <aside
            class="fixed bottom-4 left-1/2 transform -translate-x-1/2 w-full max-w-sm md:absolute md:bottom-auto md:top-6 md:right-6 md:left-auto md:translate-x-0 md:w-80 p-4 rounded-2xl shadow-xl z-20"
            style="background-image: url('{{ asset('images/wood_stats.png') }}'); background-size: cover; background-repeat: no-repeat;">
            <h1 class="text-xl font-bold text-black mb-4">STATS</h1>

            @php
            $statsList = [
            ['icon'=>'hunger.png', 'label'=>'Hunger', 'value'=>$status->hunger, 'color'=>'#5b3b0b'],
            ['icon'=>'thirst.png', 'label'=>'Thirst', 'value'=>$status->thirst, 'color'=>'#3b82f6'],
            ['icon'=>'sleep.png', 'label'=>'Sleepiness','value'=>$status->sleepiness,'color'=>'#1e3a8a'],
            ['icon'=>'clean.png', 'label'=>'Cleanliness','value'=>$status->cleanliness,'color'=>'#16a34a'],
            ];
            @endphp

            @foreach($statsList as $s)
            <div class="mb-6">
                <div class="flex items-center space-x-3 mb-2 text-black font-bold text-lg md:text-2xl">
                    <img src="{{ asset('images/icons/'.$s['icon']) }}" class="h-8 w-8 md:h-10 md:w-10 hover-bounce" alt="{{ $s['label'] }}">
                    <span>{{ $s['label'] }}</span>
                </div>
                <div class="w-full h-6 md:h-8 bg-white rounded-xl overflow-hidden shadow-inner border-2 border-gray-300">
                    <div class="h-full transition-all duration-300"
                        style="width: {{ $s['value'] }}%; background-color: {{ $s['color'] }};"></div>
                </div>
            </div>
            @endforeach
        </aside>

        {{-- BOTONES INFERIORES --}}
        <!-- <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 z-30">
            <button class="px-6 py-3 bg-white/80 rounded-full shadow-lg font-semibold pointer-events-auto">LOGOUT</button>
            <button class="px-6 py-3 bg-red-600/80 rounded-full shadow-lg font-semibold text-white pointer-events-auto">DELETE</button>
        </div> -->


        @else
        <div class="p-6 text-white">No pet assigned</div>
        @endif
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const petImage = document.getElementById('pet-image');
        const happinessText = document.getElementById('happiness-value');

        if (petImage) {
            const spritePath = petImage.getAttribute('src');
            const happySprite = spritePath.replace('_idle.png', '_happy.png');
            const idleSprite = spritePath;

            petImage.addEventListener('click', () => {
                petImage.style.transform = 'scale(0.95)';
                setTimeout(() => petImage.style.transform = 'scale(1)', 150);
                petImage.src = happySprite;

                // Petición para actualizar felicidad, he puesto csrf token y route de Laravel
                fetch("{{ route('pet.happiness') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.happiness !== undefined) {
                            happinessText.textContent = data.happiness;
                        }
                    });

                setTimeout(() => {
                    petImage.src = idleSprite;
                }, 1000);

            });
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const petImage = document.getElementById('pet-image');

        if (petImage) {
            petImage.addEventListener('mouseenter', () => {
                petImage.style.transform = 'translateY(-10px) rotate(-2deg)';
            });

            petImage.addEventListener('mouseleave', () => {
                petImage.style.transform = 'translateY(0) rotate(0)';
            });
        }
    });
</script>
<style>
    .hover-bounce {
        transition: transform 0.3s ease;
    }

    .hover-bounce:hover {
        transform: translateY(-8px) rotate(-3deg);
    }
</style>