<button {{ $attributes->merge(['type' => 'submit',
    'class' => 'inline-flex items-center gap-1.5 bg-campus-blue hover:bg-campus-blue-d text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm hover:shadow-md']) }}>
    {{ $slot }}
</button>
