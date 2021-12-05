<div>
  <v-app-bar app>
    <v-toolbar-title>{{ $title }}</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-btn icon>
      <v-icon>mdi-view-dashboard</v-icon>
    </v-btn>

    <v-tooltip bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          icon
          v-bind="attrs"
          v-on="on"
          @click="logout()"
        >
          <v-icon>mdi-logout</v-icon>
        </v-btn>
      </template>
      <span>Logout</span>
    </v-tooltip>

    <v-switch
      v-model="$vuetify.theme.dark"
      label="Vuetify Theme Dark"
    ></v-switch>
  </v-app-bar>
</div>