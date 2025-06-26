<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tips Belajar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse ($tips as $tip)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100">{{ $tip->judul }}</h3>

                        {{-- Tampilkan badge mata pelajaran jika ada --}}
                        @if ($tip->mataPelajaran)
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $tip->mataPelajaran->nama_mapel }}
                        </span>
                        @endif

                        {{-- Tampilkan konten tips --}}
                        <div class="mt-4 text-gray-700 dark:text-gray-300 prose dark:prose-invert max-w-none">
                            {!! $tip->konten !!} {{-- <-- Gunakan {!! !!} untuk merender HTML --}}
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        <p>Belum ada tips belajar yang ditambahkan.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>