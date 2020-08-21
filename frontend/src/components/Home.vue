<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <div>
          <v-toolbar flat color="white">
            <v-toolbar-title>Daftar Calon Penerima Beasiswa</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Siswa</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ judulForm }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12 sm6 md4>
                        <v-text-field v-model="formItem.nisn" label="NISN"></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm6 md4>
                        <v-text-field v-model="formItem.nama" label="Nama"></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm6 md4>
                        <v-text-field v-model="formItem.asal_sekolah" label="Asal Sekolah"></v-text-field>
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
                <v-icon small @click="deleteItem(props.item)">delete</v-icon>
              </td>
            </template>
          </v-data-table>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    dataTable: {
      rowsPerPage: 25
    },
    dialog: false,
    head: [
      {
        text: "NISN",
        sortable: false,
        value: "nisn"
      },
      {
        text: "Nama",
        sortable: true,
        value: "nama"
      },
      {
        text: "Asal Sekolah",
        sortable: true,
        value: "asal_sekolah"
      },
      {
        text: "Aksi",
        value: "aksi"
      }
    ],
    siswa: [],
    editedIndex: -1,
    formItem: {
      nisn: "",
      nama: "",
      asal_sekolah: ""
    },
    defaultItem: {
      nisn: "",
      nama: "",
      asal_sekolah: ""
    }
  }),
  mounted() {
    // axios
    //   .get("https://api.akhmad.id/pspk/SiswaController/")
    //   .then(response => (this.siswa = response.data.data));
    this.getSiswa();
  },
  computed: {
    judulForm() {
      return this.editedIndex === -1 ? "Tambah Siswa" : "Edit Siswa";
    }
  },
  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  methods: {
    getSiswa() {
      this.$http.get("SiswaController").then(response => {
        this.siswa = response.data.data;
      });
      //   axios
      //     .get("https://api.akhmad.id/pspk/SiswaController/")
      //     .then(response => (this.siswa = response.data.data));
    },
    editItem(item) {
      this.editedIndex = this.siswa.indexOf(item);
      this.formItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.siswa.indexOf(item);
      const id_siswa = this.siswa[index].id;
      confirm("Anda yakin menghapus calon penerima ini?") &&
        this.$http.delete("SiswaController/" + id_siswa);
      setTimeout(() => {
        this.formItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.getSiswa();
      }, 50);

      //   axios.delete("https://api.akhmad.id/pspk/SiswaController/" + id_siswa);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.formItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.getSiswa();
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        // Object.assign(this.siswa[this.editedIndex], this.formItem);
        const id_siswa = this.siswa[this.editedIndex].id;
        this.$http.put("SiswaController/" + id_siswa, this.formItem);
        // axios.put(
        //   "https://api.akhmad.id/pspk/SiswaController/" + id_siswa,
        //   this.formItem
        // );
      } else {
        this.$http.post("SiswaController", {
          nisn: this.formItem.nisn,
          nama: this.formItem.nama,
          asal_sekolah: this.formItem.asal_sekolah
        });
        // this.siswa.push(this.formItem);
      }
      this.close();
    }
  }
};
</script>

<style>
</style>
