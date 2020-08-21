<template>
  <v-app>
    <v-toolbar app>
      <v-toolbar-title class="headline text-uppercase">
        <span>Beasiswa</span>
      </v-toolbar-title>
      <v-btn flat to="/">
        <span>Siswa</span>
      </v-btn>
      <v-btn flat to="/aspek">
        <span>Aspek</span>
      </v-btn>
      <v-btn flat to="/kriteria">
        <span>Kriteria</span>
      </v-btn>
      <v-btn flat to="/nilai">
        <span>Nilai Profil Siswa</span>
      </v-btn>
      <v-btn flat to="/hitung">
        <span>Perhitungan</span>
      </v-btn>
    </v-toolbar>

    <v-content>
      <router-view></router-view>
    </v-content>
  </v-app>
</template>

<script>
export default {
  name: "App",
  components: {},
  data() {
    return {
      //
    };
  }
};
</script>
