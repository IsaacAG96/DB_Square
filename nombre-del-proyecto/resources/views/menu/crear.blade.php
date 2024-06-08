<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">{{ __('Menu Options') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Create Menu') }}</li>
            </ol>
        </nav>
        <!-- End Breadcrumb -->

        <h1 class="mb-4">{{ __('Create Menu') }}</h1>

        <!-- Form to create menu -->
        <form action="{{ route('menu.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">{{ __('Menu Name') }}</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
            <a href="{{ route('menu.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
