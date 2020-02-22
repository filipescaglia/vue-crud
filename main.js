var app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        users: [],
        newUser: {
            name: "",
            email: "",
            phone: ""
        },
        currentUser: {}
    },
    mounted: function() { // All function called here are executed automatically
        this.getUsers()
    },
    methods: {
        getUsers() {
            axios.get("http://localhost/vue-crud-tmp/process.php?action=read").then(function(response) {
                if(response.data.error) {
                    app.errorMsg = response.data.message
                } else {
                    app.users = response.data.users
                }
            })
        },
        addUser() {
            var formData = app.toFormData(app.newUser)
            axios.post("http://localhost/vue-crud-tmp/process.php?action=create", formData).then(function(response) {
                app.newUser = {name: "", email: "", phone: ""}
                if(response.data.error) {
                    app.errorMsg = response.data.message
                } else {
                    app.successMsg = response.data.message
                    app.getUsers()
                }
            })
        },
        updateUser() {
            var formData = app.toFormData(app.currentUser)
            axios.post("http://localhost/vue-crud-tmp/process.php?action=update", formData).then(function(response) {
                app.currentUser = {}
                if(response.data.error) {
                    app.errorMsg = response.data.message
                } else {
                    app.successMsg = response.data.message
                    app.getUsers()
                }
            })
        },
        deleteUser() {
            var formData = app.toFormData(app.currentUser)
            axios.post("http://localhost/vue-crud-tmp/process.php?action=delete", formData).then(function(response) {
                app.currentUser = {}
                if(response.data.error) {
                    app.errorMsg = response.data.message
                } else {
                    app.successMsg = response.data.message
                    app.getUsers()
                }
            })
        },
        toFormData(obj) { // Getting the data and appending all the values in obj var and returning fd variable
            var fd = new FormData()
            for(var i in obj) {
                fd.append(i, obj[i])
            }
            return fd
        },
        selectUser(user) {
            app.currentUser = user
        },
        clearMsg() {
            app.errorMsg = ""
            app.successMsg = ""
        }
    }
})