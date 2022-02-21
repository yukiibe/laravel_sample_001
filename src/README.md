# イベント予約システム / Event Participation System

※このシステムはサンプル用に作成したものです。

## __概要 / Summary__
このイベント予約システムは、イベントの作成や編集、作成したイベントへ予約する機能などを提供する。<br>

1. [__技術と環境 / Technology and Environment__](#technology-and-environment)
2. [__機能 / Function__](#function)
3. [__モデルテーブル / Model Table__](#model-table)
4. [__ルーティング / Routing__](#routing)
5. [__イメージ / Image__](#image)
6. [__課題 / Issue__](#issue)


<a id="technology-and-environment"></a>
### 1. __技術と環境 / Technology and Environment__
---
* Laravel 8
* Vue（CDN）
* Vuetify（CDN）
* Docker for Desktop
* Ubuntu
* Visual Studio Code
* Mailtrap

<a id="function"></a>
### 2. __機能 / Function__
---
ユーザーには `organizer` 権限か、 `participant` 権限が用意されている。<br>

■ Organizer権限のユーザーに提供する主な機能
* イベントの作成、編集、削除
* イベントの一覧の表示
* 自分が作成したイベントに対する予約一覧の表示

■ Participant権限のユーザーに提供する主な機能
* イベントの一覧の表示
* イベント予約の一覧の表示
* イベントの予約、キャンセル

■ URL
| Function | URL | Description |
| ---- | ---- | ---- |
| 新規登録 | http://localhost/register | organizer か participant を選択して登録 |
| ログイン | http://localhost/login ||
| イベント一覧 | http://localhost/events ||
| 予約一覧 | http://localhost/participations ||

<a id="model-table"></a>
### 3. __モデルテーブル / Model Table__
---

#### __Userモデル__

| Column | Type | Modifier |
| ---- | ---- | ---- |
| id | id | auto increment |
| name | string ||
| email | string | unique |
| password | string ||
| role | string | default 'participant' |

※その他は省略

#### __Eventモデル__

| Column | Type | Modifier |
| ---- | ---- | ---- |
| id | id | auto increment |
| user_id | foreignId ||
| title | string ||
| description | string ||
| place | string ||
| fee | string ||
| published | boolean | default 0 |

※その他は省略

#### __EventFileモデル__

| Column | Type | Modifier |
| ---- | ---- | ---- |
| id | id | auto increment |
| event_id | foreignId ||
| file | string | default '' |

#### __Participationモデル__

| Column | Type | Modifier |
| ---- | ---- | ---- |
| id | id | auto increment |
| user_id | foreignId ||
| event_id | foreignId ||

※その他は省略

<a id="routing"></a>
### 4. __ルーティング / Routing__
---

#### __Eventsに対する操作__

| Verb | URI | Action | Route Name |
| ---- | ---- | ---- | ---- |
| GET | /events | index | events.index |
| POST | /events | store | events.store |
| PUT | /events/{event} | update | events.update |
| DELETE | /events/{event} | destroy | events.destroy |

#### __EventFilesに対する操作__

| Verb | URI | Action | Route Name |
| ---- | ---- | ---- | ---- |
| POST | /event_files/{event_file}/upload | upload | event_files.upload |
| POST | /event_files/{event_file}/delete | delete | event_files.delete |

#### __Participationsに対する操作__

| Verb | URI | Action | Route Name |
| ---- | ---- | ---- | ---- |
| GET | /participations | index | participations.index |
| POST | /participations | store | participations.store |
| GET | /participations/{participation} | show | participations.show |
| DELETE | /participations/{participation} | destroy | participations.destroy |

<a id="image"></a>
### 5. __イメージ / Image__
---

<a id="issue"></a>
### 6. __課題 / Issue__
---

課題や今後追加したい機能などを挙げる。

* リマインダー機能。開催日時が設定されたイベントについて、参加したユーザーに対して前日などにリマインドメールを送信する。
* LaravelのテンプレートエンジンにCDNのVueやVuetifyを埋め込んで使用している。本来ならSPAのようにVueとLaravelは別サーバで実装するのが理想。その場合、ページ操作などをすべてVueで請け負い、LaravelはAPIとして機能する。現在は同じサーバの想定で実装しており、Laravel側はRestful APIを意識しているが、前述の理由で厳密にはRestful APIの設計になっていない。DockerでVueが動く用のコンテナを新たに作成して実現したい。
* イベントタグ機能。イベントにタグを設定することができ、イベント一覧表示では、イベントタグでイベントをソートできる。