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
      <x-app-bar title="Events"/>

      <!-- Content -->
      <v-main>
        <v-container fluid>

@if ($user->role === 'organizer')
          <template>
            <v-data-table
              v-model="selected"
              :headers="headersForOrganizer"
              :items="{{ $user->events }}"
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
              :items="{{ $events }}"
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
              text: 'ID',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: 'Title', value: 'title' },
            { text: 'Place', value: 'place' },
            { text: 'Fee', value: 'fee' },
            { text: 'Published', value: 'published' },
          ],
          headersForParticipant: [
            {
              text: 'ID',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: 'Title', value: 'title' },
            { text: 'Place', value: 'place' },
            { text: 'Fee', value: 'fee' },
            { text: 'Published', value: 'published' },
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
