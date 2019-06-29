<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <div>
          <v-toolbar flat color="white">
            <v-toolbar-title>Daftar Kriteria dari Aspek Penerimaan Beasiswa</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Kriteria</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ judulForm }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12 md12>
                        <v-select
                          v-model="formItem.id_aspek"
                          :items="pilAspek"
                          item-text="nama"
                          item-value="id"
                          label="Aspek"
                          solo
                          required
                        ></v-select>
                      </v-flex>
                      <v-flex xs12 md6>
                        <v-text-field v-model="formItem.deskripsi" label="Nama"></v-text-field>
                      </v-flex>
                      <v-flex xs12 md6>
                        <v-text-field v-model="formItem.nilai" label="Nilai (1-9)"></v-text-field>
                      </v-flex>
                      <v-flex xs12>
                        <v-radio-group v-model="formItem.jenis" column :mandatory="true">
                          <v-radio label="Kriteria Utama" value="core" default></v-radio>
                          <v-radio label="Kriteria Tambahan" value="secondary"></v-radio>
                        </v-radio-group>
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

          <v-data-table :headers="head" :items="kriteria" :pagination.sync="dataTable">
            <template v-slot:items="props">
              <td>{{ props.item.nama }}</td>
              <td>{{ props.item.deskripsi }}</td>
              <td>{{ props.item.jenis }}</td>
              <td>{{ props.item.nilai }}</td>
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
      rowsPerPage: -1
    },
    pilAspek: [],
    dialog: false,
    head: [
      {
        text: "Aspek",
        sortable: true,
        value: "nama"
      },
      {
        text: "Nama",
        sortable: true,
        value: "deskripsi"
      },
      {
        text: "Jenis",
        sortable: false,
        value: "jenis"
      },
      {
        text: "Nilai",
        sortable: false,
        value: "nilai"
      },
      {
        text: "Aksi",
        value: "aksi"
      }
    ],
    kriteria: [],
    editedIndex: -1,
    formItem: {
      id_aspek: "",
      deskripsi: "",
      nilai: "",
      jenis: ""
    },
    defaultItem: {
      id_aspek: "",
      deskripsi: "",
      nilai: "",
      jenis: ""
    }
  }),
  mounted() {
    this.$http
      .get("AspekController")
      .then(response => (this.pilAspek = response.data.data));
    // axios
    //   .get("https://api.akhmad.id/pspk/AspekController/")
    //   .then(response => (this.pilAspek = response.data.data));
    this.getKriteria();
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
        .get("KriteriaController")
        .then(response => (this.kriteria = response.data.data));
      //   axios
      //     .get("https://api.akhmad.id/pspk/KriteriaController/")
      //     .then(response => (this.kriteria = response.data.data));
    },
    editItem(item) {
      this.editedIndex = this.kriteria.indexOf(item);
      this.formItem = Object.assign({}, item);
      //   this.formItem.id_aspek = this.selectAspek.id_aspek;
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.kriteria.indexOf(item);
      const id_kriteria = this.kriteria[index].id;
      confirm("Anda yakin menghapus calon penerima ini?") &&
        this.$http.delete("KriteriaController/" + id_kriteria);
      setTimeout(() => {
        this.formItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.getKriteria();
      }, 50);
      //   axios.delete(
      //     "https://api.akhmad.id/pspk/KriteriaController/" + id_kriteria
      //   );
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.formItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.getKriteria();
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        // Object.assign(this.kriteria[this.editedIndex], this.formItem);
        const id_kriteria = this.kriteria[this.editedIndex].id;
        this.$http.put("KriteriaController/" + id_kriteria, this.formItem);
        // axios.put(
        //   "https://api.akhmad.id/pspk/KriteriaController/" + id_kriteria,
        //   this.formItem
        // );
      } else {
        this.$http.post("KriteriaController", {
          id_aspek: this.formItem.id_aspek,
          deskripsi: this.formItem.deskripsi,
          jenis: this.formItem.jenis,
          nilai: this.formItem.nilai
        });
        // axios.post("https://api.akhmad.id/pspk/KriteriaController/", {
        //   id_aspek: this.formItem.id_aspek,
        //   deskripsi: this.formItem.deskripsi,
        //   jenis: this.formItem.jenis,
        //   nilai: this.formItem.nilai
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
