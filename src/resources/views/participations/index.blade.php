<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
  <div id="app">
    <v-app>

      <!-- Navigation Drawer -->
      <x-navigation-drawer :user="$user"/>

      <!-- App Bar -->
      <x-app-bar title="予約一覧"/>

      <!-- Content -->
      <v-main>
        <v-container fluid>

@if ($user->role === 'organizer')
        <template>
            <v-data-table
              v-model="selected"
              :headers="headersForOrganizer"
              :items="{{ $user->participationsForOrganizer }}"
              :single-select="singleSelect"
              item-key="id"
              show-select
              class="elevation-1"
            >
              <template v-slot:top>
                <v-switch
                  v-model="singleSelect"
                  label="Single select"
                  class="pa-3"
                ></v-switch>
              </template>
            </v-data-table>
          </template>
@elseif ($user->role === 'participant')
        <template>
            <v-data-table
              v-model="selected"
              :headers="headersForParticipant"
              :items="{{ $user->participationsForParticipant }}"
              :single-select="singleSelect"
              item-key="id"
              show-select
              class="elevation-1"
            >
              <template v-slot:top>
                <v-switch
                  v-model="singleSelect"
                  label="Single select"
                  class="pa-3"
                ></v-switch>
              </template>
            </v-data-table>
          </template>
@endif

        </v-container>
      </v-main>

      <!-- Footer -->
      <x-footer/>

    </v-app>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    new Vue({
      el: '#app',
      vuetify: new Vuetify(),

      data () {
        return {
          singleSelect: false,
          selected: [],
          headersForOrganizer: [
            {
              text: '予約ID',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: '参加者ID', value: 'participant_id' },
            { text: 'イベントID', value: 'event_id' },
          ],
          headersForParticipant: [
            {
              text: '予約ID',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: 'イベントID', value: 'event_id' },
          ],
        }
      },

      methods: {
        async logout () {
          await axios.post('/logout', {
            _token: "{{ csrf_token() }}"
          })
          location.reload()
        }
      },

    })
  </script>
</body>
</html>
