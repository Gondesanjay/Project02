<x-mail::message>
    # Pengingat Jadwal Ujian

    Halo,

    Ini adalah pengingat bahwa Anda memiliki jadwal ujian yang akan datang:

    **Ujian:** {{ $ujian->nama_ujian }}
    **Mata Pelajaran:** {{ optional($ujian->mataPelajaran)->nama_mapel }}
    **Tanggal:** {{ $ujian->tanggal_ujian->format('l, d F Y \p\u\k\u\l H:i') }}

    Mohon persiapkan diri Anda dengan baik. Semangat!

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>