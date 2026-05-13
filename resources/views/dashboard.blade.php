<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel de Controle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Gerenciamento do Sistema</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="border p-4 rounded-lg hover:bg-gray-50 transition">
                            <h4 class="font-bold text-blue-600">Produtos</h4>
                            <p class="text-sm text-gray-600 mb-4">Gerencie os itens da sua vitrine.</p>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('products.create') }}" class="text-sm bg-blue-500 text-white px-3 py-1 rounded text-center">Novo Produto</a>
                                <a href="{{ route('products') }}" class="text-sm border border-gray-300 px-3 py-1 rounded text-center">Listar Todos</a>
                            </div>
                        </div>

                        <div class="border p-4 rounded-lg hover:bg-gray-50 transition">
                            <h4 class="font-bold text-green-600">Categorias</h4>
                            <p class="text-sm text-gray-600 mb-4">Crie novos tipos de produtos.</p>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('types.create') }}" class="text-sm bg-green-500 text-white px-3 py-1 rounded text-center">Nova Categoria</a>
                            </div>
                        </div>

                        <div class="border p-4 rounded-lg hover:bg-gray-50 transition flex flex-col justify-between">
                            <div>
                                <h4 class="font-bold text-purple-600">Ver Loja</h4>
                                <p class="text-sm text-gray-600">Veja como os clientes enxergam seu site.</p>
                            </div>
                            <a href="{{ url('/') }}" target="_blank" class="text-sm bg-purple-500 text-white px-3 py-1 rounded text-center mt-4">Abrir Vitrine</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>