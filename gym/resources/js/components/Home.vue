<template>
    <div class="Home-Container">
        <div class="boxes">

            <div class="box">
                <strong v-model="total_Sales">${{total_Sales}}</strong>
                <p>Total Sales</p>
            </div>

            <div class="box">
                 <strong v-model="customers">{{customers}}</strong>
                <p>Active Customers</p>
            </div>
             <div class="box">
                 <strong v-model="total_subs">{{total_subs}}</strong>
                <p>Total Subscribe</p>
            </div>
        </div>

        <div class="table">
            <template>
            <v-data-table
                dense
                :headers="headers"
                :items="equipments"
                item-key="name"
                class="elevation-1"
            ></v-data-table>
            </template>
        </div>
        
    </div>
</template>

<script>
  export default {
    data: () => ({
       headers: [ 
        {
          text: 'Name',
          align: 'start',
          sortable: true,
          value: 'name',
        },
        { text: 'Description', value: 'description', sortable: false},
        { text: 'Date Checking', value: 'date_checking'},
      ],
      equipments: [],
      total_Sales: 0,
      customers: '',
      total_subs: ''
    }),
    created () {
        this.initializeTable();
        this.getTotalCustomer();
        this.getTotalSubscription();
        this.getTotalSales();
    },
    methods: {
        initializeTable () {
            fetch('http://127.0.0.1:8000/api/equipment/index')
            .then(res => res.json())
            .then(data => { this.equipments = data;
            }).catch(error => {
                console.log(error);
            });
        },
        getTotalCustomer(){
            fetch('http://127.0.0.1:8000/api/customer/index')
            .then(res => res.json())
            .then(data => this.customers = data.length)
            .catch(error => {
                console.log(error);
            });
        },
        getTotalSubscription() {
           fetch('http://127.0.0.1:8000/api/subscription/index')
          .then(res => res.json())
          .then(data => this.total_subs = data.length)
          .catch(error => {console.log(error)});
        },
        getTotalSales(){
            fetch('http://127.0.0.1:8000/api/payment/index')
            .then(res => res.json())
            .then(data => {
                data.forEach(data => {  
                    this.total_Sales += parseInt(data.payment_total);
                })
            })
            .catch(error => {console.log(error)});
        },
    }
  }
</script>

<style>
    .boxes, .box{
        display:flex;
        align-items:center;
        justify-content: center;
        margin: 1.5rem;
    }
    .box{
        width: min(300px, 100%);
        height: max(200px, 100px);
        border: 1px solid black;
        flex-direction: column;
        border-radius: 8px;
       
    }
    .box strong{
        font-size: 3rem;
    }
    .box p{
        font-size: 0.8rem;
        margin-top: -0.9rem;
    }
    @media(max-width: 600px) {
        .boxes{
            flex-direction: column;
        }
    }
</style>