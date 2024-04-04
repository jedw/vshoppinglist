<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vue Shopping</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .checkoff {
            text-decoration: line-through;
            color: #0a0;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="container">
            <div class="mt-4 p-5 bg-light text-primary rounded">
                <h1>Shopping List</h1>
            </div>

            <label for="new_item_input">Item: </label>
            <input id="new_item_input" class="form-control mb-2 mt-2" v-model="newItem">
            <button class="btn btn btn-primary mb-3 mt-3 mx-1" v-bind:disabled="newItem.length < 3"
                v-on:click="additem">Add Item</button>
            <button class="btn btn btn-danger mb-3 mt-3 mx-1" v-on:click="clearlist">Clear List</button>

            <ul class="list-group">
                <li v-for="item in shoppingList" class="list-group-item"
                    :class="[item.checkoff == true ? 'list-group-item list-group-item-success checkoff' : 'list-group-item']"
                    v-on:click="checkoff(item.id, item.checkoff)">{{item.item}}</li>
            </ul>
        </div>
    </div>
    <script>
        const { createApp } = Vue
        createApp({
            data() {
                return {
                    shoppingList: [],
                    newItem: ''
                }
            },
            methods: {
                getlist: function () {
                    fetch('<?php echo site_url('getlist') ?>')
                        .then(response => response.json())
                        .then(data => this.shoppingList = data)
                        .catch(error => console.error('Error:', error));
                },
                checkoff: function (id, checkoff) {
                    checkoff = 1 - checkoff
                    var self = this
                    var data = new URLSearchParams([["id", id], ["checkoff", checkoff]]);

                    fetch('<?php echo site_url('checkoff') ?>', {
                        method: 'POST',
                        body: data,
                    })
                        .then(() => self.getlist())
                        .catch(error => {
                            console.error('Error:', error)
                        })
                },
                additem: function () {
                    var self = this
                    var data = new URLSearchParams([["item", this.newItem], ["checkoff", false]]);

                    fetch('<?php echo site_url('additem') ?>', {
                        method: 'POST',
                        body: data,
                    })
                        .then(() => {
                            self.newItem = ""
                            self.getlist()
                        })
                        .catch(error => {
                            console.error('Error:', error)
                        })
                },
                clearlist: function () {
                    var self = this
                    fetch('<?php echo site_url('clear') ?>')
                        .then(() => self.getlist())
                        .catch(error => console.error('Error:', error));
                }
            },
            mounted() {
                this.getlist()
            }
        }).mount('#app')
    </script>
</body>

</html>
