@props([
    'items' => [],
    'columns' => [],
    'resource' => '',
    'createRoute' => null,
    'searchable' => true,
    'actions' => ['show', 'edit', 'delete']
])

<div class="bg-white rounded-lg shadow-sm border">
    <!-- En-tête avec bouton créer et recherche -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ $slot }}
                </h2>
            </div>
            
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                @if($searchable)
                <div class="relative">
                    <input 
                        type="text" 
                        placeholder="Rechercher..." 
                        class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        id="searchInput"
                    >
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                @endif
                
                @if($createRoute && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
                <a href="{{ $createRoute }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Créer
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    @foreach($columns as $column)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $column['label'] }}
                    </th>
                    @endforeach
                    
                    @if(!empty($actions))
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($items as $item)
                <tr class="hover:bg-gray-50">
                    @foreach($columns as $column)
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(isset($column['relation']))
                            {{ $item->{$column['relation']}->{$column['key']} ?? 'N/A' }}
                        @elseif(isset($column['format']) && $column['format'] === 'badge')
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $item->{$column['key']} == 'actif' ? 'bg-green-100 text-green-800' : 
                                   ($item->{$column['key']} == 'inactif' ? 'bg-red-100 text-red-800' : 
                                   ($item->{$column['key']} == 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ $item->{$column['key']} }}
                            </span>
                        @elseif(isset($column['format']) && $column['format'] === 'date')
                            {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y') }}
                        @else
                            {{ $item->{$column['key']} }}
                        @endif
                    </td>
                    @endforeach
                    
                    @if(!empty($actions))
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            @if(in_array('show', $actions))
                            <a href="{{ route($resource . '.show', $item) }}" class="text-blue-600 hover:text-blue-900" title="Voir">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            @endif
                            
                            @if(in_array('edit', $actions) && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')))
                            <a href="{{ route($resource . '.edit', $item) }}" class="text-green-600 hover:text-green-900" title="Modifier">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            @endif
                            
                            @if(in_array('delete', $actions) && Auth::user()->hasRole('admin'))
                            <form action="{{ route($resource . '.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif
                            {{-- Valider / Rejeter pour contenus en attente (admin/moderator) --}}
                            @if($resource === 'admin.contenus' && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('moderator')) && isset($item->statut) && $item->statut === 'en_attente')
                                <form method="POST" action="{{ route($resource . '.valider', $item) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700" onclick="return confirm('Valider ce contenu ?')" title="Valider">
                                        Valider
                                    </button>
                                </form>
                                <form method="POST" action="{{ route($resource . '.rejeter', $item) }}" class="inline ml-1">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Rejeter ce contenu ?')" title="Rejeter">
                                        Rejeter
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($columns) + (empty($actions) ? 0 : 1) }}" class="px-6 py-4 text-center text-sm text-gray-500">
                        Aucun élément trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if(method_exists($items, 'hasPages') && $items->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Affichage de {{ $items->firstItem() }} à {{ $items->lastItem() }} sur {{ $items->total() }} résultats
            </div>
            <div class="flex space-x-2">
                {{ $items->links() }}
            </div>
        </div>
    </div>
    @else
    <!-- Info pour les collections sans pagination -->
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="text-sm text-gray-700">
            Affichage de {{ $items->count() }} résultats
        </div>
    </div>
    @endif
</div>

@if($searchable)
<script>
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchValue = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>
@endif