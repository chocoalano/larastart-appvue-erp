<template>
  <div>
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list>
        <v-list-item link>
          <v-list-item-content>
            <v-list-item-title class="text-h6" v-text="authenticated.name"></v-list-item-title>
            <v-list-item-subtitle v-text="authenticated.email"></v-list-item-subtitle>
          </v-list-item-content>

          <v-list-item-action>
            <v-icon>mdi-menu-down</v-icon>
          </v-list-item-action>
        </v-list-item>
      </v-list>
      <v-divider></v-divider>
      <v-list nav dense>
        <v-list-item-group v-model="selectedMain" color="primary">
          <div v-for="(item, i) in itemsmenu" :key="i">
            <v-list-item v-if="item.child === false" :to="item.to">
              <v-list-item-icon>
                <v-icon v-text="item.icon"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="item.text"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-group v-else :prepend-icon="item.icon" no-action>
              <template v-slot:activator>
                <v-list-item-title v-text="item.text"></v-list-item-title>
              </template>
              <v-list-item-group v-model="selectedSub" color="primary">
                <v-list-item v-for="(child, s) in item.childitems" :key="s" :to="child.to">
                  <v-list-item-content>
                    <v-list-item-title v-text="child.text"></v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-icon>
                    <v-icon v-text="child.icon"></v-icon>
                  </v-list-item-icon>
                </v-list-item>
              </v-list-item-group>
            </v-list-group>
          </div>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left clipped-right color="primary" dark>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>{{ $route.meta.title }}</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>

      <v-menu left bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item v-for="n in 5" :key="n" @click="() => {}">
            <v-list-item-title>Option {{ n }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

      <v-app-bar-nav-icon
        @click="drawerright = !drawerright"
      ></v-app-bar-nav-icon>

      <template v-slot:extension>
        <v-tabs v-model="tabappbar" centered show-arrows slider-color="white">
          <v-tab v-for="i in itemtabs" :key="i" :href="`#${i}`">
            {{ i }}
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-navigation-drawer v-model="drawerright" app clipped right>
      <v-list two-line subheader>
        <v-subheader>Pengumuman {{ rooturl }}</v-subheader>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>2022-10-12</v-list-item-title>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae
            totam, sunt pariatur vero eius quam laudantium labore nihil, aliquid
            voluptatibus qui quasi excepturi adipisci maxime deleniti error
            nobis nemo explicabo?
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-divider></v-divider>
      <v-list two-line subheader>
        <v-subheader>Jadwal Tugas Sekarang</v-subheader>

        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Profile photo</v-list-item-title>
            <v-list-item-subtitle
              >Change your Google+ profile photo</v-list-item-subtitle
            >
          </v-list-item-content>
        </v-list-item>

        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>Show your status</v-list-item-title>
            <v-list-item-subtitle
              >Your status is visible to everyone</v-list-item-subtitle
            >
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  data: () => ({
    drawer: null,
    drawerright: null,
    selectedMain: null,
    selectedSub: null,
    itemtabs: [],
  }),
  computed: {
    ...mapState(["itemsmenu", "rooturl", "tabappbar"]),
    rooturl: {
      get: function () {
        return this.$store.state.rooturl;
      },
      set: function (value) {
        this.$store.commit("SET_ROOTURL", value, { root: true });
      },
    },
    tabappbar: {
      get: function () {
        return this.$store.state.tabappbar;
      },
      set: function (value) {
        this.$store.commit("SET_TABAPPBAR", value, { root: true });
      },
    },
    ...mapState("auth", {
      authenticated: (state) => state.authenticated,
    }),
    ...mapState("config", {
      configtabs: (state) => state.itemtabs,
    }),
    ...mapState("akuntansi", {
      akuntansitabs: (state) => state.itemtabs,
    }),
  },
  watch: {
    rooturl(val) {
      if (val === "config") {
        this.itemtabs = this.configtabs;
      }else if (val === "akuntansi") {
        this.itemtabs = this.akuntansitabs;
      }else {
        this.itemtabs = [];
      }
    },
  },
};
</script>