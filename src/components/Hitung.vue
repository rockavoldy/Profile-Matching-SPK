<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <div>
          <pre>{{dataMinMax}}</pre>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { setTimeout } from "timers";
export default {
  data: () => ({
    dataMinMax: {}
  }),
  mounted() {
    this.$http.get("HitungController").then(response => {
      setTimeout(() => {
        this.dataMinMax = Object.assign({}, response.data.data);
        console.log(response.data);
      }, 500);
    });
  }
};
</script>