<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản trị hệ thống')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .wrapper { display: flex; width: 100%; align-items: stretch; min-height: 100vh; }

        /* Sidebar Styling */
        .sidebar { min-width: 260px; max-width: 260px; background: #343a40; color: #fff; transition: all 0.3s; }
        .sidebar .brand { padding: 20px; text-align: center; font-weight: bold; font-size: 1.2rem; background: #212529; border-bottom: 1px solid #4b545c; }
        .sidebar .brand a { color: #fff; text-decoration: none; }

        /* Sidebar Menu */
        .sidebar-menu { padding: 10px 0; }
        .menu-header { color: #cfd2d6; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px 5px 20px; font-weight: 600; }
        .menu-item a { padding: 10px 20px; display: block; color: #c2c7d0; text-decoration: none; border-left: 3px solid transparent; }
        .menu-item a:hover { background: #494e53; color: #fff; }
        .menu-item.active a { background: #007bff; color: #fff; border-left-color: #fff; }
        .menu-item i { width: 25px; text-align: center; margin-right: 5px; }

        /* Content Styling */
        .content { width: 100%; padding: 20px; }
        .navbar-custom { background: #fff; padding: 10px 20px; margin-bottom: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="wrapper">
    <nav class="sidebar">
        <div class="brand">
            <a href="{{ route('admin.dashboard') }}">MHGR ADMIN</a>
        </div>

        @include('admin.partials.sidebar')
    </nav>

    <div class="content">
        <div class="navbar-custom d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-dark">Hệ thống quản trị</h5>
            <div class="user-info">
                <span class="me-2">Xin chào, Admin</span>
                <a href="#" class="btn btn-sm btn-outline-danger">Đăng xuất</a>
            </div>
        </div>

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
