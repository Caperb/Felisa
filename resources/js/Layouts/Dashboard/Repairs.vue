<template>
  <div class="content margin-top-2">
  <EditRepair @back="changeValue('activePage', 'main')" @setActivePage="setActivePage" :allUsers="allUsers" :activePage="activePage" :selectedRepair="selectedRepair" v-if="this.activePage == 'edit'"/>
  <AddRepair @back="changeValue('activePage', 'main')" @setActivePage="setActivePage" :allUsers="allUsers" :activePage="activePage" v-if="this.activePage == 'add'"/>
  <div v-if="this.activePage == 'main'">

<md-table v-if="this.paginationData != 'fresh'" v-model="paginationData.data" md-sort="id" md-sort-order="desc" md-card md-fixed-header>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
           <md-button class="md-icon-button md-raised md-primary" @click="changeValue('activePage', 'add')"><md-icon>add</md-icon></md-button>
           <h1 class="md-title">Tickets</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Zoeken..." v-model="searchInput" @keyup="search()" type="text"/>
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="Geen reparatie gevonden"
        :md-description="`Geen reparatie gevonden voor deze zoekopdracht. Probeer een andere zoekterm of maak een nieuwe reparatie aan.`">
      </md-table-empty-state>

      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
        <md-table-cell v-if="item.tussenvoegsel == '' || item.tussenvoegsel == null" md-label="Naam" md-sort-by="voornaam" md-numeric>{{ item.voornaam + ' ' + item.achternaam }}</md-table-cell>
        <md-table-cell v-else md-label="Naam" md-sort-by="voornaam" md-numeric>{{ item.voornaam + ' ' + item.tussenvoegsel + ' ' + item.achternaam }}</md-table-cell>
        <md-table-cell md-label="Status" md-sort-by="state" md-numeric>{{ item.state }}</md-table-cell>
        <md-table-cell md-label="Aangemaakt op" md-sort-by="created_at" md-numeric>{{ item.created_at }}</md-table-cell>
        <md-table-cell md-label="Verloopt op" md-sort-by="due" md-numeric>{{ item.due }}</md-table-cell>
        <md-table-cell md-label="Acties" class="display-flex">
          <div @click="changeValue('activePage', 'edit', item)" class="display-flex"><span class="material-icons table-icon">edit</span></div>
          <div @click="deleteTicket(item.id, index)" class="display-flex"><span class="material-icons table-icon">delete</span></div>
        </md-table-cell>

      </md-table-row>
    </md-table>

</div>
</div>
</template>

<script>
  import EditRepair from '@/Layouts/Dashboard/EditRepair'
  import AddRepair from '@/Layouts/Dashboard/AddRepair'

    export default {
        components: {
          EditRepair,
          AddRepair,
        },

        props:['allUsers', 'selectedSubPage'],

        data(){
          return{
            activePage: 'main',
            paginationData: 'fresh',
            searchInput: '',
            selectedPaginationPage: 1,
            orderBy: 'ticket.id',
            orderByType: 'desc',
            selectedRepair: {},
          }
        },

        mounted(){
          axios.post('all-repairs', {'orderBy': this.orderBy, 'orderByType': this.orderByType, 'page': this.selectedPaginationPage})
          .then(response => this.paginationData = response.data);

          if(this.selectedSubPage == 'due'){
            this.searchInput = 'due';
            this.search();
          };
        },

        watch:{
          activePage(){
            if(this.activePage == 'main'){
              this.refreshData();
            }
          },
        },

        methods:{

          setActivePage(page, subPage){
            this.$emit('setActivePage', page, subPage);
          },


          changeValue(name, value, repair){
            this[name] = value;
            if(value == 'edit'){
              this.selectedRepair = repair;
              if(this.selectedRepair.eerderGerepareerd == 0){
                this.selectedRepair.eerderGerepareerd = false;
              }else{
                this.selectedRepair.eerderGerepareerd = true;
              }
            }
          },

          search(){
              this.selectedPaginationPage = 1;
              this.refreshData();
          },

          setOrderBy(name, type){
            if(this.orderBy != name || this.orderByType != type){
              this.selectedPaginationPage = 1;
              this.orderBy = name;
              this.orderByType = type;
              this.refreshData();
            }
          },

          pageUp(){
            if(this.selectedPaginationPage < this.paginationData.last_page){
              this.selectedPaginationPage = this.selectedPaginationPage + 1;
              this.refreshData();
            }
          },

          pageDown(){
            if(this.selectedPaginationPage > 1)
            this.selectedPaginationPage = this.selectedPaginationPage -1;
            this.refreshData();
          },

          deleteRepair(id, index){
            let c = confirm('Are you sure you want to delete ID: ' + id);

            if(c == true){
              axios.post('delete-repair', {'id': id})
              this.paginationData.data.splice(index, 1);
            }
          },

          refreshData(){
            axios.post('repair-search', {'orderBy': this.orderBy, 'orderByType': this.orderByType, 'input': this.searchInput, 'page': this.selectedPaginationPage})
            .then(response => this.paginationData = response.data);
          },
        },
    }
</script>
