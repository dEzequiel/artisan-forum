<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
    <style>
        .alert-danger {
            color: red;
        }
    </style>

</head>
<body>

<h3><strong>Add Post</strong></h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('post.store')  }}" method="POST">
    @csrf
    <!-- TITLE -->
    <label for="title">Title</label><br>
    <input type="text" id="title" name="title" value="{{ old('title')  }}" ><br> <!-- required -->

    @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <br>

    <!-- EXTRACT -->
    <label for="extract">Short Description</label><br>
    <input type="text" id="extract" name="extract" value="{{ old('extract')  }}"><br>

    @error('extract')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <br>

    <!-- CONTENT -->
    <label for="content">Content</label><br>
    <input type="text" id="body" name="body" value="{{ old('body')  }}"><br> <!-- required -->
    @error('body')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <br>

    <!-- CHECKBOX -->
    <label><input type="checkbox" id="cboxcaducable" value="caducable"><strong>Caducable</strong></label>
    <label><input type="checkbox" id="cboxcomentable" value="comentable"><strong>Comentable</strong></label><br>

    <!-- SELECT -->
    <label>
        <select name="acceso">
            <option value="privado">Privado</option>
            <option value="Publico">Publico</option>
        </select>
    </label>

    <input type="submit" value="Submit">
</form>

</body>
</html>



