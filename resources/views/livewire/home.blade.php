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

        <button onclick="confirmDeletePet()" class="px-4 py-2 bg-red-600 text-white rounded shadow-lg hover:bg-red-800 hover:text-red-300">
            <i class="fa-solid fa-heart-crack"></i> Delete Pet
        </button>

        @if(count($accessorySummary))
        <div class="absolute top-6 right-4 md:static z-30 w-44 md:w-auto">

            <div class="bg-white bg-opacity-80 rounded-xl shadow-md px-4 py-3 
                text-center md:text-left space-y-1 text-sm font-medium text-gray-800">
                <h3 class="text-lg font-bold text-yellow-700">Purchased Items</h3>
                @foreach($accessorySummary as $name => $count)
                <div>{{ $count }} x {{ $name }}</div>
                @endforeach
            </div>

            {{-- Imagen debajo solo en móvil --}}
            @if ($lastAccessory)
            <div class="mt-2 block md:hidden">
                <img src="{{ asset('images/items/' . $lastAccessory->image) }}"
                    alt="{{ $lastAccessory->name }}"
                    class="h-20 w-20 mx-auto drop-shadow-2xl transition-transform hover:scale-105" />
            </div>
            @endif

        </div>
        @endif


        @livewire('heal-pet')


    </div>


    {{-- Mascota centrada --}}
    <div class="flex flex-col items-center justify-center text-center 
            relative md:absolute inset-0">

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
            src="{{ asset('images/sprites/' . strtolower($pet->petType->name) . '/' . strtolower($spriteFile)) }}"
            alt="Pet"
            class="h-40 md:h-80 drop-shadow-2xl mx-auto transition-transform duration-300 z-40 ">


        <div id="pet-level" class="mt-2 text-4xl font-extrabold text-white outline-white outline-2 outline px-4 py-1 rounded-full" style="text-shadow: 0 0 4px #fff, 0 0 8px #fff;">
            Lvl: {{ $pet->level }}
        </div>

        @if ($lastAccessory)
        <div class="absolute left-1/2 transform -translate-x-[180%] bottom-32 md:bottom-36 z-10 hidden md:block">

            <img src="{{ asset('images/items/' . $lastAccessory->image) }}"
                alt="{{ $lastAccessory->name }}"
                class="h-24 w-24 drop-shadow-2xl transition-transform hover:scale-105" />
        </div>
        @endif

    </div>


    {{-- Panel de estadísticas --}}
    <x-statspanel :statsList="$statsList" background="images/wood_stats.png" />
    @else
    <div class="p-6 text-white">No pet assigned</div>
    @endif
</div>
<script>
    function confirmDeletePet() {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete your pet and restart the game.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('pet.destroy') }}", {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });
            }
        });
    }
</script>