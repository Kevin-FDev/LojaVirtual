<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Novo Produto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Nome do Produto')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="type_id" :value="__('Categoria')" />
                        <select name="type_id" id="type_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="price" :value="__('Preço')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" required />
                        </div>
                        <div>
                            <x-input-label for="quantity" :value="__('Quantidade')" />
                            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" required />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Descrição')" />
                        <textarea name="description" id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Imagem do Produto')" />
                        <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Cadastrar Produto') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>