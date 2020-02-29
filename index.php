<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Quick disk by Consolas</title>
    <link rel="icon" href="css/png/disk1.png">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.13.1/lodash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://vk.com/js/api/openapi.js?167" type="text/javascript" SameSite="None Secure"></script>
</head>
<body id="body">
<header>
    <div class="logo-container">
        <div class="logo-body">
            <a class="logo-text">Quick disk</a>&nbsp;<a href="https://vk.com/consolas" class="logo-link">by Consolas</a>
        </div>
    </div>
    <div class="auth-container" id="auth">
        <div class="auth-body">
            <a v-if="!data.name"></a><input type="password" v-if="!data.name" placeholder="password here" v-model="password"></input>   
            <input type="button" value="Register" v-on:click="register()" v-if="password && !data.role">
            <br><a v-if="data.name">Welcome {{ data.name }}</a>
        </div>
    </div>
</header>
    <script>
    new Vue({
    el: "#auth",
    name: "loginApp",
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
        profilePhotoUrl: '',
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
        register: function() {
            VK.Auth.login((vkResponse) => {
                if (vkResponse.session) {
                    VK.Api.call('users.get', {user_ids: vkResponse.session.mid, v:"5.103", fields:"photo_200"}, (r) => {
                        if(r.response) {
                            this.profilePhotoUrl = r.response[0].photo_200;
                            let incomingData = new URLSearchParams({new_password: this.password, profilePhotoUrl: this.profilePhotoUrl, session: JSON.stringify(vkResponse.session)});
                            axios
                                .post('./register.php',incomingData)
                                .then(response => console.log(response.data))
                                .catch(error => console.log(error));
                        }
                    });
                } else {
                    alert("Для регистрации нужно авторизироваться с помощью VK. Без этого никак.");
                }
            });
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
        VK.init({apiId: 7331619,});
        if (localStorage.name & localStorage.token) {
            console.log("You logged in");
        }
    }, 
    });
    </script>

</body>
</html>


