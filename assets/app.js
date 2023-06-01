import Vue from 'vue';
import VueRouter from 'vue-router';
import TeamsPlayers from './components/TeamsPlayers.vue';
import BuySellPlayer from './components/BuySellPlayer.vue';
import AddTeamPlayer from './components/AddTeamPlayer.vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    { path: '/', component: TeamsPlayers },
    { path: '/buy-sell', component: BuySellPlayer },
    { path: '/add-team', component: AddTeamPlayer },
  ],
});

new Vue({
  el: '#app',
  router,
  components: {
    TeamsPlayers,
    BuySellPlayer,
    AddTeamPlayer,
  },
  template: `
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <router-link class="navbar-brand" to="/">Football</router-link>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <router-link class="nav-link" to="/">Teams and Players</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/buy-sell">Buy/Sell Player</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/add-team">Create Team With Players</router-link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <router-view></router-view>
  </div>
  `,
});
