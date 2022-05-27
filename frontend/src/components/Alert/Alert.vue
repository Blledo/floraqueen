<template>
  <div class="alert-wrapper">
    <div
      v-for="(alert, i) in alerts"
      :key="i"
      class="alert-badge"
      :class="alert.color"
    >
      <div class="alert-message">
        {{ alert.message }}
      </div>
      <div v-if="alert.action_text" class="alert-action" @click="alert.action">
        {{ alert.action_text }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Alert",
  props: {
    countdown: {
      type: Number,
      default: 3000,
    },
  },
  data() {
    return {
      alerts: [],
    };
  },

  methods: {
    registerAlert(alert) {
      this.alerts.push(alert);

      setTimeout(() => {
        this.alerts.shift();
      }, this.countdown);
    },
  },
};
</script>

<style lang="css">
.alert-wrapper {
  position: absolute;
  top: 40px;
  right: 40px;
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
}

.alert-badge {
  width: 300px;
  background-color: rgba(58, 155, 90, 0.4);
  border: 2px solid rgba(58, 155, 90, 1);
  border-radius: 3px;
  margin-bottom: 20px;
  display: grid;
  grid-template-columns: 80% 20%;
  grid-gap: 0px;
  padding: 2px;
}

.alert-message {
  text-align: left;
  font-weight: 300;
  font-size: 1rem;
  padding: 7px;
}

.alert-action {
  text-align: center;
  font-weight: 300;
  font-size: 1rem;
  text-transform: uppercase;
  cursor: pointer;
  padding: 6px;
}

.alert-badge.success {
  background-color: rgba(58, 155, 90, 0.4);
  border: 2px solid rgba(58, 155, 90, 1);
}

.alert-badge.success .alert-message {
  color: rgb(30, 71, 44);
}

.alert-badge.success .alert-action {
  color: rgb(30, 71, 44);
  background-color: rgba(58, 155, 90, 0.8);
}

.alert-badge.error {
  background-color: rgba(194, 68, 68, 0.4);
  border: 2px solid rgba(194, 68, 68, 1);
}

.alert-badge.error .alert-message {
  color: rgb(110, 45, 45);
}

.alert-badge.error .alert-action {
  color: rgb(110, 45, 45);
  background-color: rgba(194, 68, 68, 0.8);
}

.alert-badge.warning {
  background-color: rgba(224, 150, 81, 0.4);
  border: 2px solid rgba(224, 150, 81, 0.1);
}

.alert-badge.warning .alert-message {
  color: rgb(102, 72, 38);
}

.alert-badge.warning .alert-action {
  color: rgb(102, 72, 38);
  background-color: rgba(224, 150, 81, 0.8);
}
</style>
