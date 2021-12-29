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

          <template>
            <v-btn
              class="ma-2"
              style="text-transform: none"
              color="success"
              href="/events/create"
            >
              New Event
            </v-btn>
          </template>

          <template v-if="userRole == 'organizer'">
            <v-data-table
              v-model="selected"
              :headers="headers"
              :items="items"
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
              <template v-slot:item.published="{ item }">
                <td v-if="item.published">
                  Published
                </td>
                <td v-else>
                  Not Published
                </td>
              </template>
              <template v-slot:item.show="{ item }">
                <td>
                  <v-btn
                    color="blue-grey"
                    class="ma-2 white--text"
                    @click="showItem(item)"
                  >
                    Show
                  </v-btn>
                </td>
              </template>
              <template v-slot:item.actions="{ item }">
                <td>
                  <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                  <v-icon small class="mr-2" @click="deleteItem(item)">mdi-delete</v-icon>
                </td>
              </template>
            </v-data-table>
          </template>

          <template v-else-if="userRole == 'participant'">
          </template>

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
          userRole: "{{ $user->role }}",
          items: @json($events),
          singleSelect: false,
          selected: [],
          headers: [
            {
              text: 'ID',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: 'Title', value: 'title' },
            { text: 'Place', value: 'place' },
            { text: 'Fee', value: 'fee' },
            { text: 'Show', value: 'show' },
            { text: 'Published', value: 'published' },
            { text: 'Actions', value: 'actions' },
          ],
        }
      },

      methods: {
        async logout () {
          await axios.post('/logout', {
            _token: "{{ csrf_token() }}"
          })
          .then(function (response) {
            location.reload()
          })
        },
        showItem (item) {
          location.href = '/events/' + item.id
        },
        editItem (item) {
          location.href = '/events/' + item.id + '/edit'
        },
        async deleteItem (item) {
          await axios.delete('/events/' + item.id)
            .then(function (response) {
              location.reload()
            })
        },
      },

    })
  </script>
</body>
</html>
