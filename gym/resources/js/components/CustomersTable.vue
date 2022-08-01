<template>
  <v-data-table
    :headers="headers"
    :items="customers"
    sort-by=""
    :search="search"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title> </v-toolbar-title>
        CUSTOMER
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
          width="100px"
        ></v-text-field>

        <v-spacer></v-spacer>     

        <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
             <v-icon
              small
              class="pr-2"
             >
              mdi-account-plus
            </v-icon>
              Add Customer
            </v-btn>
          </template>
          
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                    <v-text-field
                      v-model="editedItem.first_name"
                      label="First Name"
                      outlined
                      dense
                      :rules="[() => !!editedItem.first_name || 'This field is required']"
                      required
                    ></v-text-field>
                    
                    
                    <v-text-field
                      v-model="editedItem.last_name"
                      label="Last Name"
                      :rules="[() => !!editedItem.last_name || 'This field is required']"
                      required
                      outlined
                      dense
                    ></v-text-field>

                     <v-text-field
                      v-model="editedItem.address"
                      label="Address"
                      :rules="[() => !!editedItem.address || 'This field is required']"
                      required
                      outlined
                      dense
                    ></v-text-field>

                     <v-text-field
                      v-model="editedItem.phone"
                      label="Phone"
                      :rules="[() => !!editedItem.phone || 'This field is required']"
                      required
                      outlined
                      dense
                    ></v-text-field>

                     <v-text-field
                      v-model="editedItem.email"
                      label="Email"
                      :rules="[() => !!editedItem.email || 'This field is required']"
                      required
                      outlined
                      dense
                    ></v-text-field>

                  </v-col>

                </v-row>
              </v-container>
            </v-card-text> 

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>

          </v-card>

        </v-dialog>

        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5 text-center">Are you sure you want to delete {{  editedItem.first_name }}?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-dialog
        v-model="dialog3"
        max-width="500px"
        >
        <v-card>
              <v-card-title>
                <span> {{ editedItem.first_name }} {{ editedItem.last_name }}</span>
                <v-spacer></v-spacer>
                
              </v-card-title>

               <v-card-text>
               <strong>Personal Info</strong>
               <ul class="list-unstyled">
                  <li> <strong>Address:</strong> {{editedItem.address}} </li>
                  <li> <strong>Phone:</strong> {{editedItem.phone}} </li>
                  <li> <strong>Email:</strong> {{ editedItem.email}} </li>
               </ul>

               <strong>Subscription Info</strong>
                <ul class="list-unstyled">
                  <li> <strong>Start:</strong> {{showItem.start_date}} </li>
                  <li> <strong>End:</strong> {{showItem.end_date}} </li>
               </ul>
              </v-card-text>
        
              <v-card-actions>
                <v-btn
                  color="primary"
                  text
                  @click="closeDetails"
                >
                  Close
                </v-btn>
              </v-card-actions>
            </v-card>
        </v-dialog>

      </v-toolbar>

    </template>

    <template v-slot:item.actions="{ item }">
     <v-icon
        small
        color="teal darken-2"
        @click="showDatails(item)"
      >
        mdi-account-eye
      </v-icon>
      <v-icon
        small
        class="mr-2"
        color="primary"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        color="red"
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <div>
        No data !
      </div>
    </template>

  </v-data-table>

</template>

<script>
  export default {
    name: 'CustomersTable',
    data: () => ({
      dialog: false,
      dialog3: false,
      dialogDelete: false,
      search: '',
      headers: [
        {
          text: 'Customer ID',
          align: 'start',
          sortable: true,
          value: 'id',
        },
        { text: 'First Name', value: 'first_name'},
        { text: 'Last Name', value: 'last_name'},
        { text: 'Address', value: 'address' , sortable: false },
        { text: 'Phone', value: 'phone' , sortable: false },
        { text: 'Email', value: 'email' , sortable: false},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      customers: [],
      editedIndex: -1,
      editedItem: {
        id:'',
        first_name: '',
        last_name: '',
        address: '',
        phone: '',
        email: '',
      },
      defaultItem: {
        id: '',
        first_name: '',
        last_name: '',
        address: '',
        phone: '',
        email : '',
      },
      showItem: {
        start_date: '',
        end_date: '',
      },
    }),
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Customer' : 'Edit Customer'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        fetch('http://127.0.0.1:8000/api/customer/index')
        .then(res => res.json())
        .then(data => {
           this.customers = data;
        }).catch(error => {
            console.log(error);
        });
      },

      async showDatails(item) {
        this.editedItem = Object.assign({}, item)
        this.dialog3 = true
        await fetch(' http://127.0.0.1:8000/api/customer/getCustomerSubcription/' + item.id)
        .then(res => res.json())
        .then(data => {
            if(data === 0){
                this.showItem.start_date = "None";
                this.showItem.end_date = "None";
            }
            else{
              this.showItem.start_date = data.start_date;
              this.showItem.end_date = data.end_date;
            }
        }).catch(error => {
            console.log(error);
        });
      },

      editItem (item) {
        this.editedIndex = this.customers.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.customers.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm (){
        fetch('http://127.0.0.1:8000/api/customer/delete/' + this.customers[this.editedIndex].id, {
            // Adding method type
            method: "DELETE"
        })
        .catch(error => {
            console.log(error);
        }); 

        this.customers.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },
      closeDetails(){
        this.dialog3 = false;
        this.editedItem = Object.assign({}, this.defaultItem);
      },
      async save () {
        if(this.validate())
        {

          if (this.editedIndex > -1){
            Object.assign(this.customers[this.editedIndex], this.editedItem);

            fetch('http://127.0.0.1:8000/api/customer/update/' + this.customers[this.editedIndex].id, {
              // Adding method type
              method: "PUT",
              
              // Adding body or contents to send
              body: JSON.stringify(
                  this.editedItem
              ),
              
              // Adding headers to the request
              headers: {
                  "Content-type": "application/json; charset=UTF-8"
              }
            })
            .then(res => res.json())
            .catch(error => {
                console.log(error);
            });
          } 
          else{
            await fetch('http://127.0.0.1:8000/api/customer/create', {
              // Adding method type
              method: "POST",
              
              // Adding body or contents to send
              body: JSON.stringify(
                  this.editedItem
              ),
              
              // Adding headers to the request
              headers: {
                  "Content-type": "application/json; charset=UTF-8"
              }
            })
            .then(res => res.json())
            .then(data => {
              this.editedItem.id = data[data.length - 1].id;
            })
            .catch(error => {
                console.log(error);
            });

            this.customers.push(this.editedItem)
          }

          this.close();

        }
      },
      validate (){
        if(!this.editedItem.first_name || !this.editedItem.last_name  || !this.editedItem.address  || !this.editedItem.email  || !this.editedItem.phone ){
           alert("Fill all form");
           return false; 
        }
        else{
          return true;
        }
      }
    },
  }
</script>