<template>
  <v-card
    height="100vh"
    width="256px"
    class="mx-auto"
  >
     <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h6 text-center">
            <img v-bind:src= "getImage('muscle.png')" width="50px" />
          </v-list-item-title>
          <v-list-item-subtitle class="text-center text-h5">
            G Y M
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list
        dense
        nav
      >
        <v-list-item
          v-for="item in items"
          :key="item.title"
          :to="item.link"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
  </v-card>
</template>

<script>
  export default {
    data () {
      return {
        items: [
          { title: 'Home', icon: 'mdi-view-dashboard',  link: '/'},
          { title: 'Customers', icon: 'mdi-account-group', link: '/customers' },
          { title: 'Equipments', icon: 'mdi-arm-flex', link: '/equipments' },
          { title:'Payment', icon: 'mdi-credit-card', link: '/payments' },
          { title: 'Subscription', icon: 'mdi-account-cash', link: '/subscriptions'},
        ],
       
      }
    },
    methods:{
      getImage(file){
        return "../storage/storage/images/" + file
      }
    }
  }
</script>
