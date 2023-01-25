<!DOCTYPE html>
<html>
<head>
</head>
<body>

<h2>POSTS</h2>
<h3><strong>Crear una publicacion</strong></h3>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('post.store')  }}" method="POST">
    @csrf
    <!-- TITLE -->
    <label for="title">Titulo de la publicacion</label><br>
    <input type="text" id="title" name="title"><br>
    <br>

    <!-- EXTRACT -->
    <label for="extract">Extracto publicacion</label><br>
    <input type="text" id="extract" name="extract"><br><br>
    <br>

    <!-- CONTENT -->
    <label for="postcontent">Contenido publicacion</label><br>
    <input type="text" id="postcontent" name="postcontent"><br><br>

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



