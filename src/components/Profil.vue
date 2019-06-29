<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <v-toolbar flat color="white">
          <v-toolbar-title>Data Nilai Calon Penerima Beasiswa</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-select
            :items="pilAspek"
            item-value="id"
            item-text="nama"
            @change="getKriteria"
            label="Pilih Aspek"
          ></v-select>
        </v-toolbar>
      </v-flex>
      <v-flex xs12 color="white" class="px-1">
        <table style="width: 100%; border-collapse: collapse" border="1" class="text-xs-center">
          <tr>
            <th>No.</th>
            <th>NIM</th>
            <th v-for="(itemHead, i) in head" :key="i">{{ itemHead.deskripsi }}</th>
          </tr>
          <tr v-for="(itemSiswa, i) in siswa" :key="i">
            <td>{{ i+1 }}</td>
            <td>{{ itemSiswa.nisn }}</td>
            <td v-for="(n, j) in head" :key="j">
              <!-- <span v-if="itemSiswa.nilai[(n-1)]">{{ itemSiswa.nilai[(n-1)] }}</span> -->
              <input
                type="text"
                class="white px-2"
                style="width: 100%"
                placeholder="Nilai"
                :name="n.id"
                :id="itemSiswa.id"
                @change="getInput"
                v-model="inputValue[itemSiswa.id+'-raw-'+n.id]"
                @keypress="isNumber($event)"
                maxlength="12"
              >
              <!-- v-model="nilaiKirim[itemSiswa.id+'-'+n.id+'-raw']" -->
              <!-- <input type="hidden" v-model="nilaiKirim['id_siswa'+i]" value="itemSiswa.id">
              <input type="hidden" v-model="nilaiKirim['id_factor'+i]" value="n.id">-->
            </td>
            <!-- <td v-for="n in indexKriteria" :key="n">{{ i+','+(n-1) }}</td> -->
          </tr>
          <!-- <tr>
            <td colspan="10">{{siswa}}</td>
          </tr>
          <tr>
            <td colspan="10">{{nilaiKirim}}</td>
          </tr>-->
          <!-- <tr>
            <td colspan="10">{{ inputValue }}</td>
          </tr>-->
        </table>
        <v-btn color="info" @click="sendNilai">Simpan</v-btn>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    pilAspek: [],
    head: [],
    selectedAspek: {},
    siswa: [],
    kriteria: [],
    indexKriteria: null,
    nilaiKirim: [],
    inputValue: {},
    isiKriteria: []
  }),
  created() {
    // this.$http.get("NilaiProfilController/" + this.id_aspek).then(response => {
    //   this.head = response.data.data;
    // });

    this.$http.get("NilaiProfilController/siswa").then(response => {
      this.siswa = response.data.data;
      // console.log(response.data.data);
    });

    this.$http.get("AspekController").then(response => {
      // console.log(response.data.data);
      this.pilAspek = response.data.data;
    });

    this.getRaw();
  },
  computed: {
    judulForm() {
      return this.editedIndex === -1 ? "Tambah Aspek" : "Edit Aspek";
    }
  },
  methods: {
    isNumber: function(evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57)
        // charCode !== 46
      ) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    getRaw() {
      this.$http.get("NilaiProfilController/raw").then(res => {
        // this.isiKriteria = Object.assign({}, res.data.data);
        this.inputValue = res.data.data;
      });
    },
    getKriteria(selected) {
      this.$http.get("KriteriaController/" + selected).then(response => {
        // this.head = response.data.data;
        // return response.data.data;
        this.head = Object.assign({}, response.data.data);
        this.indexKriteria = response.data.data.length;

        // console.log(this.indexKriteria);
        // console.log(this.isiKriteria);
        this.nilaiKirim = [];
      });
    },
    getInput(input) {
      // console.log(input.target.value); // isi input
      // console.log(input.target.name); // id kriteria
      // console.log(input.target.id); // id siswa
      let data = {
        id_siswa: input.target.id,
        id_factor: input.target.name,
        raw_data: input.target.value
      };
      // console.log(data);
      this.nilaiKirim.push(data);
      data = {};
      // console.log(this.nilaiKirim);
    },
    sendNilai() {
      let data = this.nilaiKirim;
      setTimeout(() => {
        for (let i = 0; i < data.length; i++) {
          this.$http.post("NilaiProfilController/raw", {
            id_siswa: data[i].id_siswa,
            id_factor: data[i].id_factor,
            raw_data: data[i].raw_data
          });
        }
      }, 600);
      alert("Berhasil di update");
    }
  }
};
</script>

<style>
</style>
