<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/index-supplier" class="btn btn-primary">All Suppliers</router-link>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Update Supplier</h1>
                                    </div>
                                    <form class="user" @submit.prevent="employeeUpdate" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control" v-model="form.name" placeholder="Enter Full Name">
                                                    <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" v-model="form.email" placeholder="Enter Email">
                                                    <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-control" v-model="form.phone" placeholder="Enter Phone">
                                                    <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Shop Name</label>
                                                    <input type="text" class="form-control" v-model="form.shopname" placeholder="Enter Full Name">
                                                    <small class="text-danger" v-if="errors.shopname">{{ errors.shopname[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label>Address</label>
                                                    <textarea class="form-control" v-model="form.address" placeholder="Enter Address" style="resize: none !important;"></textarea>
                                                    <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="EmployeePhoto" @change="onFileSelected">
                                                        <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
                                                        <label class="custom-file-label" for="EmployeePhoto">Photo</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.photo" :alt="form.name" style="height: 40px; width: 40px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                                        </div>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="application/javascript">
    export default {
        created() {
            if(!User.loggedIn()){
                this.$router.push({ name: '/' });
            }

            let id = this.$route.params.id;
            axios.get(`/api/supplier/${id}`)
                .then(({ data }) => (this.form = data))
                .catch(console.log('Error'));
        },

        data(){
            return{
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    shopname: '',
                    address: '',
                    photo: '',
                    newphoto: '',
                },
                errors: {},
            }
        },

        methods: {

            onFileSelected(event) {
                let file = event.target.files[0];
                if(file.size > 1048770){
                    Notifications.image_validation();
                } else {
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.newphoto = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            employeeUpdate() {
                let id = this.$route.params.id;
                axios.patch(`/api/supplier/${id}`, this.form)
                    .then(() => {
                        this.$router.push({ name: 'index-supplier' });
                        Notifications.success();
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },

        }
    }
</script>

<style type="text/css">

</style>
