<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Virtual - Vitrine</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <header class="bg-white border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-16 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-gray-200 flex items-center justify-center rounded">
                    <span class="text-xs font-bold">LOGO</span>
                </div>
                <h1 class="font-bold text-xl text-gray-800">Minha Loja Virtual</h1>
            </div>

            <div class="flex gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Painel</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium border rounded-md hover:bg-gray-50">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-sm">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        
        <div class="bg-white p-6 rounded-lg shadow-sm border mb-8">
            <form method="GET" action="{{ url('/') }}" class="flex flex-wrap gap-4 items-center">
                
                <div class="flex-1 min-w-[250px]">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Buscar produto pelo nome..."
                        class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 outline-none"
                    >
                </div>

                <div class="w-full md:w-auto">
                    <select name="type_id" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Todos os tipos</option>
                        @foreach ($types as $type)
                            <option 
                                value="{{ $type->id }}" 
                                @selected(request('type_id') == $type->id)>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-blue-700 transition shadow-sm">
                    Filtrar
                </button>

                @if(request('search') || request('type_id'))
                    <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:underline">Limpar filtros</a>
                @endif
            </form>
        </div>

        <div class="text-center mb-10">
            <h2 class="inline-block px-8 py-2 bg-gray-200 text-gray-700 font-bold italic rounded">Lista de produtos</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="bg-white border rounded-lg overflow-hidden flex flex-col shadow-sm hover:shadow-md transition-shadow">
                    <div class="relative h-48 bg-gray-100 flex items-center justify-center border-b">
                        <svg class="w-full h-full text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="absolute text-xs font-bold text-gray-400 uppercase">Imagem</span>
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">
                            {{ $product->type->name ?? 'Geral' }}
                        </span>
                        <h3 class="font-bold text-gray-800 text-lg mt-1 mb-2">{{ $product->name }}</h3>
                        
                        <div class="mt-auto">
                            <p class="text-2xl font-black text-gray-900">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Disponível: {{ $product->quantity }} unidades</p>
                            
                            <button class="w-full mt-4 border-2 border-gray-800 text-gray-800 font-bold py-2 rounded hover:bg-gray-800 hover:text-white transition">
                                Ver Detalhes
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded border">
                    <p class="text-gray-500 font-medium">Nenhum produto encontrado com esses critérios.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>