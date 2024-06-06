<!-- resources/views/pdf/table.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Exportación de Tabla - {{ $table }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Exportación de Tabla: {{ ucfirst(str_replace('_', ' ', $table)) }}</h2>
    <table>
        <thead>
            <tr>
                @foreach (array_keys((array) $data->first()) as $column)
                <th>{{ $column == 'id_propietario' ? 'Propietario' : $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                @foreach ($row as $key => $value)
                <td>
                    @if ($key == 'id_propietario')
                    {{ $owners[$value] }}#{{ $value }}
                    @else
                    {{ $value }}
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
