<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/index-employee" class="btn btn-primary">All Employee</router-link>
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
                                        <h1 class="h4 text-gray-900 mb-4">Add Employee</h1>
                                    </div>
                                    <form class="user" @submit.prevent="employeeInsert" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control" v-model="form.name" placeholder="Enter Full Name">
                                                    <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control" v-model="form.email" placeholder="Enter Email">
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
                                                    <label>Salary</label>
                                                    <input type="text" class="form-control" v-model="form.salary" placeholder="Enter Salary">
                                                    <small class="text-danger" v-if="errors.salary">{{ errors.salary[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Joined Date</label>
                                                    <input type="date" class="form-control" v-model="form.joining_date" placeholder="Enter Joined Date">
                                                    <small class="text-danger" v-if="errors.joining_date">{{ errors.joining_date[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>NID</label>
                                                    <input type="text" class="form-control" v-model="form.nid" placeholder="Enter NID">
                                                    <small class="text-danger" v-if="errors.nid">{{ errors.nid[0] }}</small>
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
                                                        <input type="file" class="custom-file-input" id="EmployeePhoto">
                                                        <label class="custom-file-label" for="EmployeePhoto">Photo</label>
                                                        <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <img src="form.photo" alt="" style="height: 40px; width: 40px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
        },

        data(){
            return{
                form: {
                    name: null,
                    email: null,
                    phone: null,
                    salary: null,
                    address: null,
                    photo: null,
                    nid: null,
                    joining_date: null,
                },
                errors: {},
            }
        },

        methods: {
            employeeInsert(){
                axios.post('/api/auth/signup', this.form)
                    .then(res => {
                        User.responseAfterLogin(res);
                        Toast.fire({
                            icon: 'success',
                            title: 'Signed in successfully'
                        });
                        this.$router.push({ name: 'home' });
                    })
                    .catch(error => this.errors = error.response.data.errors);
            }
        }
    }
</script>

<style type="text/css">

</style>
