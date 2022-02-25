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
              @click="dialogForm = true"
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
                  xs="12"
                  md="4"
                >
                  <v-card
                    class="mx-auto"
                    max_width="344"
                    outlined
                    elevation="4"
                  >

                    <v-img
                      class="mx-auto align-end"
                      height="250"
                      width="520"
                      :src="filePath(item)"
                    >
                      <v-chip
                        class="ma-2"
                        color="indigo"
                        text-color="white"
                        v-if="userRole == 'organizer'"
                      >
                        <v-avatar>
                          <v-icon>@{{ publishing(item) }}</v-icon>
                        </v-avatar>
                      </v-chip>
                      <v-chip
                        class="ma-2"
                        color="indigo"
                        text-color="white"
                        v-if="userRole == 'participant' && isParticipatedByUser(item)"
                      >
                        <v-avatar left>
                          <v-icon>mdi-checkbox-marked-circle</v-icon>
                        </v-avatar>
                        Participated
                      </v-chip>
                    </v-img>

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

                    <v-card-title>@{{ item.title }}</v-card-title>
                    <v-card-text>
                      Place：@{{ item.place }}<br>
                      Fee：@{{ item.fee }}<br>
                      Date：@{{ item.date }}
                    </v-card-text>

                    <v-card-title v-if="userRole == 'organizer'">Description</v-card-title>
                    <v-card-text
                      v-if="userRole == 'organizer'"
                      v-html="htmlText(item.description)">
                    </v-card-text>
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
                      <v-chip
                        class="ma-2"
                        color="pink lighten-1"
                        text-color="white"
                        v-if="!isParticipatedByUser(item)"
                        @click="participate(item)"
                      >
                        Participate
                      </v-chip>
                      <v-spacer></v-spacer>
                    </v-card-actions>

                    <v-expand-transition v-if="userRole == 'participant'">
                      <div v-show="show">
                        <v-divider></v-divider>
                        <v-card-text v-html="htmlText(item.description)"></v-card-text>
                      </div>
                    </v-expand-transition>
                  </v-card>
                </v-col>
              <v-row>
            </v-container>

            <!-- Form Dialog -->
            <v-dialog
              v-model="dialogForm"
              max-width="650px"
            >
              <v-card>
                <v-card-title><span class="text-h5">@{{ formTitle }}</span></v-card-title>
                <v-card-text>
                  <v-container>
                    <v-form
                      ref="form"
                      v-model="valid"
                    >
                      <v-row>
                        <v-col
                          cols="12"
                        >
                          <v-text-field
                            v-model="editedItem.title"
                            name="title"
                            label="Title"
                            :counter="60"
                            :rules="titleRules"
                            required
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
                            counter
                            :rules="descriptionRules"
                            required
                          ></v-text-field>
                        </v-col>
                        <v-col
                          cols="6"
                        >
                          <v-text-field
                            v-model="editedItem.place"
                            name="place"
                            label="Place"
                            :counter="40"
                            :rules="placeRules"
                            required
                          ></v-text-field>
                        </v-col>
                        <v-col
                          cols="6"
                        >
                          <v-text-field
                            v-model="editedItem.fee"
                            name="fee"
                            label="Fee"
                            :counter="10"
                            :rules="feeRules"
                            required
                          ></v-text-field>
                        </v-col>
                        <v-col
                          cols="12"
                        >
                          <v-menu
                            ref="menu"
                            v-model="menu"
                            :close-on-content-click="false"
                            :return-value.sync="editedItem.date"
                            transition="scale-transition"
                            offset-y
                            min-width="auto"
                          >
                            <template v-slot:activator="{ on, attrs }">
                              <v-text-field
                                v-model="editedItem.date"
                                label="Event Date"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                              ></v-text-field>
                            </template>
                            <v-date-picker
                              v-model="editedItem.date"
                              no-title
                              scrollable
                            >
                              <v-spacer></v-spacer>
                              <v-btn
                                text
                                color="primary"
                                @click="menu = false"
                              >
                                Cancel
                              </v-btn>
                              <v-btn
                                text
                                color="primary"
                                @click="$refs.menu.save(editedItem.date)"
                              >
                                OK
                              </v-btn>
                            </v-date-picker>
                          </v-menu>
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
                    </v-form>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="blue darken-1"
                    text
                    @click="dialogForm = false"
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
                    @click="dialogParticipate = false"
                  >
                    No
                  </v-btn>
                  <v-btn
                    color="green darken-1"
                    style="text-transform: none"
                    text
                    :loading="loading"
                    :disabled="loading"
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
                    @click="dialogDelete = false"
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
                    @click="dialogFileDelete = false"
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
          dialogForm: false,
          dialogParticipate: false,
          dialogDelete: false,
          dialogFileDelete: false,
          show: false,
          menu: false,
          loading: false,
          userRole: "{{ $user->role }}",
          loggedInUserId: "{{ $user->id }}",
          items: @json($events),
          editFlg: false,
          editedItem: {
            title: '',
            description: '',
            place: '',
            date: null,
            fee: 0,
            published: 0
          },
          defaultItem: {
            title: '',
            description: '',
            place: '',
            date: null,
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
          valid: true,
          titleRules: [
            v => !!v || 'Title is required',
            v => v.length <= 60 || 'Title must be less than 40 characters',
          ],
          descriptionRules: [
            v => !!v || 'Description is required',
          ],
          placeRules: [
            v => !!v || 'Place is required',
            v => v.length <= 40 || 'Title must be less than 20 characters',
          ],
          feeRules: [
            v => !!v || 'Place is required',
            v => v.length <= 10 || 'Title must be less than 10 characters',
          ],
        }
      },

      watch: {
        dialogForm: function (val) {
          if (!val) {
            this.editFlg = false
            this.editedItem = this.defaultItem
            this.editedItem.date = null
            this.$refs.form.resetValidation()
          }
        },
        dialogParticipate: function (val) {
          if (!val) {
            this.editedItem = this.defaultItem
            this.editedItem.date = null
          }
        },
        dialogDelete: function (val) {
          if (!val) {
            this.editedItem = this.defaultItem
            this.editedItem.date = null
            this.$refs.form.resetValidation()
          }
        },
        dialogFileDelete: function (val) {
          if (!val) {
            this.editedFileItem = this.defaultFileItem
          }
        },
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
        publishing (item) {
          return item.published == 1 ? 'mdi-lock-open-variant' : 'mdi-lock';
        },
        htmlText (text) {
          return text.replace(/\r?\n/g, '<br>')
        },
        editItem (item) {
          this.editFlg = true
          this.editedItem = item
          this.dialogForm = true
        },
        async save () {
          if (this.$refs.form.validate()) {
            if (this.editFlg) {
              await axios.put('/events/' + this.editedItem.id, {
                title: this.editedItem.title,
                description: this.editedItem.description,
                place: this.editedItem.place,
                fee: this.editedItem.fee,
                date: this.editedItem.date,
                published: this.editedItem.published
              })
              .then(function (response) {
                location.href = '/events'
              })
            } else {
              await axios.post('/events/', {
                title: this.editedItem.title,
                description: this.editedItem.description,
                place: this.editedItem.place,
                fee: this.editedItem.fee,
                date: this.editedItem.date,
                published: this.editedItem.published
              })
              .then(function (response) {
                location.href = '/events'
              })
            }
          }
        },
        deleteItem (item) {
          this.editedItem = item
          this.dialogDelete = true
        },
        async confirmDelete () {
          await axios.delete('/events/' + this.editedItem.id)
            .then(function (response) {
              location.href = '/events'
            })
        },
        participate (item) {
          this.editedItem = item
          this.dialogParticipate = true
        },
        async confirmParticipate () {
          this.loading = true
          await axios.post('/participations/', {
            event_id: this.editedItem.id,
            user_id: this.loggedInUserId,
          })
          .then(function (response) {
            this.loading = false
            location.href = '/events'
          })
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
              location.href = '/events'
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
              location.href = '/events'
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
