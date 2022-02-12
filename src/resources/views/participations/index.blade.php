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
      <x-app-bar title="Participations"/>

      <!-- Content -->
      <v-main>

        <v-container fluid>

          <v-row v-if="userRole == 'participant'">
            <!-- Participation Data Table -->
            <v-col cols="12">
              <template>
                <v-data-table
                  :headers="headersForParticipantParticipations"
                  :items="participationItems"
                  class="elevation-3"
                >
                  <template v-slot:top>
                    <v-subheader>All Participations</v-subheader>
                  </template>
                </v-data-table>
              </template>
            </v-col>
          </v-row>

          <v-row v-if="userRole == 'organizer'">
            <!-- Events Data Table -->
            <v-col cols="4">
              <template>
                <v-data-table
                  :headers="headersForEvents"
                  :items="eventItems"
                  class="elevation-3"
                >
                  <template v-slot:top>
                    <v-subheader>Events</v-subheader>
                  </template>
                  <template v-slot:item.actions="{ item }">
                    <v-switch
                      v-model="selectedEvent"
                      :value="item"
                    ></v-switch>
                  </template>
                </v-data-table>
              </template>
            </v-col>
            <!-- Participation Data Table -->
            <v-col cols="8">
              <template>
                <v-data-table
                  :headers="headersForParticipations"
                  :items="selectedEventParticipationItems"
                  class="elevation-3"
                >
                  <template v-slot:top>
                    <v-subheader>@{{ selectedEventTitle }}</v-subheader>
                  </template>
                </v-data-table>
              </template>
            </v-col>
          </v-row>
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
      vuetify: new Vuetify({
        theme: { dark: true },
      }),

      data () {
        return {
          userRole: "{{ $user->role }}",
          participationItems: @json($participations),
          eventItems: @json($events),
          selectedEvent: null,
          headersForParticipantParticipations: [
            {
              text: 'Participation ID',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: 'Event Title', value: 'event.title' },
          ],
          headersForParticipations: [
            {
              text: 'Participation ID',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: 'Participant ID', value: 'user_id' },
            { text: 'Participant Name', value: 'user.name' },
            { text: 'Participant Email', value: 'user.email' },
            { text: 'Event Title', value: 'event.title' },
          ],
          headersForEvents: [
            {
              text: 'Event ID',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: 'Event Title', value: 'title' },
            { text: 'Select', value: 'actions' },
          ],
        }
      },

      computed: {
        selectedEventTitle () {
          return this.selectedEvent ? 'Event: ' + this.selectedEvent.title : 'All'
        },
        selectedEventParticipationItems () {
          var items = []
          if (this.selectedEvent) {
            for (var i = 0; i < this.participationItems.length; i++) {
              var participationItem = this.participationItems[i]
              if (participationItem.event.id == this.selectedEvent.id) {
                items.push(participationItem)
              }
            }
          } else {
            items = this.participationItems
          }
          return items
        },
      },

      methods: {
        async logout () {
          await axios.post('/logout', {
            _token: "{{ csrf_token() }}"
          })
          location.reload()
        },
      },

    })
  </script>
</body>
</html>
