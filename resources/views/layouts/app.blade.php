<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal resmi Badan Kepegawaian Daerah Kabupaten Konawe Kepulauan.">
    <title>@yield('title') - BKD Kabupaten Konawe Kepulauan</title>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400..800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100 bg-body-tertiary text-body">
    @include('layouts.partials.navbar')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <div class="toast-container position-fixed bottom-0 end-0 p-3 notification-layer">
        <div id="notification-box" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true" data-bs-delay="4000">
            <div class="d-flex">
                <div id="notification-text" class="toast-body">Pesan Anda berhasil dikirim.</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
            </div>
        </div>
    </div>
</body>
</html>
