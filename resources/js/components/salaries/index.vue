<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/given-salary" class="btn btn-primary">Pay Salary</router-link>
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
                                                <h6 class="m-0 font-weight-bold text-primary">All Salary Details</h6>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table align-items-center table-flush">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Total Paid</th>
                                                            <th>Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="salary in filterSearch" :key="salary.id">
                                                            <td>{{ salary.salary_year }}</td>
                                                            <td>{{ salary.salary_month }}</td>
                                                            <td>{{ salary.total_amount }}</td>
                                                            <td>
                                                                <router-link :to="{ name: 'view-salary', params: { salary_year: salary.salary_year, salary_month: salary.salary_month } }" class="btn btn-sm btn-primary">View Salary</router-link>
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
            this.allSalary();
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
                    return salary.salary_month.match(this.searchTerm);
                });
            }
        },
        methods: {
            allSalary(){
                axios.get('/api/salary/')
                    .then( ({data}) => (this.salaries = data))
                    .catch()
            }
        }
    }
</script>

<style type="text/css">
    .em_photo{
        height: 40px;
        width: 40px;
    }
</style>
