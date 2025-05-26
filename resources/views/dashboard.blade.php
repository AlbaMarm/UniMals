<!-- <x-app-layout>
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
    </div>
</x-app-layout> -->