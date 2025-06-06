@php
$hideNav = request()->is('test*');
@endphp
@php
$hideLoader = request()->is('test*');
@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('appicon.ico') }}">

    <!-- Fontawesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <style>
        .hover-bounce {
            transition: transform 0.3s ease;
        }

        .hover-bounce:hover {
            transform: translateY(-8px) rotate(-3deg);
        }

        /* mensajito motivacional arriba */
        #motivational-toast {
            top: 80px; 
            max-width: 90%;
            padding: 8px 20px;
            border-radius: 9999px; 
            font-size: 1rem;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.85);
            color: #d97706; 
            border: 2px solid #facc15;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            white-space: nowrap;
            z-index: 9999;
            text-align: center;
            opacity: 0;
            transform: translate(-50%, -20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        #motivational-toast.show {
            opacity: 1;
            transform: translate(-50%, 0);
        }


        /* Cursores */
        body {
            cursor: url('/images/cursor/cursormano.png') 16 16, auto;
        }

        button,
        a,
        .clickable {
            cursor: url('/images/cursor/cursordedo.png') 16 16, pointer;
        }

        .cursor-custom-click {
            cursor: url('/images/cursor/cursordedo.png') 16 16, pointer;
        }

        #sleep-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(10, 10, 10, 0.7);
            z-index: 10;
            display: none;
        }

        .pet-sleeping {
            filter: grayscale(100%) brightness(0.7);
        }

        .bubbles {
            position: absolute;
            top: 50%;
            left: 50%;
            height: 12rem;
            z-index: 20;
            transform: translate(-50%, -50%);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s ease-in-out;
            animation: float 2s ease-in-out infinite;
        }

        #loader-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        #loader-overlay.fade-out {
            opacity: 0;
            pointer-events: none;
        }


        /* Mensajito para los objetos de la tienda */
        .image-with-tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip-message {
            visibility: hidden;
            width: max-content;
            background-color: #000000;
            color: #ffffff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 12px;
            position: absolute;
            z-index: 10;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s, bottom 0.3s;
            pointer-events: none;
            white-space: nowrap;
        }

        .image-with-tooltip:hover .tooltip-message {
            visibility: visible;
            opacity: 1;
            bottom: calc(100% + 10px);
        }

        /* Esto hace una flachita, para que sea como un bocadillo */
        .tooltip-message::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #000000 transparent transparent transparent;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-banner />
    <!-- Pantalla de carga -->
    @if (!$hideLoader)
    <div id="loader-overlay" class="fixed inset-0 bg-white z-50 flex items-center justify-center transition-opacity duration-500">
        <div class="loader-animation text-center">
            <img src="{{ asset('images/icons/loading.gif') }}" class="w-24 h-24 mb-4" alt="Loading...">
            <p class="text-gray-600 font-medium">Loading...</p>
        </div>
    </div>
    @endif


    <div class="min-h-screen bg-yellow-100">
        @if (!$hideNav)
        @livewire('navigation-menu')
        @endif

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('message'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Done!',
            text: "{{ session('message') }}",
            timer: 2000,
            showConfirmButton: false,
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const petImage = document.getElementById('pet-image');
            const happinessText = document.getElementById('happiness-value');
            const coinText = document.getElementById('coin-value');
            if (!petImage) return;

            petImage.addEventListener('click', () => {
                const spritePath = petImage.getAttribute('src');
                if (!spritePath.includes('_idle.png')) return;
                const happySprite = spritePath.replace('_idle.png', '_happy.png');
                const idleSprite = spritePath;

                // Animación
                petImage.style.transform = 'scale(0.95)';
                petImage.src = happySprite;

                setTimeout(() => {
                    petImage.style.transform = 'scale(1)';
                    petImage.src = idleSprite;
                }, 1000);

                const messages = [
                    "⯨ Your pet adores you! ⯩",
                    "⯨ You're doing a great job! ⯩",
                    "⯨ Thanks for taking such good care of your Unimal! ⯩",
                    "⯨ Keep it up, your pet loves you! ⯩",
                    "⯨ You're their favorite human! ⯩",
                    "⯨ Your pet is so happy! ⯩",
                    "⯨ Your pet is so grateful for your love! ⯩",
                    "⯨ Your pet is so lucky to have you! ⯩",
                    "⯨ Remember to drink water! ⯩",
                    "⯨ Your friends are always there for you! ⯩",
                ];

                if (Math.random() < 0.4) {
                    const randomIndex = Math.floor(Math.random() * messages.length);
                    const toast = document.getElementById('motivational-toast');
                    const message = document.getElementById('motivational-message');

                    if (toast && message) {
                        message.textContent = messages[randomIndex];
                        toast.classList.remove('hidden');
                        toast.classList.add('show');

                        setTimeout(() => {
                            toast.classList.remove('show');
                            toast.classList.add('hidden');
                        }, 2500);
                    }
                }


                // AJAX: Actualizar felicidad y monedas
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
                        if (data.happiness !== undefined && happinessText) {
                            happinessText.textContent = data.happiness;
                        }

                        if (data.balance !== undefined && coinText) {
                            coinText.textContent = data.balance;
                        }

                        if (data.earned && data.earned > 0) {
                            Swal.fire({
                                imageUrl: 'images/icons/dollar.png',
                                imageWidth: 100,
                                imageHeight: 100,
                                imageAlt: 'coin icon',
                                title: 'You earned a coin!',
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }

                        if (data.level !== undefined) {
                            const levelDisplay = document.getElementById('pet-level');
                            if (levelDisplay) {
                                levelDisplay.textContent = 'Lvl: ' + data.level;
                            }

                            if (data.leveledUp) {
                                Swal.fire({
                                    imageUrl: 'images/icons/star.png',
                                    imageWidth: 100,
                                    imageHeight: 100,
                                    imageAlt: 'level up icon',
                                    title: 'Your pet has leveled up!',
                                    text: 'Level ' + data.level + ' :D',
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                            }
                        }

                    });
            });

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

    <!-- Script animacion sueño -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sleepToggle = document.getElementById('sleep-toggle');
            const overlay = document.getElementById('sleep-overlay');
            const petImage = document.getElementById('pet-image');

            if (!sleepToggle || !overlay || !petImage) return;

            let sleeping = false;
            let sleepInterval = null;

            sleepToggle.addEventListener('click', () => {
                const currentSrc = petImage.getAttribute('src');
                const sleepingSprite = currentSrc.replace(/(_idle|_sad)\.png$/, '_sleeping.png');

                sleeping = !sleeping;

                if (sleeping) {
                    sleepToggle.textContent = 'ON';
                    overlay.style.display = 'block';
                    petImage.src = sleepingSprite;

                    sleepInterval = setInterval(() => {
                        fetch("{{ route('pet.sleep') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({})
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.sleepiness !== undefined) {
                                    const sleepBar = document.querySelector('[data-stat="sleepiness"]');
                                    if (sleepBar) sleepBar.style.width = data.sleepiness + '%';
                                }
                            });
                    }, 2000);

                } else {
                    sleepToggle.textContent = 'OFF';
                    overlay.style.display = 'none';
                    petImage.src = currentSrc;
                    clearInterval(sleepInterval);
                }
            });
        });
    </script>


    <!-- Script animacion comer y beber -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const eatToggle = document.getElementById('eat-toggle');
            const drinkToggle = document.getElementById('drink-toggle');
            const petImage = document.getElementById('pet-image');

            if (!eatToggle || !drinkToggle || !petImage) return;

            eatToggle.addEventListener('click', () => {
                const currentSrc = petImage.getAttribute('src');
                const eatingSprite = currentSrc.replace(/(_idle|_sad)\.png$/, '_eating.png');

                petImage.src = eatingSprite;

                fetch("{{ route('pet.eat') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.hunger !== undefined) {
                            const hungerBar = document.querySelector('[data-stat="hunger"]');
                            if (hungerBar) hungerBar.style.width = data.hunger + '%';
                        }
                    });

                setTimeout(() => {
                    petImage.src = currentSrc;
                }, 2000);
            });

            drinkToggle.addEventListener('click', () => {
                const currentSrc = petImage.getAttribute('src');
                const drinkingSprite = currentSrc.replace(/(_idle|_sad)\.png$/, '_drinking.png');

                petImage.src = drinkingSprite;

                fetch("{{ route('pet.drink') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({})
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.thirst !== undefined) {
                            const thirstBar = document.querySelector('[data-stat="thirst"]');
                            if (thirstBar) thirstBar.style.width = data.thirst + '%';
                        }
                    });

                setTimeout(() => {
                    petImage.src = currentSrc;
                }, 2000);
            });
        });
    </script>


    <!-- script animacion burbujas baño -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cleanButton = document.getElementById('clean-button');
            const bubblesImage = document.getElementById('bubbles-image');

            if (cleanButton && bubblesImage) {
                cleanButton.addEventListener('click', () => {
                    bubblesImage.style.opacity = '1';

                    fetch("{{ route('pet.bathe') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({})
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.cleanliness !== undefined) {
                                const cleanlinessBar = document.querySelector('[data-stat="cleanliness"]');
                                if (cleanlinessBar) cleanlinessBar.style.width = data.cleanliness + '%';
                            }
                        });

                    setTimeout(() => {
                        bubblesImage.style.opacity = '0';
                    }, 2500);
                });
            }
        });
    </script>
    <script>
        setInterval(() => {
            fetch("{{ route('pet.stats') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.hunger !== undefined) {
                        document.querySelector('[data-stat="hunger"]').style.width = data.hunger + '%';
                    }
                    if (data.thirst !== undefined) {
                        document.querySelector('[data-stat="thirst"]').style.width = data.thirst + '%';
                    }
                    if (data.cleanliness !== undefined) {
                        document.querySelector('[data-stat="cleanliness"]').style.width = data.cleanliness + '%';
                    }
                    if (data.sleepiness !== undefined) {
                        document.querySelector('[data-stat="sleepiness"]').style.width = data.sleepiness + '%';
                    }
                });
        }, 1000);
    </script>

    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('loader-overlay');
            if (loader) {
                loader.classList.add('fade-out');
                setTimeout(() => {
                    loader.remove();
                }, 300);
            }
        });
    </script>
</body>

</html>