<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <v-toolbar flat color="white">
          <v-toolbar-title>Data Hasil Perhitungan</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn disabled flat class="grey white--text" v-if="ifDataTable">Hitung</v-btn>
          <v-btn flat class="blue white--text" @click="hitung" v-else>Hitung</v-btn>
        </v-toolbar>
        <v-data-table
          v-if="ifDataTable"
          :headers="head"
          :items="siswa"
          :pagination.sync="dataTable"
        >
          <template v-slot:items="props">
            <td>{{ props.item.nisn+' - '+props.item.nama }}</td>
            <td v-for="(data, i) in props.item.data" :key="i">{{ Number(data.hasil).toFixed(3) }}</td>
            <td v-for="j in ((head.length - props.item.data.length) - 2)" :key="j">0</td>
            <td>{{ Number(props.item.total).toFixed(3) }}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { setTimeout } from "timers";
export default {
  data: () => ({
    dataTable: {
      rowsPerPage: 10,
      sortBy: "total",
      descending: true
    },
    ifDataTable: false,
    head: [],
    siswa: [],
    k: 1
  }),
  methods: {
    hitung() {
      this.$http.get("HitungController").then(response => {
        setTimeout(() => {
          this.head = response.data.data.head;
          this.siswa = response.data.data.siswa;
          this.ifDataTable = true;
        }, 500);
      });
    }
  }
};
</script>