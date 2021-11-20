<body>
  <form method="POST" action="/participations">
    @csrf
    参加者id
    <input type="text" name="participant_id">
    <br>
    イベントid
    <input type="text" name="event_id">
    <br>
    送信
    <input type="submit">
  </form>
</body>