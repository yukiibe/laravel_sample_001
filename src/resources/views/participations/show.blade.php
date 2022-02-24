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

          <!-- Participation Card -->
          <v-card class="mx-auto">
            <v-img
              class="align-end"
              height="250"
              :src="filePath(eventFile)"
            ></v-img>
            <v-list-item three-line>
              <v-list-item-content>
                <div class="text-overline mb-4">
                  Participation
                </div>
                <v-list-item-title class="text-h5 mb-1">
                  @{{ event.title }}
                </v-list-item-title>
                <v-list-item-subtitle>Place：@{{ event.place }}</v-list-item-subtitle>
                <v-list-item-subtitle>Fee：@{{ event.fee }}</v-list-item-subtitle>
                <v-list-item-subtitle>Date：@{{ toDateFormat(event.date) }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-card-title>Description</v-card-title>
            <v-card-text v-html="htmlText(event.description)"></v-card-text>
            <v-card-actions>
              <v-btn
                color="error"
                style="text-transform: none"
                @click="cancelDialog = !cancelDialog"
              >
                Cancel Participation
              </v-btn>
            </v-card-actions>
          </v-card>

          <v-dialog
            v-model="cancelDialog"
            max-width="550px"
          >
            <v-card>
              <v-card-title class="text-h6">Are you sure you want to cancel this participation?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="green darken-1"
                  style="text-transform: none"
                  text
                  @click="cancelDialog = !cancelDialog"
                >
                  No
                </v-btn>
                <v-btn
                  color="green darken-1"
                  style="text-transform: none"
                  text
                  @click="confirmCencelParticipation"
                >
                  Yes
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

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
          participation: @json($participation),
          event: @json($event),
          eventFile: @json($event_file),
          cancelDialog: false,
        }
      },

      methods: {
        async logout () {
          await axios.post('/logout', {
            _token: "{{ csrf_token() }}"
          })
          location.reload()
        },
        toDateFormat (eventDate) {
          var date = new Date(eventDate)
          return date.toString().substr(0,15)
        },
        htmlText (text) {
          return text.replace(/\r?\n/g, '<br>')
        },
        filePath (eventFile) {
          return eventFile.file ? eventFile.file : '/storage/default-event.png';
        },
        async confirmCencelParticipation () {
          await axios.delete('/participations/' + this.participation.id)
            .then(function(response) {
              location.href = '/participations'
            })
        },
      },

    })
  </script>
</body>
</html>
