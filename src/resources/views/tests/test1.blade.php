<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
</head>
<body>
  <form action="/test1" method="post">
    @csrf
    テキストエリア
    <textarea name="fieldTextarea"></textarea>
    <input type="submit" value="submit">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
  </form>
</body>
</html>