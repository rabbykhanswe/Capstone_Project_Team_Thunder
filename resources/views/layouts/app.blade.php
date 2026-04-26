<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $site['meta_description'] ?? 'Buy fresh indoor & outdoor plants online in Bangladesh.' }}">
    <title>@yield('title', $site['site_name'] ?? config('app.name'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicone.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        green: {
                            50:'#f0fdf4',100:'#dcfce7',200:'#bbf7d0',300:'#86efac',
                            400:'#4ade80',500:'#22c55e',600:'#16a34a',700:'#15803d',
                            800:'#166534',900:'#14532d'
                        },
                        emerald: {
                            50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',
                            400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',
                            800:'#065f46',900:'#064e3b'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Global Base Styles -->
    <style>
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .line-clamp-1 { overflow:hidden; display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; }
        .line-clamp-2 { overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
        .line-clamp-3 { overflow:hidden; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <!-- Header CSS -->
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    
    <!-- Footer CSS -->
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    
    <!-- Additional Page Styles -->
    @stack('styles')
</head>
<body>
    <!-- Header Navigation -->
    @include('partials.header')
    
    <!-- Main Content -->
    <main style="margin:0;padding:0;">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
