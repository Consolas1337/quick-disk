<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Consolas disk</title>
<link rel="stylesheet" href="css/style.css">
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.13.1/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://vk.com/js/api/openapi.js?167" type="text/javascript" SameSite="None Secure"></script>
</head>
<body id="body">
    <div class="auth-container" id="auth">
        <div class="auth-body">
            <a v-if="!data.name">Private password: </a><input type="password" v-if="!data.name" placeholder="password here" v-model="password"></input>
            <br><a v-if="data.name">Welcome {{ data.name }}</a>
        </div>
    </div>
    <div  id="register">
        <input type="text" name="pass" id="pass" v-model="newPassword" placeholder="Your quick password">
        <input type="button" value="Register" v-on:click="register()">
    </div>
    <script>
    new Vue({
    el: "#auth",
    watch: {
        password: function(newPass, oldPass) {
            // todo: add loading icon
            this.debounceLogin();
        },
    },
    created: function() {
        this.debounceLogin = _.debounce(this.login, 750);        
    },
    data: {
        password: '',
        request: {},
        data: {
            name: '',
        },
    },
    methods: {
        login: function() {
            this.request = new URLSearchParams();
            this.request.append('password', this.password);
            console.log("Submit complete!");
            axios
                .post('./login.php',this.request)
                .then(response => this.loadUserData(response))
                .catch(error => console.log(error));
        },
        loadUserData: function(response) {
            this.data = response.data;
            if (this.data.error===undefined) {
                return false;
            }
            localStorage.token = this.data.token;
            localStorage.name = this.data.name;
        },
    },
    mounted() {
        if (localStorage.name & localStorage.token) {
            console.log("You logged in");
        }
    },
    });
    </script>
    <script>
    new Vue({
    el: "#register",
    data: {
        newPassword: '',
    },
    methods: {
        register: function() {
            let parentThis = this;
            VK.Auth.login(function(vkResponse) {
            if (vkResponse.session) {
                let incomingData = new URLSearchParams({new_password: parentThis.newPassword, session: JSON.stringify(vkResponse.session)});
                axios
                    .post('./register.php',incomingData)
                    .then(response => console.log(response.data))
                    .catch(error => console.log(error));
            } else {
                alert("Для регистрации нужно авторизироваться с помощью VK. Без этого никак.");
            }
            });
        },
    },
    mounted() {
        VK.init({
            apiId: 7331619,
        });
    },
    });
    </script>
</body>
</html>


