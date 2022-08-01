<template>
  <v-data-table
    :headers="headers"
    :items="subscriptions"
    sort-by=""
    :search="search"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title> </v-toolbar-title>
        SUBSCRIPTION
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
              mdi-credit-card-plus
            </v-icon>
              Add Subscription
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

                  <v-menu
                    v-model="menu1"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                    >

                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                          v-model="editedItem.start_date"
                          label="Start Date"
                          prepend-inner-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                          outlined
                          dense
                          :rules="[() => !!editedItem.start_date || 'This field is required']"
                          required
                      ></v-text-field>
                    </template>
                    
                    <v-date-picker
                    v-model="editedItem.start_date"
                    @input="menu1 = false"
                    ></v-date-picker>
                 </v-menu>

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
                          v-model="editedItem.end_date"
                          label="End Date"
                          prepend-inner-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                          outlined
                          dense
                          :rules="[() => !!editedItem.end_date || 'This field is required']"
                      required
                      ></v-text-field>

                    </template>
                      <v-date-picker
                      v-model="editedItem.end_date"
                      @input="menu2 = false"
                      ></v-date-picker>
                    </v-menu>

                  <v-text-field
                      v-model="editedItem.payment_id"
                      label="Payment id"
                      outlined
                      dense
                      :rules="[() => !!editedItem.payment_id || 'This field is required']"
                      required
                    ></v-text-field>

                     <v-text-field
                      v-model="editedItem.customer_id"
                      label="Customer id"
                      outlined
                      dense
                      :rules="[() => !!editedItem.customer_id || 'This field is required']"
                      required
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

        <v-dialog v-model="dialogDelete" max-width="550px">
          <v-card>
            <v-card-title class="text-h5 text-center">Are you sure you want to delete this Subscription?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>

      </v-toolbar>

    </template>
    <template v-slot:item.actions="{ item }">
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
    name: 'SubscriptionsTable',
    data: () => ({
      date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      menu1: false,
      menu2: false,
      dialog: false,
      dialogDelete: false,
      search:'',
      headers: [ 
        {
          text: 'Subscription ID',
          align: 'start',
          sortable: true,
          value: 'id',
        },
        { text: 'Start Date', value: 'start_date'},
        { text: 'End Date', value: 'end_date'},
        { text: 'Customer Id', value: 'customer_id' },
        { text: 'Payment Id', value: 'payment_id'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      subscriptions: [],
      editedIndex: -1,
      editedItem: {
        id:'',
        start_date: '',
        end_date: '',
        customer_id: '',
        payment_id: '',
      },
      defaultItem: {
        id:'',
        start_date: '',
        end_date:'',
        customer_id: '',
        payment_id: '',
      },
      validation: {
        id:'',
        start_date: '',
        end_date:'',
        customer_id: '',
        payment_id: '',
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Subscription' : 'Edit Subscription'
        
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
      this.initialize();
      this.editedItem.start_date = this.date;
      this.editedItem.end_date = this.date;
    },

    methods: {
      initialize () {
        fetch('http://127.0.0.1:8000/api/subscription/index')
        .then(res => res.json())
        .then(data => {
           this.subscriptions = data;
        }).catch(error => {
            console.log(error);
        });
      },

      editItem (item) {
        this.editedIndex = this.subscriptions.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.validation = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.subscriptions.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        fetch('http://127.0.0.1:8000/api/subscription/delete/' + this.subscriptions[this.editedIndex].id, {
            // Adding method type
            method: "DELETE"
        })
        .catch(error => {
            console.log(error);
        });

        this.subscriptions.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.validation = Object.assign({}, this.defaultItem)
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

      async save () {
        if(await this.validate() && await this.isCustomerExist() && await this.hasAlreadySubscribe() && await this.hasAlreadyPaid())
        {
          if (this.editedIndex > -1){
            Object.assign(this.subscriptions[this.editedIndex], this.editedItem);

            fetch('http://127.0.0.1:8000/api/subscription/update/' + this.subscriptions[this.editedIndex].id, {
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
            await fetch('http://127.0.0.1:8000/api/subscription/create', {
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
              this.editedItem.id = data.id;
            })
            .catch(error => {
                console.log(error);
            });

            this.subscriptions.push(this.editedItem)
          }

          this.close();
        }
      },
      validate (){
        if(!this.editedItem.start_date || !this.editedItem.end_date || !this.editedItem.customer_id || !this.editedItem.payment_id){
           alert("Fill all form");
           return false; 
        }
        else{
          return true;
        } 
      },
      async isCustomerExist(){
        let isExist = false;
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
      },
      async hasAlreadySubscribe (){
        let hasSubscribe = false;
        if(this.validation.customer_id == this.editedItem.customer_id){
          hasSubscribe = true;
        }else{
          hasSubscribe = await this.fetchSubscription();
        }
        return hasSubscribe;
      },
      async fetchSubscription(){
        let temp = false
        await fetch('http://127.0.0.1:8000/api/subscription/hasSubscription/' + this.editedItem.customer_id )
           .then(res => res.json())
           .then(data => {
            if(data === 1){
              alert("Customer ID " + this.editedItem.customer_id +  " has already subscribe!");
              temp = false;
            }else{
              temp = true;
            }
            }).catch(error => {
              console.log(error);
            });
        return temp;
      },
      async hasAlreadyPaid (){
        let has_Paid = false;
        if(this.validation.payment_id == this.editedItem.payment_id){
            has_Paid = true;
        }else{
           has_Paid = await this.fetchPayment();
        }
        return has_Paid;
      },
     async fetchPayment(){
        let temp2 = false
        await fetch('http://127.0.0.1:8000/api/payment/hasPaid/' + this.editedItem.payment_id )
           .then(res => res.json())
           .then(data => {
            if(data === 1){
              alert("Payment ID " + this.editedItem.payment_id +  " has already paid!");
              temp2 = false;
            }else
              temp2 = true;
            }).catch(error => {
              console.log(error);
          });
        return temp2;
      },
    },
  }
</script>