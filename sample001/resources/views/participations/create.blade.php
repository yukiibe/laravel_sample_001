<body>
  <form method="POST" action="/participations/create">
    @csrf
    参加者id
    <input type="text" name="participant_id">
    <br>
    イベントid
    <input type="text" name="event_id">
  </form>
</body>