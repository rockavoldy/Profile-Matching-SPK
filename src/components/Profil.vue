<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <div>
          <v-toolbar flat color="white">
            <v-toolbar-title>Data Nilai Calon Penerima Beasiswa</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" min-width="600px">
              <v-card>
                <v-card-title>
                  <span class="headline">Edit Nilai Profil</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12>
                        <v-select
                          v-model="formItem.id_aspek"
                          :items="pilAspek"
                          item-text="nama"
                          item-value="id"
                          label="Aspek"
                          solo
                          required
                          @change="getKriteria()"
                        ></v-select>
                      </v-flex>
                      <v-flex xs12>
                        <table width="100%" class="text-xs-center">
                          <tr class="title" style="border: 1px">
                            <th>Kriteria</th>
                            <th>Nilai</th>
                          </tr>
                          <tr v-for="(crit,i) in kriteria" :key="crit.id">
                            <td class="text-xs-left">
                              <span class="title">{{ crit.deskripsi }}</span>
                            </td>
                            <td>
                              <v-text-field
                                label="Nilai"
                                placeholder="Nilai"
                                mask="#"
                                v-model="crit.id"
                              ></v-text-field>
                            </td>
                          </tr>
                        </table>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" flat @click="save">Save</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-toolbar>
          <v-data-table :headers="head" :items="siswa" :pagination.sync="dataTable">
            <template v-slot:items="props">
              <td>{{ props.item.nisn }}</td>
              <td>{{ props.item.nama }}</td>
              <td>{{ props.item.asal_sekolah }}</td>
              <td class="justify-center layout px-0">
                <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
              </td>
            </template>
          </v-data-table>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    pilAspek: [],
    dataTable: {
      rowsPerPage: -1
    },
    dialog: false,
    head: [
      {
        text: "NISN",
        value: "nisn"
      },
      {
        text: "Nama",
        value: "nama"
      },
      {
        text: "Asal Sekolah",
        value: "asal_sekolah"
      },
      {
        text: "Aksi",
        value: "aksi"
      }
    ],
    selectedAspek: {
      id: ""
    },
    id_aspek: "1",
    siswa: [],
    kriteria: [],
    editedIndex: -1,
    formItem: [],
    defaultItem: [],
    tampung: [
      {
        id_siswa: "",
        id_factor: "",
        nilai: ""
      }
    ]
  }),
  mounted() {
    // this.$http.get("NilaiProfilController/" + this.id_aspek).then(response => {
    //   this.head = response.data.data;
    // });

    this.$http.get("SiswaController").then(response => {
      this.siswa = response.data.data;
    });

    this.$http
      .get("NilaiProfilController/aspek")
      .then(response => (this.pilAspek = response.data.data));
    // axios
    //   .get("https://api.akhmad.id/pspk/AspekController/")
    //   .then(response => (this.aspek = response.data.data));
    // this.getKriteria();
  },
  computed: {
    judulForm() {
      return this.editedIndex === -1 ? "Tambah Aspek" : "Edit Aspek";
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  methods: {
    getKriteria() {
      this.$http
        .get("KriteriaController/" + this.formItem.id_aspek)
        // .then(response => (this.kriteria = response.data.data));
        .then(response => (this.head = response.data.data));
      //   axios
      //     .get("https://api.akhmad.id/pspk/AspekController/")
      //     .then(response => (this.aspek = response.data.data));
    },

    pilihItem(item) {
      const index = this.pilAspek.indexOf(item);
      const id_aspek = this.pilAspek[index].id;
      this.selectedAspek.id = id_aspek;
    },

    editItem(item) {
      const index = this.siswa.indexOf(item);
      this.editedIndex = this.siswa.indexOf(item);
      const id_siswa = this.siswa[index].id;
      this.formItem = Object.assign({}, item);
      this.dialog = true;
      console.log(item);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.formItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        // Object.assign(this.kriteria[this.editedIndex], this.formItem);
        // const id_kriteria = this.kriteria[this.editedIndex].id;
        // this.$http.put("AspekController/" + id_kriteria, this.formItem);
        // axios.put(
        //   "https://api.akhmad.id/pspk/AspekController/" + id_kriteria,
        //   this.formItem
        // );
      } else {
        // this.$http.post("AspekController", {
        //   nama: this.formItem.nama,
        //   persentase: this.formItem.persentase
        // });
        // axios.post("https://api.akhmad.id/pspk/AspekController/", {
        //   nama: this.formItem.nama,
        //   persentase: this.formItem.persentase
        // });
        // this.kriteria.push(this.formItem);
      }

      this.close();
    }
  }
};
</script>

<style>
</style>
