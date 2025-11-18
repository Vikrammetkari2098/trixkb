<!DOCTYPE html>
<html>
<head>
    <title>{{ $article->name }} - AI Response</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.5; }
        h1 { color: #09325d; }
        p { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>{{ $article->name }}</h1>
    <hr>
    <p>{{ $aiResponse }}</p>
</body>
</html>
