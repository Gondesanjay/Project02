<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kalender Ujian') }}
        </h2>
    </x-slot>

    {{-- Memuat library FullCalendar --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Wadah untuk kalender --}}
                    <div id='calendar' style="min-height: 70vh;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk inisialisasi kalender --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // --- INI ADALAH PERBAIKAN TIMEZONE ---
                timeZone: 'Asia/Jakarta',

                locale: 'id', // Mengatur bahasa ke Indonesia
                initialView: 'dayGridMonth', // Tampilan awal adalah bulan

                // Tombol-tombol di header kalender
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },

                // Masukkan data event dari controller
                events: @json($events),

                // Fungsi yang dijalankan saat sebuah event (ujian) di-klik
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.open(info.event.url, "_blank");
                    }
                }
            });

            // "Gambar" kalender di dalam div
            calendar.render();
        });
    </script>
</x-app-layout>