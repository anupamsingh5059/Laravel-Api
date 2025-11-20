<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light p-4">
<div class="container mt-5 col-md-4">
<h3 class="mb-3">Register</h3>
<form method="POST" action="{{ route('register.submit') }}">
@csrf
<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control">
</div>
<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control">
</div>
<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control">
</div>
<div class="mb-3">
<label>Confirm Password</label>
<input type="password" name="password_confirmation" class="form-control">
</div>
<button class="btn btn-primary w-100">Register</button>
</form>
</div>
</body>
</html>