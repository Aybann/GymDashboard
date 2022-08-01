<template>
  <v-data-table
    :headers="headers"
    :items="equipments"
    sort-by=""
    :search="search"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title> </v-toolbar-title>
        EQUIPMENT
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
              mdi-archive-plus
            </v-icon>
              Add Equipment
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
                    sm="10"
                    md="12"
                  >
                    <v-text-field
                      v-model="editedItem.name"
                      label="Name"
                      outlined
                      dense
                      :rules="[() => !!editedItem.name || 'This field is required']"
                      required
                    ></v-text-field>

                    <v-menu
                      v-model="menu2"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                      >
                      <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                          v-model="editedItem.date_checking"
                          label="Date Checking"
                          prepend-inner-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                          outlined
                          dense
                          :rules="[() => !!editedItem.date_checking || 'This field is required']"
                          required
                      ></v-text-field>
                      </template>
                      <v-date-picker
                      v-model="editedItem.date_checking"
                      @input="menu2 = false"
                      ></v-date-picker>
                    </v-menu>

                     <v-text-field
                      v-model="editedItem.customer_id"
                      label="Customer id"
                      outlined
                      dense
                    ></v-text-field>


                     <v-textarea
                        v-model="editedItem.description"
                        clearable
                        clear-icon="mdi-close-circle"
                        label="Description"
                        value="This is clearable text."
                        outlined
                        dense
                        :rules="[() => !!editedItem.description || 'This field is required']"
                        required
                        no-resize
                      ></v-textarea>

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

        <v-dialog v-model="dialogDelete" max-width="550px">
          <v-card>
            <v-card-title class="text-h5 text-center">Are you sure you want to delete this {{  editedItem.name }}?</v-card-title>
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
                <span> {{editedItem.name}} </span>
                <v-spacer></v-spacer>
              </v-card-title>

               <v-card-text>
               <strong>Equipment Info</strong>
               <ul class="list-unstyled">
                  <li> <strong>Date Checking:</strong> {{editedItem.date_checking}} </li>
                  <li> <strong>Description:</strong> {{editedItem.description}} </li>
               </ul>
              </v-card-text>
              
              <div class="text-center">
                 <img v-bind:src="imgLink"/>
              </div>
          
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
        mdi-eye
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
    name: 'EquipmentTable',
    data: () => ({
      date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      menu2: false,
      dialog: false,
      dialog3: false,
      dialogDelete: false,
      search:'',
      headers: [ 
        {
          text: 'Equipment ID',
          align: 'start',
          sortable: true,
          value: 'id',
        },
        { text: 'Name', value: 'name'},
        { text: 'Description', value: 'description', sortable: false},
        { text: 'Date Checking', value: 'date_checking'},
        { text: 'Customer ID', value: 'customer_id'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      equipments: [],
      editedIndex: -1,
      editedItem: {
        id: '',
        name: '',
        description:'',
        date_checking: '',
        customer_id: '',
      },
      defaultItem: {
        id:'',
        name: '',
        description:'',
        date_checking: '',
        customer_id: '',
      },
      imgLink: '',
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Equipment' : 'Edit Equipment'
        
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
      this.editedItem.date_checking = this.date;
    },

    methods: {
      initialize () {
        fetch('http://127.0.0.1:8000/api/equipment/index')
        .then(res => res.json())
        .then(data => {
           this.equipments = data;
        }).catch(error => {
            console.log(error);
        });
      },
      async showDatails(item) {
        this.editedItem = Object.assign({}, item)
        this.editedIndex = this.equipments.indexOf(item)
        await fetch('http://127.0.0.1:8000/api/qrcode/' + this.equipments[this.editedIndex].id)
        .then(res => res.blob())
        .then(data => {
          this.imgLink = URL.createObjectURL(data);
        })
        .catch(error => {
            console.log(error);
        });
        this.dialog3 = true;
      },

      editItem (item) {
        this.editedIndex = this.equipments.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.equipments.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        fetch('http://127.0.0.1:8000/api/equipment/delete/' + this.equipments[this.editedIndex].id, {
            // Adding method type
            method: "DELETE"
        })
        .catch(error => {
            console.log(error);
        });

        this.equipments.splice(this.editedIndex, 1)
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
        this.editedIndex = -1;
      },
      async save (){
        if(await this.validate() && await this.isCustomerExist())
        {
          
          if (this.editedIndex > -1){
            Object.assign(this.equipments[this.editedIndex], this.editedItem);

            fetch('http://127.0.0.1:8000/api/equipment/update/' + this.equipments[this.editedIndex].id, {
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
            await fetch('http://127.0.0.1:8000/api/equipment/create', {
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
            .then(data =>{
              this.editedItem.id = data[data.length - 1].id;
            })
            .catch(error => {
                console.log(error);
            });
            this.equipments.push(this.editedItem);
          }
         this.close();
        }
      },
      validate (){
        if(!this.editedItem.name || !this.editedItem.description  || !this.editedItem.date_checking ){
           alert("Fill all form (Customer id can be black)");
           return false; 
        }
        else{
          return true;
        }
      },
      async isCustomerExist(){
        if(!this.editedItem.customer_id){
          console.log("it okay to be empty")
          return true;
        }
        else{
          let isExist = true;
           await fetch('http://127.0.0.1:8000/api/customer/getCustomer/' + this.editedItem.customer_id )
           .then(res => res.json())
           .then(data => {
            if(data === 0){
              alert("Customer ID " + this.editedItem.customer_id +  " does not exist");
              isExist = false;
            }else
              isExist = true;
            }).catch(error => {
              console.log(error);
          });
          return isExist;
        }
      },

    }
  }
</script>
