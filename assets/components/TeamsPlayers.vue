<template>
  <div>
    <h2 class="text-center">Teams List</h2>
    <div class="table-container mx-auto" style="max-width: 1200px;">
      <table id="teamsTable" class="table table-hover">
        <thead class="table-dark">
          <tr>
            <th scope="col">Team</th>
            <th scope="col">Country</th>
            <th scope="col">Money Balance</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="team in teams" :key="team.name" @click="loadPlayers(team)">
            <th scope="row">{{ team.name }}</th>
            <td>{{ team.country }}</td>
            <td>{{ team.moneyBalance }}</td>
          </tr>
        </tbody>
      </table>
      <div class="pagination-select">
        <label for="itemsPerPage">Items per page:</label>
        <select v-model="itemsPerPage" @change="updatePagination">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
        </select>
      </div>
      <paginate
        v-model="currentPageTeams"
        :page-count="pageCountTeams"
        :page-range="3"
        :margin-pages="2"
        :click-handler="loadTeamsPage"
        container-class="pagination justify-content-center"
        :prev-text="'Prev'"
        :next-text="'Next'"
        :page-class="'page-item'"
        :page-link-class="'page-link text-dark'"
        :prev-class="'page-item'"
        :prev-link-class="'page-link text-dark'"
        :next-class="'page-item'"
        :next-link-class="'page-link text-dark'"
        :active-class="'active'"
        :active-link-class="'bg-dark'"
      ></paginate>
    </div>

    <h2 class="text-center">Players List</h2>
    <div class="table-container mx-auto" style="max-width: 1200px;">
      <div class="selected-team-info" v-if="selectedTeam">
        <h3>Team: {{ selectedTeam.name }}</h3>
        <h4>Country: {{ selectedTeam.country }}</h4>
      </div>
      <table id="playersTable" class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th>Player Name</th>
            <th>Player Surname</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="player in players" :key="player.name">
            <td>{{ player.name }}</td>
            <td>{{ player.surname }}</td>
          </tr>
        </tbody>
      </table>
      <div class="pagination-select">
        <label for="itemsPerPage">Items per page:</label>
        <select v-model="itemsPerPage" @change="updatePagination">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
        </select>
      </div>
      <paginate
        v-model="currentPagePlayers"
        :page-count="pageCountPlayers"
        :page-range="3"
        :margin-pages="2"
        :click-handler="loadPlayersPage"
        container-class="pagination justify-content-center"
        :prev-text="'Prev'"
        :next-text="'Next'"
        :page-class="'page-item'"
        :page-link-class="'page-link text-dark'"
        :prev-class="'page-item'"
        :prev-link-class="'page-link text-dark'"
        :next-class="'page-item'"
        :next-link-class="'page-link text-dark'"
        :active-class="'active'"
        :active-link-class="'bg-dark'"
      ></paginate>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Paginate from 'vuejs-paginate';

export default {
  components: {
    Paginate,
  },
  data() {
    return {
      allTeams: [],
      allPlayers: [],
      teams: [],
      players: [],
      currentPageTeams: 1,
      pageCountTeams: 0,
      currentPagePlayers: 1,
      pageCountPlayers: 0,
      itemsPerPage: 10,
      selectedTeam: null,
    };
  },
  mounted() {
    this.fetchTeamsAndPlayers();
  },
  methods: {
    fetchTeamsAndPlayers() {
      axios
        .get('/teams/players')
        .then((response) => {
          this.allTeams = response.data;
          this.pageCountTeams = Math.ceil(this.allTeams.length / this.itemsPerPage);
          this.loadTeamsPage(1);
        })
        .catch((error) => {
          console.error('Error fetching teams and players:', error);
        });
    },

    loadPlayers(team) {
      this.selectedTeam = team;
      this.allPlayers = team.players;
      this.pageCountPlayers = Math.ceil(this.allPlayers.length / this.itemsPerPage);
      this.loadPlayersPage(1);
    },

    loadTeamsPage(pageNumber) {
      this.currentPageTeams = pageNumber;
      const startIndex = (pageNumber - 1) * this.itemsPerPage;
      this.teams = this.allTeams.slice(startIndex, startIndex + this.itemsPerPage);
    },

    loadPlayersPage(pageNumber) {
      this.currentPagePlayers = pageNumber;
      const startIndex = (pageNumber - 1) * this.itemsPerPage;
      this.players = this.allPlayers.slice(startIndex, startIndex + this.itemsPerPage);
    },

    updatePagination() {
      this.pageCountTeams = Math.ceil(this.allTeams.length / this.itemsPerPage);
      this.pageCountPlayers = Math.ceil(this.allPlayers.length / this.itemsPerPage);
      this.loadTeamsPage(1);
      this.loadPlayersPage(1);
    },
  },
};
</script>

<style>
.table-container {
  margin-top: 20px;
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

.selected-team-info {
  margin-bottom: 20px;
}
</style>

<style>
.custom-table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
}

.custom-table th,
.custom-table td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.custom-table th {
  background-color: #f5f5f5;
  font-weight: bold;
}

.custom-table tr:hover {
  background-color: #f9f9f9;
}

#teamsTable_wrapper,
#playersTable_wrapper {
  margin-bottom: 20px;
}
</style>
