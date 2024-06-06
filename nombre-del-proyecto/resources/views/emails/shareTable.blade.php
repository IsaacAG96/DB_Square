<!DOCTYPE html>
<html>
<head>
    <title>Compartir Tabla</title>
</head>
<body>
    <h1>Tabla: {{ ucfirst(str_replace('_', ' ', $table)) }}</h1>
    @if ($message)
        <p><strong>Mensaje:</strong> {{ $message }}</p>
    @endif
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                @foreach (array_keys((array) $data->first()) as $column)
                <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                @foreach ($row as $value)
                <td>{{ $value }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
