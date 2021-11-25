<body>
  <h2>イベント作成画面</h2>
  <form method="POST" action="/events">
    @csrf
    タイトル
    <input type="text" name="title"><br>
    説明
    <input type="text" name="description"><br>
    場所
    <input type="text" name="place"><br>
    費用
    <input type="text" name="fee"><br>
    公開状態
    <input type="radio" name="published" value="1">公開する
    <input type="radio" name="published" value="0">公開しない<br>
    送信
    <input type="submit">
  </form>
</body>