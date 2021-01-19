<template>
  <div class="dashboard-menu-wrapper fu">
    <div class="full-control md-elevation-8">
      <div class="list">
      <md-list :md-expand-single="expandSingle">

        <div class="sidebar_background"> </div>

        <md-list-item>
      <img src="/images/logo-25.svg">
        </md-list-item>

        <md-list-item @click="setActivePage('home')">
          <md-icon>home</md-icon>
          <span class="md-list-item-text">Home</span>
        </md-list-item>

        <md-list-item @click="setActivePage('reminders')">
        <md-icon>notification_important</md-icon>
          <span class="md-list-item-text">Herinneringen</span>
        </md-list-item>

        <md-list-item md-expand>
          <md-icon>source</md-icon>
          <span class="md-list-item-text">Tickets</span>
          <md-list slot="md-expand">
            <md-list-item class="md-inset" @click="setActivePage('tickets')"><md-icon>list</md-icon>Overzicht</md-list-item>
            <md-list-item class="md-inset" @click="setActivePage('repairs')"><md-icon>build</md-icon>Tickets</md-list-item>
            <md-list-item class="md-inset" @click="setActivePage('orders')"><md-icon>shopping_cart</md-icon>Bestellingen</md-list-item>
            <md-list-item class="md-inset" @click="setActivePage('tickets', 'addTicket')"><md-icon>post_add</md-icon>Aanmaken</md-list-item>
          </md-list>
        </md-list-item>

        <md-list-item md-expand>
          <md-icon>supervisor_account</md-icon>
          <span class="md-list-item-text">Klanten</span>
          <md-list slot="md-expand">
            <md-list-item class="md-inset" @click="setActivePage('customers', 'none')"><md-icon>list</md-icon>Overzicht</md-list-item>
            <md-list-item class="md-inset" @click="setActivePage('customers','addCustomer')"><md-icon>person_add</md-icon>Aanmaken</md-list-item>
          </md-list>
        </md-list-item>

        <md-list-item md-expand>
          <md-icon>people_alt</md-icon>
          <span class="md-list-item-text">Medewerkers</span>
          <md-list slot="md-expand">
            <md-list-item class="md-inset" @click="setActivePage('users')"><md-icon>list</md-icon>Overzicht</md-list-item>
            <md-list-item class="md-inset" @click="setActivePage('users', 'addUser')"><md-icon>person_add</md-icon>Aanmaken</md-list-item>
          </md-list>
        </md-list-item>

        <md-list-item @click="setPage('home')">
        <md-icon>home</md-icon>
          <span class="md-list-item-text">Onboarding</span>
        </md-list-item>

        <md-list-item @click="logout" class="md-listitem-bot">
        <md-icon>backspace</md-icon>
          <span class="md-list-item-text">Logout</span>
        </md-list-item>

      </md-list>
    </div>
    </div>

    <div class="dashboard-content">
      <Home @addReminder="setActivePage('reminders')" @addTicket="setActivePage('tickets')" @setActivePage="setActivePage" v-if="activePage == 'home'"/>
      <Reminders v-if="activePage == 'reminders'"/>
      <Tickets @setActivePage="setActivePage" @selectedSubPageReset="selectedSubPageReset" :toggleAddTicket="toggleAddTicket" :selectedSubPage="selectedSubPage" :allUsers="allUsers" v-if="activePage == 'tickets'"/>
      <Repairs :allUsers="allUsers" :selectedSubPage="selectedSubPage" @setActivePage="setActivePage" v-if="activePage == 'repairs'"/>
      <Orders :allUsers="allUsers" :selectedSubPage="selectedSubPage" @setActivePage="setActivePage" v-if="activePage == 'orders'"/>
      <Customers :selectedSubPage="selectedSubPage" v-if="activePage == 'customers'"/>
      <Users :selectedSubPage="selectedSubPage" v-if="activePage == 'users'"/>
    </div>
    </div>
</template>

<script>
import Home from '@/Layouts/Dashboard/Home'
import Reminders from '@/Layouts/Dashboard/Reminders'
import Tickets from '@/Layouts/Dashboard/Tickets'
import Repairs from '@/Layouts/Dashboard/Repairs'
import Orders from '@/Layouts/Dashboard/Orders'
import Customers from '@/Layouts/Dashboard/Customers'
import Users from '@/Layouts/Dashboard/Users'

    export default {
        components: {
          Home,
          Reminders,
          Tickets,
          Repairs,
          Orders,
          Customers,
          Users,
          name: 'ListExpansion',
        },

        props:['allUsers'],

        data(){
          return{
            activePage: 'home',
            selectedSubPage: '',
            toggleAddTicket: false,
            expandSingle: true,
          }
        },

        methods:{

          selectedSubPageReset(){
            this.toggleAddTicket = false;
          },

          logout(){
            axios.post('logout');
            window.location.replace('/login');
          },

          setActivePage(page, subPage){
           if(subPage != null){
           if(subPage == 'addTicket'){
             this.toggleAddTicket = true;
           }else{
             this.selectedSubPage = subPage;
           }
         }

             this.activePage = page;
         },

          setPage(value){
            this.$emit('setPage', value);
          },
        },
    }
</script>
