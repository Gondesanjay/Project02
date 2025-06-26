<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Ujian Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('ujian.store') }}" class="space-y-6">
                        @csrf

                        {{-- Dropdown Mata Pelajaran --}}
                        <div>
                            <x-input-label for="mata_pelajaran_id" :value="__('Mata Pelajaran')" />
                            <select id="mata_pelajaran_id" name="mata_pelajaran_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach ($mataPelajarans as $mapel)
                                <option value="{{ $mapel->id }}" @if(old('mata_pelajaran_id')==$mapel->id) selected @endif>{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('mata_pelajaran_id')" />
                        </div>

                        {{-- Nama Ujian --}}
                        <div>
                            <x-input-label for="nama_ujian" :value="__('Nama Ujian (cth: UTS, Kuis 2)')" />
                            <x-text-input id="nama_ujian" name="nama_ujian" type="text" class="mt-1 block w-full" :value="old('nama_ujian')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_ujian')" />
                        </div>

                        {{-- Lokasi / Ruang Ujian --}}
                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi / Ruang Ujian (Opsional)')" />
                            <x-text-input id="lokasi" name="lokasi" type="text" class="mt-1 block w-full" :value="old('lokasi')" placeholder="Contoh: R.401, Gedung A" />
                            <x-input-error class="mt-2" :messages="$errors->get('lokasi')" />
                        </div>

                        {{-- Tanggal & Waktu Ujian --}}
                        <div>
                            <x-input-label for="tanggal_ujian" :value="__('Tanggal & Waktu Ujian')" />
                            <x-text-input id="tanggal_ujian" name="tanggal_ujian" type="datetime-local" class="mt-1 block w-full" :value="old('tanggal_ujian')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_ujian')" />
                        </div>

                        {{-- Catatan (Opsional) --}}
                        <div>
                            <x-input-label for="catatan" :value="__('Catatan (Opsional)')" />
                            <textarea id="catatan" name="catatan" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('catatan') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('catatan')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            <a href="{{ route('ujian.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>