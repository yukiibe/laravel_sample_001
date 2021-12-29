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
      <x-app-bar title="Edit Event"/>

      <!-- Content -->
      <v-main>
        <v-container fluid>

          <template>
            <v-form method="POST" action="/events/{{ $event->id }}">
              @method('PUT')
              @csrf
              <!-- Event Title -->
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-text-field
                    label="Title"
                    outlined
                    type="text"
                    name="title"
                    v-model="event.title"
                  ></v-text-field>
                </v-col>
              </v-row>
              <!-- Event Description -->
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-textarea
                    label="Description"
                    outlined
                    rows="4"
                    row-height="30"
                    type="textarea"
                    name="description"
                    v-model="event.description"
                  ></v-textarea>
                </v-col>
              </v-row>
              <!-- Event Place -->
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-text-field
                    label="Place"
                    outlined
                    type="text"
                    name="place"
                    v-model="event.place"
                  ></v-text-field>
                </v-col>
              </v-row>
              <!-- Event Fee -->
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-text-field
                    label="Fee"
                    outlined
                    type="text"
                    name="fee"
                    v-model="event.fee"
                  ></v-text-field>
                </v-col>
              </v-row>
              <!-- Event Published -->
              <v-row>
                <v-col
                  cols="12"
                  sm="6"
                >
                  <v-radio-group
                    v-model="event.published"
                    row
                  >
                    <v-radio
                      label="Unpublish"
                      type="radio"
                      name="published"
                      value="0"
                    ></v-radio>
                    <v-radio
                      label="Publish"
                      type="radio"
                      name="published"
                      value="1"
                    ></v-radio>
                  </v-radio-group>
                </v-col>
              </v-row>

              <v-btn
                class="mr-4"
                style="text-transform: none"
                color="success"
                type="submit"
              >
                Update Event
              </v-btn>
            </v-form>
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
          event: {
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
        }
      },

    })
  </script>
</body>
</html>
