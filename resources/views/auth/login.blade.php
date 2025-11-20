<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">
<div class="container mt-5 col-md-4">
<h3 class="mb-3">Login</h3>
<form method="POST" action="{{ route('login.submit') }}">
@csrf
<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>
<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control">
</div>
<button class="btn btn-success w-100">Login</button>
</form>
</div>
</body>
</html>