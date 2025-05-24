
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .sidebar {
            background-color: #343a40;
            color: white;
            min-height: 100vh;
            padding: 1rem;
        }
        @media (min-width: 768px) {
            .sidebar {
                position: fixed;
                width: 240px;
                top: 0;
                left: 0;
                bottom: 0;
                overflow-y: auto;
            }
            .main-content {
                margin-left: 240px;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Toggle Button -->
<nav class="navbar navbar-dark bg-dark d-md-none">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Sidebar -->
<div class="collapse d-md-block sidebar" id="sidebarCollapse">
    @include('partials.sidebar')
</div>

<!-- Main Content -->
<div class="main-content p-4">
    @yield('content')
</div>

@stack('scripts')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
     setTimeout(() => {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
</body>
</html>
