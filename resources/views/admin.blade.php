<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<button onclick="window.location.href='{{ route('admitted.students') }}'">View Admitted Students</button>
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <h1>Submitted Students</h1>
    <table border="1">
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
                    <form action="{{ route('updateStatus', $student->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label>
                                <input type="checkbox" name="admitted" value="1" {{ $student->admitted_status ? 'checked' : '' }}> Admitted
                            </label>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
