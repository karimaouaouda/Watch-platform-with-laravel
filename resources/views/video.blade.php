<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body oncontextmenu="return false;">
    <video controls>
        <source type="video/mp4" src="{{ route('videosrc') }}"></source>
        <source type="video/ogg" src="{{ route('videosrc') }}"></source>

    </video>
</body>
</html>