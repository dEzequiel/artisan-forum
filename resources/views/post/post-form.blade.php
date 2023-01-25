<!DOCTYPE html>
<html>
<head>
</head>
<body>

<h2>POSTS</h2>
<h3><strong>Crear una publicacion</strong></h3>
<form action="/posts" method="POST">
    @csrf
    <!-- TITLE -->
    <label for="title">Titulo de la publicacion</label><br>
    <input type="text" id="title" name="title"><br>
    <br>

    <!-- EXTRACT -->
    <label for="content">Extracto publicacion</label><br>
    <input type="text" id="extract" name="extract"><br><br>
    <br>

    <!-- CONTENT -->
    <label for="content">Contenido publicacion</label><br>
    <input type="text" id="postcontent" name="postcontent"><br><br>

    <!-- CHECKBOX -->
    <label><input type="checkbox" id="cboxcaducable" value="caducable"><strong>Caducable</strong></label>
    <label><input type="checkbox" id="cboxcomentable" value="comentable"><strong>Comentable</strong></label><br>

    <!-- SELECT -->
    <select name="acceso">
        <option value="privado">Privado</option>
        <option value="Publico">Publico</option>
    </select>

    <input type="submit" value="Submit">

</form>

<p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>

</body>
</html>



