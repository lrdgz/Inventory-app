<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/stock" class="btn btn-primary">Go Back</router-link>
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
                                        <h1 class="h4 text-gray-900 mb-4">Update Stock Product</h1>
                                    </div>
                                    <form class="user" @submit.prevent="updateStock">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Product Name</label>
                                                    <input type="text" class="form-control" v-model="form.product_name" disabled>
                                                    <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Product Code</label>
                                                    <input type="text" class="form-control" v-model="form.product_code" disabled>
                                                    <small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
<!--                                                <div class="col-md-6">-->
<!--                                                    <label>Buying Date</label>-->
<!--                                                    <input type="date" class="form-control" v-model="current_date">-->
<!--                                                    <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>-->
<!--                                                </div>-->
                                                <div class="col-md-6">
                                                    <label>Product Quantity</label>
                                                    <input type="text" class="form-control" v-model="form.product_quantity" placeholder="Product Quantity">
                                                    <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update Stock</button>
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

            //Get Current Product
            let id = this.$route.params.id;
            axios.get(`/api/product/${id}`)
                .then(({ data }) => (this.form = data))
                .catch(console.log('Error'));

            this.form.buying_date = this.current_date;
        },

        data(){
            return{
                form: {
                    product_name: null,
                    product_code: null,
                    buying_date: null,
                    product_quantity: null,
                },
                current_date: new Date().toISOString().slice(0,10),
                errors: {},
            }
        },

        methods: {

            updateStock() {
                let id = this.$route.params.id;
                axios.post(`/api/stock/update/${id}`, this.form)
                    .then(() => {
                        this.$router.push({ name: 'stock' });
                        Notifications.success();
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },

        }
    }
</script>

<style type="text/css">

</style>
