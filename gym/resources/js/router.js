import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from './components/Home.vue';
import CustomerTable from './components/CustomersTable.vue';
import EquipmentTable from './components/EquipmentsTable.vue';
import PaymentsTable from './components/PaymentsTable.vue';
import SubscriptionsTable from './components/SubscriptionsTable.vue';


const routes = [
    {
        path : '/',
        name: 'Home',
        component : Home
    },
    {
        path : '/customers',
        name: 'CustomersTable',
        component : CustomerTable
    },
    {
        path : '/equipments',
        name: 'EquipmentTable',
        component : EquipmentTable
    },
    {
        path : '/payments',
        component : PaymentsTable
    },
    {
        path : '/subscriptions',
        component : SubscriptionsTable
    }
]

const router = new VueRouter({
    routes
  })

 export default router;
