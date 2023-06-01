<template>
  <div>
    <div class="container">
      <!-- Add Team Form -->
      <form @submit.prevent="addTeam" class="mb-4">
        <h2 class="text-center">Add Team</h2>
        <div class="mb-3">
          <label for="teamName" class="form-label">Team Name:</label>
          <input type="text" id="teamName" v-model="newTeam.name" required class="form-control">
        </div>
        <div class="mb-3">
          <label for="teamCountry" class="form-label">Country:</label>
          <input type="text" id="teamCountry" v-model="newTeam.country" required class="form-control">
        </div>
        <div class="mb-3">
          <label for="teamMoneyBalance" class="form-label">Money Balance:</label>
          <input type="number" id="teamMoneyBalance" v-model="newTeam.moneyBalance" required class="form-control">
        </div>
        <h3 class="text-center">Add Players</h3>
        <div v-for="(player, index) in newTeam.players" :key="index" class="mb-3">
          <div class="mb-2">
            <label for="playerName" class="form-label">Player Name:</label>
            <input type="text" v-model="player.name" required class="form-control">
          </div>
          <div class="mb-2">
            <label for="playerSurname" class="form-label">Player Surname:</label>
            <input type="text" v-model="player.surname" required class="form-control">
          </div>
        </div>
        <button type="button" @click="addPlayer" class="btn btn-primary">Add Player</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>

    <div v-if="errorMessage" class="alert alert-dismissible alert-primary">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <strong>Error!</strong> {{ errorMessage }}
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
      newTeam: {
        name: '',
        country: '',
        moneyBalance: 0,
        players: []
      },
      errorMessage: '',
      successMessage: ''
    };
  },
  methods: {
    addPlayer() {
      this.newTeam.players.push({ name: '', surname: '' });
    },
    addTeam() {
      axios
        .post('/teams', { newTeam: this.newTeam })
        .then((response) => {
          this.newTeam.name = '';
          this.newTeam.country = '';
          this.newTeam.moneyBalance = 0;
          this.newTeam.players = [];
          this.successMessage = 'Team added successfully';
          this.$router.push({ name: 'TeamsPlayer' });
          window.location.reload();
        })
        .catch((error) => {
          this.errorMessage = 'Error adding team: ' + error.message;
          console.error('Error adding team:', error);
        });
    },
  },
};
</script>

<style>
.container {
  margin: 20px;
  padding: 10px;
  background-color: #f0f0f0;
}

.label {
  font-weight: bold;
}

.input {
  padding: 5px;
  margin-bottom: 10px;
}

.button {
  background-color: #333;
  color: #fff;
  padding: 8px 16px;
  border: none;
  cursor: pointer;
}
</style>
