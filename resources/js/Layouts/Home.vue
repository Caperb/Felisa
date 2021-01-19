<template>
  <div class="wrapper">

      <md-speed-dial md-direction="bottom" class="home-dashboard-button">
      <md-speed-dial-target @click="setPage('dashboard')" class="md-accent">
        <md-icon>admin_panel_settings</md-icon>
        <md-tooltip md-direction="right">Dashboard</md-tooltip>
      </md-speed-dial-target>

      <md-speed-dial-content>
        <md-button class="md-icon-button"  @click="logout">
          <md-icon>backspace</md-icon>
          <md-tooltip md-direction="right">Uitloggen</md-tooltip>
        </md-button>
      </md-speed-dial-content>
    </md-speed-dial>

    <img src="/images/logo-25.svg" class="home-logo" />

    <p class="md-display-2 md-medium-hide">Welkom bij de Shop Assistant!</p>

    <div class="homespacer"></div>
    <div class="md-layout md-gutter md-alignment-center-center">
      <div class="md-layout-item">
        <md-button class="big-md-button" @click="setPage('klantAanmaken')">Klant aanmaken</md-button>
      </div>

      <div class="md-layout-item md-medium-hide"></div>

      <div class="md-layout-item">
        <md-button class="big-md-button" @click="setPage('ticketAanmaken')">Ticket aanmaken</md-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LayoutHorizontalGutter",

  components: {},

  data() {
    return {};
  },

  methods: {
    setPage(value) {
      this.$emit("setPage", value);
    },

          logout(){
            axios.post('logout');
            window.location.replace('/login');
          },
  },
};
</script>
