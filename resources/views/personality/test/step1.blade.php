<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-cyan-400 to-pink-500">
        <form method="POST" action="{{ route('personality.test', ['step' => 1, 'lang' => $lang]) }}" id="quiz-form" class="bg-white bg-opacity-10 p-6 rounded-2xl max-w-2xl w-full text-white">
            @csrf
            <div class="text-right mb-4">
                <a href="{{ route('personality.test', ['step' => 1, 'lang' => 'en']) }}" class="px-3 py-1 bg-white text-pink-600 rounded hover:bg-pink-100">EN 🇬🇧</a>
                <a href="{{ route('personality.test', ['step' => 1, 'lang' => 'es']) }}" class="px-3 py-1 bg-white text-pink-600 rounded hover:bg-pink-100">ES 🇪🇸</a>
            </div>

            <div id="error-message"
                class="hidden mt-4 bg-white font-semibold text-pink-600 px-4 py-2 rounded border border-pink-300 transition-opacity duration-700 opacity-100">
            </div></br>

            @php
                $text = [
                    'en' => [
                        'question' => "Question 1. You are walking in a forest and you find a cute little house with a code… What do you do?",
                        'options' => [
                            'hamster' => "You try the code, 1111, what's the worst that could happen?",
                            'seal' => "You look around the house, maybe there's some clues around.",
                            'hamster2' => "You admire the house and keep walking, but you take a photo of it first.",
                            'fox' => "You are here for very important stuff so you ignore that house.",
                        ],
                        'button' => 'Next →'
                    ],
                    'es' => [
                        'question' => "Pregunta 1. Estás caminando por un bosque y encuentras una casita con código… ¿Qué haces?",
                        'options' => [
                            'hamster' => "Intentas el código 1111, ¿qué es lo peor que podría pasar?",
                            'seal' => "Miras alrededor de la casa, quizás haya pistas.",
                            'hamster2' => "Admiras la casa y sigues caminando, pero le haces una foto.",
                            'fox' => "Has venido a algo importante, así que ignoras la casa.",
                        ],
                        'button' => 'Siguiente →'
                    ]
                ];
            @endphp

            <h1 class="text-xl font-semibold mb-6">
                {{ $text[$lang]['question'] }}
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="options">
                @foreach ($text[$lang]['options'] as $value => $label)
                    <label class="option-label block border-2 border-white/50 rounded-xl p-4 cursor-pointer transition hover:border-white relative">
                        <input type="radio" name="question1" value="{{ str_replace('2','', $value) }}" class="absolute opacity-0 peer">
                        <div class="peer-checked:border-white peer-checked:ring-2 ring-white rounded-xl p-2">
                            {{ $label }}
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="mt-6 text-right">
                <x-button type="submit" class="bg-pink-600 hover:bg-pink-500 active:bg-pink-700 focus:bg-pink-700 text-white font-semibold transition duration-150">
                    {{ $text[$lang]['button'] }}
                </x-button>
            </div>
        </form>
    </div>

    <script>
        const form = document.getElementById('quiz-form');
        const errorBox = document.getElementById('error-message');

        form.addEventListener('submit', function(e) {
            const selected = document.querySelector('input[name="question1"]:checked');
            if (!selected) {
                e.preventDefault();
                errorBox.textContent = "{{ $lang === 'es' ? 'Por favor selecciona una opción antes de continuar.' : 'Please select an option before continuing.' }}";
                errorBox.classList.remove('hidden', 'opacity-0');
                errorBox.classList.add('opacity-100');

                setTimeout(() => {
                    errorBox.classList.remove('opacity-100');
                    errorBox.classList.add('opacity-0');
                    setTimeout(() => {
                        errorBox.classList.add('hidden');
                    }, 700);
                }, 1500);
            /*} else {
                errorBox.classList.add('hidden');*/
            }
        });
    </script>

</x-app-layout>