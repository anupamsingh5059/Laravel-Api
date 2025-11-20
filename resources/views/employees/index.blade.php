<!DOCTYPE html>
<html>
<head>
<title>Employee List</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<div class="container">
<div class="d-flex justify-content-between">
<h3>Employees</h3>
<a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
</div>


<table class="table table-bordered mt-3">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Position</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
@foreach($employees as $emp)
<tr>
<td>{{ $emp->id }}</td>
<td>{{ $emp->name }}</td>
<td>{{ $emp->email }}</td>
<td>{{ $emp->phone }}</td>
<td>{{ $emp->position }}</td>
<td>
<a href="{{ route('employees.edit', $emp->id) }}" class="btn btn-warning btn-sm">Edit</a>
<form action="{{ route('employees.delete', $emp->id) }}" method="POST" style="display:inline-block;">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm">Delete</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</body>
</html>