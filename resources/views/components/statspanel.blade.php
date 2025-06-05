@props(['statsList', 'background'])

<aside class="w-full md:w-96
    p-6 md:p-8
    rounded-3xl text-black shadow-2xl
    z-10 md:z-30
    bg-cover bg-center
    static md:absolute
    md:top-6 md:right-6
    mx-auto md:mx-0
    mt-6 md:mt-0 mb-6"
    style="background-image: url('{{ asset($background) }}'); background-size: cover;">
    <h2 class="text-3xl md:text-4xl font-extrabold mb-4 md:mb-6">STATS</h2>
    @foreach($statsList as $s)
    <div class="mb-4 md:mb-6">
        <div class="flex items-center space-x-3 mb-1">
            <img src="{{ asset('images/icons/'.$s['icon']) }}" class="h-8 w-8 hover-bounce" alt="{{ $s['label'] }}">
            <span class="font-bold text-lg md:text-2xl">{{ $s['label'] }}</span>
        </div>

        <div class="w-full h-5 md:h-6 bg-white rounded-full overflow-hidden border-2 border-gray-300">
            <div class="h-full transition-all duration-300"
                data-stat="{{ strtolower($s['label']) }}"
                style="width: {{ $s['value'] }}%; background-color: {{ $s['color'] }};">
            </div>
        </div>

    </div>
    @endforeach
</aside>