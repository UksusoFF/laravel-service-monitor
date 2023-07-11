<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="host" content="{{ config('app.url') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" href="/favicon.ico" />

    <script type="module" crossorigin src="/assets/index.js?{{ config('version.hash') }}"></script>
    <link rel="stylesheet" href="/assets/index.css?{{ config('version.hash') }}">
</head>
<body>
<div id="app"></div>
</body>
</html>
