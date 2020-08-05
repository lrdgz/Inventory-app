<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/index-expense" class="btn btn-primary">All Expense</router-link>
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
                                        <h1 class="h4 text-gray-900 mb-4">Add Expense</h1>
                                    </div>
                                    <form class="user" @submit.prevent="expenseInsert">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <label>Expense Details</label>
                                                    <textarea class="form-control" rows="5" v-model="form.details"></textarea>
                                                    <small class="text-danger" v-if="errors.details">{{ errors.details[0] }}</small>
                                                </div>
                                            </div>
                                            <div class="form-row mt-2">
                                                <div class="col-md-6">
                                                    <label>Expense Amount</label>
                                                    <input type="text" class="form-control" v-model="form.amount" placeholder="Enter Expense Amount">
                                                    <small class="text-danger" v-if="errors.amount">{{ errors.amount[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Expense Date</label>
                                                    <input type="date" class="form-control" v-model="form.expense_date">
                                                    <small class="text-danger" v-if="errors.expense_date">{{ errors.expense_date[0] }}</small>
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
                    details: '',
                    amount: '0.00',
                    expense_date: null,
                },
                errors: {},
            }
        },

        methods: {

            expenseInsert() {
                axios.post('/api/expense', this.form)
                    .then(() => {
                        this.$router.push({ name: 'index-expense' });
                        Notifications.success();
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },

        }
    }
</script>

<style type="text/css">

</style>
