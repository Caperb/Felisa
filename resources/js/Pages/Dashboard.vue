<template>
  <div>
<!-- <Home v-if="activePage =='home'" @setPage="setPage"/>
<KlantAanmaken v-if="activePage =='klantAanmaken'" @setPage="setPage"/>
<KlantAangemaakt v-if="activePage =='klantAangemaakt'" @setPage="setPage"/>
<TicketAanmaken v-if="activePage =='ticketAanmaken'" @setPage="setPage"/>
<ReparatieAanmaken :allUsers="allUsers" @reparatieAangemaakt="setPageReparatieAangemaakt" v-if="activePage =='reparatieAanmaken'" @setPage="setPage" @klantAanmaken="setPage('klantAanmaken')"/>
<AanvraagAanmaken :allUsers="allUsers" @aanvraagAangemaakt="setPageAanvraagAangemaakt" v-if="activePage =='aanvraagAanmaken'" @setPage="setPage" @klantAanmaken="setPage('klantAanmaken')"/>
<ReparatieAangemaakt v-if="activePage =='reparatieAangemaakt'" :info="this.orderInfo" @setPage="setPage"/>
<AanvraagAangemaakt v-if="activePage =='aanvraagAangemaakt'" :info="this.orderInfo" @setPage="setPage"/> -->
<Dashboard :allUsers="allUsers" v-if="activePage =='dashboard'" @setPage="setPage"/>
</div>
</template>

<script>
  // import Home from '@/Layouts/Home'
  // import KlantAanmaken from '@/Layouts/KlantAanmaken'
  // import KlantAangemaakt from '@/Layouts/KlantAangemaakt'
  // import TicketAanmaken from '@/Layouts/TicketAanmaken'
  // import ReparatieAanmaken from '@/Layouts/ReparatieAanmaken'
  // import AanvraagAanmaken from '@/Layouts/AanvraagAanmaken'
  // import ReparatieAangemaakt from '@/Layouts/ReparatieAangemaakt'
  // import AanvraagAangemaakt from '@/Layouts/AanvraagAangemaakt'
  import Dashboard from '@/Layouts/Dashboard'

    export default {
        components: {
          // Home,
          // KlantAanmaken,
          // KlantAangemaakt,
          // TicketAanmaken,
          // ReparatieAanmaken,
          // AanvraagAanmaken,
          // ReparatieAangemaakt,
          // AanvraagAangemaakt,
          Dashboard,
        },

        data(){
          return{
            activePage: 'dashboard',
            allUsers: {},
            orderInfo: {},
          }
        },

        mounted(){
          axios.post('user-list')
          .then(response => this.allUsers = response.data);
        },

        methods:{
          setPage(value){
            this.activePage = value;
          },

          setPageReparatieAangemaakt(info){
            this.orderInfo = info;
            this.activePage = 'reparatieAangemaakt';
          },

          setPageAanvraagAangemaakt(info){
            this.orderInfo = info;
            this.activePage = 'aanvraagAangemaakt';
          },
        },
    }
</script>
