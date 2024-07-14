<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .content {
            margin-left: 270px; 
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h4>Menu</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
       
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admitted.students') }}">Admitted Students</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>

<div class="content">
    <div class="container mt-5">
        <h2>Welcome to Admin Dashboard</h2>
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Submitted Students</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>TC</th>
                    <th>Mark Sheet</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->age }}</td>
                        <td>{{ $student->address }}</td>
                        <td><a href="{{ Storage::url($student->tc) }}" target="_blank">View TC</a></td>
                        <td><a href="{{ Storage::url($student->marksheet) }}" target="_blank">View Marksheet</a></td>
                        <td>
                            <form action="{{ route('admin.updateAdmittedStatus', $student->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label>
                                    <input type="checkbox" name="admitted" value="1" {{ $student->admitted_status ? 'checked' : '' }}> Admitted
                                </label>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
