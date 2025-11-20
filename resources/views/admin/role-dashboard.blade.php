{{-- resources/views/admin/role-dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Based Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="mb-3">Welcome, {{ auth()->user()->name }}</h2>

        <p><strong>Your Role:</strong> {{ auth()->user()->role }}</p>

        {{-- Admin Actions --}}
        @if(auth()->user()->role === 'admin')
        <div class="alert alert-primary">Admin Panel Access Granted</div>

        <a href="{{ url('/products') }}" class="btn btn-success mb-2">Manage Products</a>
        <a href="{{ url('/users') }}" class="btn btn-warning mb-2">Manage Users</a>
        @endif

        {{-- Employee Actions --}}
        @if(auth()->user()->role === 'employee')
        <div class="alert alert-info">Employee Panel Access Granted</div>

        <a href="{{ url('/products') }}" class="btn btn-primary mb-2">View Products</a>
        @endif

        <a href="{{ url('/logout') }}" class="btn btn-danger mt-3">Logout</a>
    </div>
</div>
</body>
</html>
