<template>
  <div class="container">
    <h2 class="mt-4">Sell Form</h2>
    <div class="form-group">
      <label for="team">Team:</label>
      <select id="team" class="form-control" v-model="selectedTeam" @change="loadPlayers(selectedTeam)">
        <option value="">Select a team</option>
        <option v-for="team in teams" :value="team.name" :key="team.name">{{ team.name }}</option>
      </select>
    </div>
    <div v-if="selectedTeam" class="form-group">
      <label for="player">Player:</label>
      <select id="player" class="form-control" v-model="selectedPlayer">
        <option value="">Select a player</option>
        <option v-for="(player, index) in allPlayers" :value="player.id" :key="index">{{ player.name }} {{ player.surname }}</option>
      </select>
    </div>
    <div v-if="selectedPlayer" class="form-group">
      <label for="price">Price:</label>
      <input type="number" id="price" class="form-control" v-model="price" min="0">
    </div>
    <button @click="submitForm" class="btn btn-primary">Valider</button>

    <div class="mt-4">
      <h3>Available Players</h3>
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Price</th>
            <th>Transfer To</th>
            <th>Transfer</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(player, index) in availablePlayers" :key="index">
            <td>{{ player.name }}</td>
            <td>{{ player.surname }}</td>
            <td>{{ player.price }}</td>
            <td>
              <select id="team" class="form-control" v-model="player.selectedTransferTeam">
                <option value="">Select a team</option>
                <option v-for="team in filteredTeams" :value="team.id" :key="team.id">{{ team.name }}</option>
              </select>
            </td>
            <td>
              <button class="btn btn-primary" @click="transferPlayer(player)">Transfer</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="errorMessage" class="alert alert-dismissible alert-primary">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Oh snap!</strong> {{ errorMessage }}
    </div>

    <div v-if="successMessage" class="alert alert-dismissible alert-success">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Success!</strong> {{ successMessage }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      teams: [],
      selectedTeam: '',
      selectedPlayer: null,
      price: 0,
      availablePlayers: [],
      filteredTeams: [],
      errorMessage: '',
      successMessage: ''
    };
  },
  computed: {
    allPlayers() {
      return this.teams.flatMap(team => team.players);
    }
  },
  mounted() {
    this.fetchTeamsAndPlayers();
    this.fetchAvailablePlayers();
  },
  methods: {
    fetchTeamsAndPlayers() {
      axios.get('/teams/players')
        .then(response => {
          this.teams = response.data;
          this.filteredTeams = response.data;
        })
        .catch(error => {
          this.errorMessage = `Error fetching teams and players: ${error.message}`;
        });
    },
    loadPlayers(selectedTeam) {
      this.selectedPlayer = null;
      this.filteredTeams = this.teams.filter(team => team.name !== selectedTeam);
    },
    fetchAvailablePlayers() {
      axios.get('/players/available')
        .then(response => {
          this.availablePlayers = response.data.map(player => ({
            id: player.id,
            name: player.name,
            surname: player.surname,
            price: player.price,
            selectedTransferTeam: ''
          }));
        })
        .catch(error => {
          this.errorMessage = `Error fetching available players: ${error.message}`;
        });
    },
    submitForm() {
      if (this.selectedTeam && this.selectedPlayer && this.price > 0) {
        const formData = {
          id: this.selectedPlayer,
          price: this.price
        };

        axios.post('/players/sell', formData)
          .then(response => {
            this.selectedTeam = '';
            this.selectedPlayer = null;
            this.price = 0;
            this.fetchAvailablePlayers();
            this.successMessage = 'Sell successful';
          })
          .catch(error => {
            this.errorMessage = `Error selling player: ${error.message}`;
          });
      } else {
        this.errorMessage = 'Invalid form data';
      }
    },
    transferPlayer(player) {
      if (player.selectedTransferTeam && player.id) {
        const formData = {
          id: player.id,
          teamId: player.selectedTransferTeam
        };

        axios.post('/players/transfer', formData)
          .then(response => {
            this.fetchAvailablePlayers();
            this.successMessage = 'Transfer successful';
          })
          .catch(error => {
            this.errorMessage = 'Error transferring player: not enaugh Balance';
          });
      } else {
        this.errorMessage = 'Invalid transfer data';
      }
    }
  }
};
</script>
