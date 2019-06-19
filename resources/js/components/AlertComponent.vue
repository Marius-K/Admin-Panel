<template>
    <b-alert
      :show="dismissCountDown"
      dismissible
      fade
      :variant="variant"
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged"
    >
      {{ text }}
    </b-alert>
</template>

<script>
  export default {
    data() {
        return {
            dismissSecs: 5,
            dismissCountDown: 0,
            text: "",
            variant: "success"
        }
    },
    mounted() {
        this.$root.$on('showAlert', (text, variant) => {
            this.showAlert(text, variant);
        })
    },
    methods: {
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
        showAlert(text, variant) {
            this.dismissCountDown = this.dismissSecs
            this.text = text;
            this.variant = variant;
        }
    }
  }
</script>