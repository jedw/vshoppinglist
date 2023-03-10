<!-- https://vuejs.org/examples/#hello-world -->
<!-- https://www.positronx.io/handle-ajax-requests-in-vue-js-with-axios-fetch-api/ -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>AJAX TEST</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
</head>
<body>
    <div id="app">
        <h1>AJAX TEST</h1>
            <p v-for="item in shoppingList">{{item.item}}</p>
    </div>
    <script>
        const { createApp } = Vue
        createApp({
            data(){
                return {
                   shoppingList: [],
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
            },
            mounted () {
                this.getlist()
            }
        }).mount('#app')
    </script>
</body>
</html>