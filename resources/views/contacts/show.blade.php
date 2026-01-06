<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .detail-group {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .detail-group label {
            display: block;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .detail-group p {
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            font-size: 14px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        .button-group {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        .button-group form {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Contact Details</h1>

        <div class="detail-group">
            <label>ID</label>
            <p>{{ $contact->id }}</p>
        </div>

        <div class="detail-group">
            <label>Name</label>
            <p>{{ $contact->name }}</p>
        </div>

        <div class="detail-group">
            <label>Email</label>
            <p>{{ $contact->email }}</p>
        </div>

        <div class="detail-group">
            <label>Phone</label>
            <p>{{ $contact->phone ?? 'N/A' }}</p>
        </div>

        <div class="detail-group">
            <label>Created At</label>
            <p>{{ $contact->created_at->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="detail-group">
            <label>Updated At</label>
            <p>{{ $contact->updated_at->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="button-group">
            <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning">Edit</a>

            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this contact?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</body>

</html>