@php
$hideNav = request()->is('test*');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fontawesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr5
        1Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />

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

        /* Cursores */
        body {
            cursor: url('/images/cursor/cursormano.png') 16 16, auto;
        }

        button, a, .clickable {
            cursor: url('/images/cursor/cursordedo.png') 16 16, pointer;
        }

        .cursor-custom-click {
            cursor: url('/images/cursor/cursordedo.png') 16 16, pointer;
        }


       /*  .clickable {
            cursor: pointer;
        } */   

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
    </style>
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
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

            if (petImage) {
                const spritePath = petImage.getAttribute('src');
                const happySprite = spritePath.replace('_idle.png', '_happy.png');
                const idleSprite = spritePath;

                petImage.addEventListener('click', () => {
                    // Animación
                    petImage.style.transform = 'scale(0.95)';
                    petImage.src = happySprite;

                    setTimeout(() => {
                        petImage.style.transform = 'scale(1)';
                        petImage.src = idleSprite;
                    }, 1000);

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
                                    icon: 'success',
                                    title: 'You earned a coin!',
                                    timer: 1500,
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
                                        icon: 'success',
                                        title: 'Your pet has leveled up!',
                                        text: 'Now its ' + data.level + ' :)',
                                        timer: 2000,
                                        showConfirmButton: false,
                                    });
                                }
                            }

                        });
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sleepToggle = document.getElementById('sleep-toggle');
            const overlay = document.getElementById('sleep-overlay');
            const petImage = document.getElementById('pet-image');
            const originalSprite = petImage.getAttribute('src');
            const sleepingSprite = originalSprite.replace('_idle.png', '_sleeping.png');

            let sleeping = false;
            let sleepInterval = null;
            

            if (sleepToggle && overlay && petImage) {
                sleepToggle.addEventListener('click', () => {
                    sleeping = !sleeping;

                    if (sleeping) {
                        sleepToggle.textContent = 'OFF';
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
                        sleepToggle.textContent = 'ON';
                        overlay.style.display = 'none';
                        petImage.src = originalSprite;
                        clearInterval(sleepInterval);
                    }
                });
            }
        });
    </script>

</body>

</html>