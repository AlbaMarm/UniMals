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
</body>

</html>