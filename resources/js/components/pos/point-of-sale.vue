<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">POS</li>
            </ol>
        </div>

        <div class="row mb-3">
            <div class="col-xl-5 col-lg-5">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                        <a href="#" class="btn btn-sm btn-info">Add Customer</a>
                    </div>
                    <div class="card">
                        <div class="table-responsive" style="font-size: 10px;">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr class="p-0">
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Unit</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="cart in carts" :key="cart.id">
                                        <td>{{ cart.pro_name }}</td>
                                        <td>
                                            <button @click="increment(cart.id)" class="btn btn-sm btn-danger">-</button>
                                            <input type="text" readonly :value="cart.pro_quantity" style="width: 20px;">
                                            <button @click="decrement(cart.id)" class="btn btn-sm btn-success">+</button>
                                        </td>
                                        <td>{{ cart.product_price }}</td>
                                        <td>{{ cart.sub_total }}</td>
                                        <td><a @click="removeItem(cart.id)" class="btn btn-sm btn-primary text-white">X</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Quantity: <strong>500</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Sub Total: <strong>500.00 $</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Vat: <strong>35 %</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total: <strong>1500.00 $</strong>
                                </li>
                            </ul>
                            <br>
                            <form action="">
                                <label>Customer Name</label>
                                <select name="" class="form-control" v-model="customer_id">
                                    <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                                        {{ customer.name }} ({{ customer.phone }})
                                    </option>
                                </select>
                                <label>Pay</label>
                                <input type="text" class="form-control" required v-model="pay" />
                                <label>Due</label>
                                <input type="text" class="form-control" required v-model="due" />
                                <label>Pay By</label>
                                <select name="" class="form-control" v-model="customer_id">
                                    <option value="HandCash">Hand Cash</option>
                                    <option value="Cheaque">Cheaque</option>
                                    <option value="GiftCard">Gift Card</option>
                                </select>
                                <br>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7 col-lg-7">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="products-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Products</a>
                            </li>
                            <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id">
                                <a class="nav-link" id="category-tab" data-toggle="tab" href="#category" role="tab" aria-controls="category" aria-selected="false" @click="subProducts(category.id)">{{ category.category_name }}</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="products-tab">
                                <input type="text" v-model="searchProduct" class="form-control" style="width: 100%;" placeholder="Search Here">
                                <div class="row mt-2">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-6 p-0" v-for="product in filterProduct" :key="product.id">
                                        <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                            <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                                <img :src="product.image" :alt="product.product_name" class="card-img-top img-fluid">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ product.product_name }}</h5>
                                                    <span class="badge badge-success" v-if=" product.product_quantity >= 1">Available {{ product.product_quantity }}</span>
                                                    <span class="badge badge-danger"  v-else>Stock Out</span>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
                                <input type="text" v-model="searchProductFilter" class="form-control" style="width: 100%;" placeholder="Search Here">
                                <div class="row mt-2">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-6 p-0" v-for="getProduct in filterProductSearch" :key="getProduct.id">
                                        <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                            <a href="#">
                                                <img :src="getProduct.image" :alt="getProduct.product_name" class="card-img-top em_photo_product">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ getProduct.product_name }}</h5>
                                                    <span class="badge badge-success" v-if=" getProduct.product_quantity >= 1">Available {{ getProduct.product_quantity }}</span>
                                                    <span class="badge badge-danger"  v-else>Stock Out</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Row-->
    </div>
    <!---Container Fluid-->
</template>

<script type="application/javascript">
    export default {
        created() {
            if(!User.loggedIn()){
                this.$router.push({ name: '/' });
            }
            this.allProduct();
            this.allCategories();
            this.allCustomers();
            this.CartProduct();
            Reload.$on('AfterAdd', () => {
                this.CartProduct();
            });
        },
        data(){
            return {
                products: [],
                categories: [],
                getProducts: [],
                customers: [],
                errors: [],
                carts: [],

                searchProduct: '',
                searchProductFilter: '',

                customer_id:'',
                pay:'',
                due:'',
            }
        },
        computed: {
            filterProduct(){
                return this.products.filter(product => {
                    return product.product_name.match(this.searchProduct);
                });
            },
            filterProductSearch(){
                return this.getProducts.filter(getProduct => {
                    return getProduct.product_name.match(this.searchProductFilter);
                });
            },
        },
        methods: {
            allProduct(){
                axios.get('/api/product/')
                    .then( ({data}) => (this.products = data))
                    .catch()
            },
            allCategories(){
                axios.get('/api/category/')
                    .then( ({data}) => (this.categories = data))
                    .catch()
            },
            subProducts(id){
                axios.get(`/api/getting/product/${id}`)
                    .then( ({data}) => (this.getProducts = data))
                    .catch()
            },
            allCustomers(){
                axios.get(`/api/customer`)
                    .then( ({data}) => (this.customers = data))
                    .catch(console.log('Error'))
            },

            //Cart Methods Here
            AddToCart(product){
                axios.get(`/api/addToCart/${product}`)
                    .then( ({data}) => {
                        Reload.$emit('AfterAdd');
                        Notifications.cart_success(data.pro_name);
                    })
                    .catch()
            },
            CartProduct(){
                axios.get(`/api/cart/product`)
                    .then( ({data}) => (this.carts = data) )
                    .catch()
            },
            removeItem(item){
                axios.get(`/api/cart/remove/${item}`)
                    .then( () => {
                        Reload.$emit('AfterAdd');
                        Notifications.cart_delete();
                    })
                    .catch()
            },
            decrement(item){
                axios.get(`/api/cart/increment/${item}`)
                    .then( () => {
                        Reload.$emit('AfterAdd');
                        Notifications.success();
                    })
                    .catch()
            },
            increment(item){
                axios.get(`/api/cart/decrement/${item}`)
                    .then( () => {
                        Reload.$emit('AfterAdd');
                        Notifications.success();
                    })
                    .catch()
            },
        }
    }
</script>

<style type="text/css" scoped>
    .em_photo_product{
        height: 90px;
        width: 135px;
    }

    .remove-margin{
        margin-right: 0 !important;
        margin-left: 0 !important;;
    }
</style>
