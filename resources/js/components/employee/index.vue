<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/store-employee" class="btn btn-primary">Add Employee</router-link>
            </div>
        </div>

        <br>
        <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Here">

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table align-items-center table-flush">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Photo</th>
                                                            <th>Phone</th>
                                                            <th>Salary</th>
                                                            <th>Joining Date</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="employee in filterSearch" :key="employee.id">
                                                            <td>{{ employee.name }}</td>
                                                            <td><img :src="employee.photo" :alt="employee.name" class="em_photo"></td>
                                                            <td>{{ employee.phone }}</td>
                                                            <td>{{ employee.salary }}</td>
                                                            <td>{{ employee.joining_date }}</td>
                                                            <td>
                                                                <router-link :to="{ name: 'edit-employee', params: { id: employee.id } }" class="btn btn-sm btn-primary">Edit</router-link>
                                                                <a @click.prevent="deleteEmployee(employee.id)" href="#" class="btn btn-sm btn-danger">Delete</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer"></div>
                                        </div>
                                    </div>
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
            this.allEmployee();
        },
        data(){
            return {
                employees: [],
                searchTerm: ''
            }
        },
        computed: {
            filterSearch(){
                return this.employees.filter(employee => {
                    return employee.name.match(this.searchTerm);
                });
            }
        },
        methods: {
            allEmployee(){
                axios.get('/api/employee/')
                    .then( ({data}) => (this.employees = data))
                    .catch()
            },
            deleteEmployee(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/api/employee/${id}`)
                            .then( () => {
                                this.employees = this.employees.filter(employee => {
                                    return employee.id != id;
                                });
                                Swal.fire('Deleted!', 'Your file has been deleted.', 'success');
                            })
                            .catch( () => Swal.fire('Error!', 'Your file has not been deleted.', 'error'));
                    }
                });
            },
        }
    }
</script>

<style type="text/css">
    .em_photo{
        height: 40px;
        width: 40px;
    }
</style>
