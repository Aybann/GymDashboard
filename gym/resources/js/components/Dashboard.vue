<template>

  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
    <dash-sidebar></dash-sidebar>

    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>GYMDASHBAORD</v-toolbar-title>
    </v-app-bar>

    <v-main> 
        <router-view />
    </v-main>
  </v-app>

</template>

<script>
    import DashSidebar from './DashSidebar.vue'

    export default {
        name: 'Dashboard',
        data: () => ({ drawer: null }),
        components:{
            DashSidebar: DashSidebar,
        },
    }
</script>
