@props(['title' => '', 'subtitle' => ''])

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
    <div class="text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $title }}</h2>
        @if($subtitle)
            <p class="mt-2 text-gray-600 max-w-3xl mx-auto">{{ $subtitle }}</p>
        @endif
    </div>
</div>
