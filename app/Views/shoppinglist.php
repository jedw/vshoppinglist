<!-- https://vuejs.org/examples/#hello-world -->
<!-- https://www.positronx.io/handle-ajax-requests-in-vue-js-with-axios-fetch-api/ -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vue Shopping</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
    <style>
        body{
            font-family: sans-serif;
            background-color: #ffffaa;
            color: #000088;
        }
        .checkoff{
            text-decoration:line-through;
            color:#ff5555;
        }
        li {
            list-style-type: disc;
        }
    </style>
</head>
<body>
    <div id="app">
        <h1>Shopping List</h1>
        <input v-model="newItem">
        <button v-bind:disabled="newItem.length < 3" v-on:click="additem">Add Item</button> 
        <button v-on:click="clearlist">Clear List</button> 
        <ul>
            <li v-for="item in shoppingList" :class="[item.checkoff == true ? 'checkoff' : '']" v-on:click="checkoff(item.id, item.checkoff)">{{item.item}}</li>
        </ul>
    </div>
    <script>
        const { createApp } = Vue
        createApp({
            data(){
                return {
                   shoppingList: [],
                   newItem: ''
                }
            },
            methods: {
                getlist: function (){
                    axios.get('<?php echo site_url('getlist')?>')
                    .then(res => {
                        this.shoppingList = res.data
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
                },
                checkoff: function (id, checkoff){
                    checkoff = 1 - checkoff
                    var self = this
                    var data = new URLSearchParams([["id", id],["checkoff", checkoff]]);
                    axios.post('<?php echo site_url('checkoff')?>', data)
                    .then (function () {
                        self.getlist()  
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
                },
                additem: function (){
                    var self = this
                    var data = new URLSearchParams([["item", this.newItem], ["checkoff", false]]);
                    axios.post('<?php echo site_url('additem')?>', data)
                    .then (function () {
                        self.newItem = ""
                        self.getlist()  
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
                },
                clearlist: function (){
                    var self = this
                    axios.get('<?php echo site_url('clear')?>')
                    .then (function () {
                        self.getlist()  
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
                }
            },
            mounted () {
                this.getlist()
            }
        }).mount('#app')
    </script>
</body>
</html>