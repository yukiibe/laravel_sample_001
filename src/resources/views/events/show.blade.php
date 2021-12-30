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
      <x-app-bar title="Show Event"/>

      <!-- Content -->
      <v-main>
        <v-container fluid>

          <template>
            <h2>@{{ item.title }}</h2>

            <v-divider></v-divider>

            <div>
              <h3>Detail</h3>
              <p>@{{ item.description }}</p>
            </div>

            <div>
              <h3>Place</h3>
              <p>@{{ item.place }}</p>
            </div>

            <div>
              <h3>Fee</h3>
              <p>@{{ item.fee }}</p>
            </div>

            <div>
              <h3>Published</h3>
              <p>@{{ convertPublishedToString(item.published) }}</p>
            </div>

            <v-form method="POST" action="/participations" v-if="userRole == 'participant'">
              @csrf
              <v-btn
                class="mr-4"
                style="text-transform: none"
                color="success"
                type="submit"
              >
                Participate This Event
              </v-btn>
              <input type="hidden" name="event_id" value="{{ $event->id }}">
            </v-form>

            <v-btn
              v-if="userRole == 'organizer'"
              class="mr-4 white--text"
              style="text-transform: none"
              color="blue-grey"
              @click="editItem(item)"
            >
              Edit This Event
            </btn>

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
          item: {
            id: "{{ $event->id }}",
            title: "{{ $event->title }}",
            description: "{{ $event->description }}",
            place: "{{ $event->place }}",
            fee: "{{ $event->fee }}",
            published: "{{ $event->published }}",
          },
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
        editItem (item) {
          location.href = '/events/' + item.id + '/edit'
        },
        convertPublishedToString (published) {
          if (published == '1') {
            return "Published";
          } else {
            return "Not Published";
          }
        },
      },

    })
  </script>
</body>
</html>