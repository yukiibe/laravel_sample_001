<body>
  <h2>{{ $event->title }}（イベント詳細画面）</h2>
  <p>現在の予約数：
  <form method="POST" action="/participations">
    @csrf
    参加者id
    <input type="text" name="participant_id">
    <br>
    <input type="hidden" name="id" value="{{ $event->id }}">
    <br>
    このイベントに参加する<br>
    <input type="submit" value="参加">
  </form>
</body>