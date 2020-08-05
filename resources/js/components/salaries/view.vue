<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/salary" class="btn btn-primary">Go Back</router-link>
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
                                                <h6 class="m-0 font-weight-bold text-primary">Employee Salary Details</h6>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table align-items-center table-flush">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Month</th>
                                                            <th>Amount</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="salary in filterSearch" :key="salary.id">
                                                            <td>{{ salary.name }}</td>
                                                            <td>{{ salary.salary_month }}</td>
                                                            <td>{{ salary.amount }}</td>
                                                            <td>{{ salary.salary_date }}</td>
                                                            <td>
                                                                <router-link :to="{ name: 'edit-salary', params: { id: salary.id } }" class="btn btn-sm btn-primary">Edit Salary</router-link>
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
            this.viewSalary();
        },
        data(){
            return {
                salaries: [],
                searchTerm: ''
            }
        },
        computed: {
            filterSearch(){
                return this.salaries.filter(salary => {
                    return salary.name.match(this.searchTerm);
                });
            }
        },
        methods: {
            viewSalary(){
                let year = this.$route.params.salary_year;
                let month = this.$route.params.salary_month;

                axios.get(`/api/salary/view/${year}/${month}`)
                    .then(({ data }) => (this.salaries = data))
                    .catch(error => this.errors = error.response.data.errors)
            }
        }
    }
</script>

<style type="text/css">

</style>
