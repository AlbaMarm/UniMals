@props(['statsList', 'background'])

<aside class="w-96 p-8 rounded-3xl text-black shadow-2xl absolute top-6 right-6 z-30"
    style="background-image: url('{{ asset($background) }}'); background-size: cover;">
    <h2 class="text-4xl font-extrabold mb-6">STATS</h2>
    @foreach($statsList as $s)
        <div class="mb-6">
            <div class="flex items-center space-x-4 mb-2">
                <img src="{{ asset('images/icons/'.$s['icon']) }}" class="h-10 w-10 hover-bounce" alt="{{ $s['label'] }}">
                <span class="font-bold text-2xl">{{ $s['label'] }}</span>
            </div>
            <div class="w-full h-6 bg-white rounded-full overflow-hidden border-2 border-gray-300">
                <div class="h-full transition-all duration-300"
                    style="width: {{ $s['value'] }}%; background-color: {{ $s['color'] }};"></div>
            </div>
        </div>
    @endforeach
</aside>
