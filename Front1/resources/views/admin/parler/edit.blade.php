<x-app-layout>
    <x-slot name="title">Modifier la Relation Région-Langue</x-slot>
    <x-slot name="subtitle">Modifier l'association entre {{ $parler->region->nom_region }} et {{ $parler->langue->nom_langue }}</x-slot>

    <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-200/50 p-6">
        <form action="{{ route('admin.parler.update', $parler) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="id_region" class="block text-sm font-medium text-gray-700 mb-2">Région *</label>
                    <select name="id_region" id="id_region" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">Sélectionnez une région</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id_region }}" {{ old('id_region', $parler->id_region) == $region->id_region ? 'selected' : '' }}>
                                {{ $region->nom_region }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_region')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="id_langue" class="block text-sm font-medium text-gray-700 mb-2">Langue *</label>
                    <select name="id_langue" id="id_langue" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                        <option value="">Sélectionnez une langue</option>
                        @foreach($langues as $langue)
                            <option value="{{ $langue->id_langue }}" {{ old('id_langue', $parler->id_langue) == $langue->id_langue ? 'selected' : '' }}>
                                {{ $langue->nom_langue }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_langue')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.parler.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</x-app-layout>