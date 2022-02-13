<div>
  <v-app-bar app dark>
    <v-toolbar-title>{{ $title }}</v-toolbar-title>
    <v-spacer></v-spacer>

    <v-tooltip bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          icon
          v-bind="attrs"
          v-on="on"
          href="/events"
        >
          <v-icon>mdi-calendar</v-icon>
        </v-btn>
      </template>
      <span>Events</span>
    </v-tooltip>

    <v-tooltip bottom>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          icon
          v-bind="attrs"
          v-on="on"
          href="/participations"
        >
          <v-icon>mdi-view-list</v-icon>
        </v-btn>
      </template>
      <span>Participations</span>
    </v-tooltip>

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

  </v-app-bar>
</div>