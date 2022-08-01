<template>
  <v-data-table
    :headers="headers"
    :items="payments"
    sort-by=""
    :search="search"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title> </v-toolbar-title>
        PAYMENT
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
              mdi-cash-plus
            </v-icon>
              Add Payment
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
                      v-model="editedItem.payment_total"
                      label="Payment Total"
                      outlined
                      dense
                      :rules="[() => !!editedItem.payment_total || 'This field is required']"
                      required
                      @keypress="filter()"
                    ></v-text-field>

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
                            v-model="editedItem.payment_date"
                            label="Payment Date"
                            prepend-inner-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                            outlined
                            dense
                            :rules="[() => !!editedItem.payment_date || 'This field is required']"
                            required
                        ></v-text-field>

                      </template>
                      <v-date-picker
                      v-model="editedItem.payment_date"
                      @input="menu1 = false"
                      ></v-date-picker>
                    </v-menu>

                    <v-text-field
                      v-model="editedItem.customer_id"
                      label="Customer id"
                      outlined
                      dense
                      :rules="[() => !!editedItem.customer_id || 'This field is required']"
                      required
                    ></v-text-field>

                    <v-text-field
                      v-model="editedItem.subscription_id"
                      label="Subscription id"
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

        <v-dialog v-model="dialogDelete" max-width="550px">
          <v-card>
            <v-card-title class="text-h5 text-center">Are you sure you want to delete this Payment?</v-card-title>
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
    name: 'PaymentsTable',
    data: () => ({
      date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
      menu1: false,
      dialog: false,
      dialogDelete: false,
      search:'',
      headers: [ 
        {
          text: 'Payment ID',
          align: 'start',
          sortable: true,
          value: 'id',
        },
        { text: 'Payment Total', value: 'payment_total'},
        { text: 'Payment Date', value: 'payment_date'},
        { text: 'Customer Id', value: 'customer_id' },
        { text: 'Subscription Id', value: 'subscription_id'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      payments: [],
      editedIndex: -1,
      editedItem: {
        id:'',
        payment_total: '',
        payment_date:'',
        customer_id: '',
        subscription_id: '',
      },
      defaultItem: {
        id:'',
        payment_total: '',
        payment_date:'',
        customer_id: '',
        subscription_id: '',
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Payment' : 'Edit Payment'
        
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
      this.editedItem.payment_date = this.date;
    },

    methods: {
      initialize () {
        fetch('http://127.0.0.1:8000/api/payment/index')
        .then(res => res.json())
        .then(data => {
           this.payments = data;
        }).catch(error => {
            console.log(error);
        });
      },
      filter: function(evt) {
        evt = (evt) ? evt : window.event;
        let expect = evt.target.value.toString() + evt.key.toString();
        
        if (!/^[-+]?[0-9]*\.?[0-9]*$/.test(expect)) {
          evt.preventDefault();
        } else {
          return true;
        }
      },
      editItem (item) {
        this.editedIndex = this.payments.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.payments.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        fetch('http://127.0.0.1:8000/api/payment/delete/' + this.payments[this.editedIndex].id, {
            // Adding method type
            method: "DELETE"
        })
        .catch(error => {
            console.log(error);
        });

        this.payments.splice(this.editedIndex, 1)
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

      async save () {
        if(await this.validate() && await this.isCustomerExist() && await this.isSubscriptionExist())
        {
          if (this.editedIndex > -1){
            Object.assign(this.payments[this.editedIndex], this.editedItem);
            fetch('http://127.0.0.1:8000/api/payment/update/' + this.payments[this.editedIndex].id, {
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
            await fetch('http://127.0.0.1:8000/api/payment/create', {
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

            this.payments.push(this.editedItem)
          }

          this.close();
        }
      },
      validate (){
        if(!this.editedItem.payment_total || !this.editedItem.payment_date || !this.editedItem.customer_id ){
           alert("Fill all form (Subscription can be empyt)");
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
      async isSubscriptionExist(){
        if(!this.editedItem.subscription_id){
          return true;
        }
        else{
          let isExist = true;
           await fetch('http://127.0.0.1:8000/api/subscription/getSubscription/' + this.editedItem.subscription_id )
           .then(res => res.json())
           .then(data => {
            if(data === 0){
              alert("Subscription ID " + this.editedItem.subscription_id +  " does not exist");
              isExist = false;
            }else
              isExist = true;
            }).catch(error => {
              console.log(error);
          });
          return isExist;
        }
      },
    },
  }
</script>