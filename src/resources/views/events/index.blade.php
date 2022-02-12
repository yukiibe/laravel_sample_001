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

          <!-- Template -->
          <template>
            <v-btn
              class="ma-2"
              style="text-transform: none"
              color="success"
              @click="dialog = true"
              v-if="userRole == 'organizer'"
            >
              New Event
            </v-btn>

            <!-- Event Cards -->
            <v-container>
              <v-row>
                <v-col
                  v-for="item in items"
                  :key="item.id"
                  cols="4"
                >
                  <v-card
                    class="mx-auto"
                    max_width="344"
                    outlined
                    elevation="4"
                  >
                    <v-img
                      class="align-end"
                      height="250"
                      :src="filePath(item)"
                    ></v-img>
                    <v-card-title>@{{ item.title }}</v-card-title>
                    <v-card-subtitle>
                      Place：@{{ item.place }}<br>
                      Fee：@{{ item.fee }}
                    </v-card-subtitle>
                    <v-card-text v-if="userRole == 'organizer'">
                      <v-file-input
                        accept="image/png, image/jpeg, image/bmp"
                        prepend-icon="mdi-camera"
                        label="Select Image"
                        @change="selectFile"
                      ></v-file-input>
                      <v-btn
                        color="orange lighten-1"
                        text
                        @click="uploadFile(item)"
                      >
                        <v-icon left>
                          mdi-upload
                        </v-icon>
                        Upload
                      </v-btn>
                      <v-btn
                        color="blue-grey lighten-1"
                        text
                        @click="deleteFileItem(item)"
                      >
                        <v-icon left>
                          mdi-upload-off
                        </v-icon>
                        Delete
                      </v-btn>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-chip
                      class="ma-2"
                      color="indigo"
                      text-color="white"
                      v-if="userRole == 'organizer' && item.published"
                    >
                      <v-avatar left>
                        <v-icon>mdi-checkbox-marked-circle</v-icon>
                      </v-avatar>
                      Published
                    </v-chip>
                    <v-card-text v-if="userRole == 'organizer'">@{{ item.description }}</v-card-text>
                    <v-card-actions v-if="userRole == 'organizer'">
                      <v-btn
                        color="teal lighten-3"
                        text
                        @click="editItem(item)"
                      >
                        <v-icon left>
                          mdi-pencil
                        </v-icon>
                        Edit
                      </v-btn>
                      <v-btn
                        color="red lighten-1"
                        text
                        @click="deleteItem(item)"
                      >
                        <v-icon left>
                          mdi-delete
                        </v-icon>
                        Delete
                      </v-btn>
                    </v-card-actions>
                    <v-card-actions v-else-if="userRole == 'participant'">
                      <v-btn
                        style="text-transform: none"
                        color="teal lighten-3"
                        text
                        @click="show = !show"
                      >
                        Description More
                      </v-btn>
                      <v-btn
                        style="text-transform: none"
                        color="pink lighten-1"
                        @click="participate(item)"
                        v-if="!isParticipatedByUser(item)"
                      >
                        Participate
                      </v-btn>
                      <v-chip
                        class="ma-2"
                        color="indigo"
                        text-color="white"
                        v-if="isParticipatedByUser(item)"
                      >
                        <v-avatar left>
                          <v-icon>mdi-checkbox-marked-circle</v-icon>
                        </v-avatar>
                        Participated
                      </v-chip>
                      <v-spacer></v-spacer>
                    </v-card-actions>
                    <v-expand-transition v-if="userRole == 'participant'">
                      <div v-show="show">
                        <v-divider></v-divider>
                        <v-card-text>
                          @{{ item.description }}
                        </v-card-text>
                      </div>
                    </v-expand-transition>
                  </v-card>
                </v-col>
              <v-row>
            </v-container>

            <!-- Form Dialog -->
            <v-dialog
              v-model="dialog"
              max-width="500px"
            >
              <v-card>
                <v-card-title><span class="text-h5">@{{ formTitle }}</span></v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col
                        cols="12"
                        sm="6"
                      >
                        <v-text-field
                          v-model="editedItem.title"
                          name="title"
                          label="Title"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                      >
                        <v-textarea
                          v-model="editedItem.description"
                          name="description"
                          label="Description"
                          rows="4"
                          row-height="30"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="6"
                      >
                        <v-text-field
                          v-model="editedItem.place"
                          name="place"
                          label="Place"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="6"
                      >
                        <v-text-field
                          v-model="editedItem.fee"
                          name="fee"
                          label="Fee"
                        ></v-text-field>
                      </v-col>
                      <v-col
                        cols="12"
                      >
                        <v-radio-group
                          v-model="editedItem.published"
                          row
                        >
                          <v-radio
                            label="Unpublish"
                            name="published"
                            :value="0"
                          ></v-radio>
                          <v-radio
                            label="Publish"
                            name="published"
                            :value="1"
                          ></v-radio>
                        </v-radio-group>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="blue darken-1"
                    text
                    @click="close"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    color="blue darken-1"
                    text
                    @click="save"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

            <!-- Participate Dialog -->
            <v-dialog
              v-model="dialogParticipate"
              max-width="300px"
            >
              <v-card>
                <v-card-title class="text-h5">Participate This Event?</v-card-title>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="green darken-1"
                    style="text-transform: none"
                    text
                    @click="close"
                  >
                    No
                  </v-btn>
                  <v-btn
                    color="green darken-1"
                    style="text-transform: none"
                    text
                    @click="confirmParticipate"
                  >
                    Yes
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

            <!-- Delete Dialog -->
            <v-dialog
              v-model="dialogDelete"
              max-width="500px"
            >
              <v-card>
                <v-card-title class="text-h6">Are you sure you want to delete this event?</v-card-title>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="green darken-1"
                    style="text-transform: none"
                    text
                    @click="close"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    color="green darken-1"
                    style="text-transform: none"
                    text
                    @click="confirmDelete"
                  >
                    OK
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

            <!-- File Delete Dialog -->
            <v-dialog
              v-model="dialogFileDelete"
              max-width="500px"
            >
              <v-card>
                <v-card-title class="text-h6">Are you sure you want to delete this file?</v-card-title>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="green darken-1"
                    style="text-transform: none"
                    text
                    @click="close"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    color="green darken-1"
                    style="text-transform: none"
                    text
                    @click="confirmFileDelete"
                  >
                    OK
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
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
      vuetify: new Vuetify({
        theme: { dark: true },
      }),

      data () {
        return {
          selectedFile: null,
          dialog: false,
          dialogParticipate: false,
          dialogDelete: false,
          dialogFileDelete: false,
          show: false,
          userRole: "{{ $user->role }}",
          loggedInUserId: "{{ $user->id }}",
          items: @json($events),
          editFlg: false,
          editedItem: {
            title: '',
            description: '',
            place: '',
            fee: 0,
            published: 0
          },
          defaultItem: {
            title: '',
            description: '',
            place: '',
            fee: 0,
            published: 0
          },
          editedFileItem: {
            event_id: null,
            file: '',
          },
          defaultFileItem: {
            event_id: null,
            file: '',
          },
        }
      },

      computed: {
        formTitle () {
          return this.editFlg ? 'Edit Event' : 'New Event'
        },
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
          this.editFlg = true
          this.editedItem = item
          this.dialog = true
        },
        async save () {
          if (this.editFlg) {
            await axios.put('/events/' + this.editedItem.id, {
              title: this.editedItem.title,
              description: this.editedItem.description,
              place: this.editedItem.place,
              fee: this.editedItem.fee,
              published: this.editedItem.published
            })
            .then(function (response) {
              this.close()
              location.reload()
            })
          } else {
            await axios.post('/events/', {
              title: this.editedItem.title,
              description: this.editedItem.description,
              place: this.editedItem.place,
              fee: this.editedItem.fee,
              published: this.editedItem.published
            })
            .then(function (response) {
              location.reload()
            })
          }
        },
        deleteItem (item) {
          this.editedItem = item
          this.dialogDelete = true
        },
        async confirmDelete () {
          await axios.delete('/events/' + this.editedItem.id)
            .then(function (response) {
              location.reload()
            })
        },
        participate (item) {
          this.editedItem = item
          this.dialogParticipate = true
        },
        async confirmParticipate () {
          await axios.post('/participations/', {
            event_id: this.editedItem.id,
          })
          .then(function (response) {
            location.reload()
          })
        },
        close () {
          this.dialog = false
          this.dialogParticipate = false
          this.dialogParticipated = false
          this.dialogDelete = false
          this.dialogFileDelete = false
          this.editFlg = false
          this.editedItem = this.defaultItem
          this.editedFileItem = this.defaultFileItem
        },
        filePath (item) {
          return item.event_file.file ? item.event_file.file : '/storage/default-event.png';
        },
        selectFile (e) {
          this.selectedFile = e
        },
        async uploadFile (item) {
          if (!this.selectedFile) {
            return;
          }
          var config = {
            headers: {
              'content-type': 'multipart/form-data'
            }
          };
          var formData = new FormData()
          formData.append('file', this.selectedFile)
          await axios.post('/event_files/' + item.event_file.id + '/upload', formData, config)
            .then(function (response) {
              location.reload()
            })
        },
        deleteFileItem (item) {
          if (!item.event_file.file) {
            return;
          }
          this.editedFileItem = item
          this.dialogFileDelete = true
        },
        async confirmFileDelete () {
          await axios.post('/event_files/' + this.editedFileItem.event_file.id + '/delete')
            .then(function (response) {
              location.reload()
            })
        },
        isParticipatedByUser (item) {
          for (var i = 0; i < item.participations.length; i++) {
            var participation = item.participations[i]
            if (participation.user_id == this.loggedInUserId) {
              return true
            }
          }
          return false
        },
      },
    })
  </script>
</body>
</html>
