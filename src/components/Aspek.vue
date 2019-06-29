<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <div>
          <v-toolbar flat color="white">
            <v-toolbar-title>Daftar Aspek Penerimaan Beasiswa</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on">Tambah Aspek</v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">{{ judulForm }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs12>
                        <v-text-field v-model="formItem.nama" label="Nama"></v-text-field>
                      </v-flex>
                      <v-flex xs12 md4>
                        <v-text-field v-model="formItem.persentase" label="Persentase" suffix="%"></v-text-field>
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

          <v-data-table :headers="head" :items="aspek" :pagination.sync="dataTable">
            <template v-slot:items="props">
              <td>{{ props.item.nama }}</td>
              <td>{{ props.item.persentase }}</td>
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
    dialog: false,
    head: [
      {
        text: "Nama",
        sortable: false,
        value: "nama"
      },
      {
        text: "Persentase",
        sortable: true,
        value: "persentase"
      },
      {
        text: "Aksi",
        value: "aksi"
      }
    ],
    aspek: [],
    editedIndex: -1,
    formItem: {
      nama: "",
      persentase: ""
    },
    defaultItem: {
      nama: "",
      persentase: ""
    }
  }),
  mounted() {
    // axios
    //   .get("https://api.akhmad.id/pspk/AspekController/")
    //   .then(response => (this.aspek = response.data.data));
    this.getAspek();
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
    getAspek() {
      this.$http
        .get("AspekController")
        .then(response => (this.aspek = response.data.data));
      //   axios
      //     .get("https://api.akhmad.id/pspk/AspekController/")
      //     .then(response => (this.aspek = response.data.data));
    },
    editItem(item) {
      this.editedIndex = this.aspek.indexOf(item);
      this.formItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.aspek.indexOf(item);
      const id_aspek = this.aspek[index].id;
      confirm("Anda yakin menghapus calon penerima ini?") &&
        this.$http.delete("AspekController/" + id_aspek);
      setTimeout(() => {
        this.formItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.getAspek();
      }, 50);

      //   axios.delete("https://api.akhmad.id/pspk/AspekController/" + id_aspek);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.formItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.getAspek();
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        // Object.assign(this.aspek[this.editedIndex], this.formItem);
        const id_aspek = this.aspek[this.editedIndex].id;
        this.$http.put("AspekController/" + id_aspek, this.formItem);
        // axios.put(
        //   "https://api.akhmad.id/pspk/AspekController/" + id_aspek,
        //   this.formItem
        // );
      } else {
        this.$http.post("AspekController", {
          nama: this.formItem.nama,
          persentase: this.formItem.persentase
        });
        // axios.post("https://api.akhmad.id/pspk/AspekController/", {
        //   nama: this.formItem.nama,
        //   persentase: this.formItem.persentase
        // });
        // this.aspek.push(this.formItem);
      }
      this.close();
    }
  }
};
</script>

<style>
</style>
