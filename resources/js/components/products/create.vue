<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/index-product" class="btn btn-primary">All Products</router-link>
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
                                        <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                                    </div>
                                    <form class="user" @submit.prevent="productInsert" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Product Name</label>
                                                    <input type="text" class="form-control" v-model="form.product_name" placeholder="Enter Product Name">
                                                    <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Product Code</label>
                                                    <input type="text" class="form-control" v-model="form.product_code" placeholder="Enter Product Code">
                                                    <small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Product Category</label>
                                                    <select class="form-control" v-model="form.category_id">
                                                        <option v-for="category in categories" :value="category.id">{{ category.category_name }}</option>
                                                    </select>
                                                    <small class="text-danger" v-if="errors.product_category">{{ errors.category_id[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Product Supplier</label>
                                                    <select class="form-control"  v-model="form.supplier_id">
                                                        <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
                                                    </select>
                                                    <small class="text-danger" v-if="errors.product_supplier">{{ errors.supplier_id[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <label>Product Root</label>
                                                    <input type="text" class="form-control" v-model="form.root" placeholder="Product Root">
                                                    <small class="text-danger" v-if="errors.root">{{ errors.root[0] }}</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Buying Price</label>
                                                    <input type="text" class="form-control" v-model="form.buying_price" placeholder="Buying Price">
                                                    <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Selling Price</label>
                                                    <input type="text" class="form-control" v-model="form.selling_price" placeholder="Selling Price">
                                                    <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label>Buying Date</label>
                                                    <input type="date" class="form-control" v-model="form.buying_date">
                                                    <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0] }}</small>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Product Quantity</label>
                                                    <input type="text" class="form-control" v-model="form.product_quantity" placeholder="Product Quantity">
                                                    <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0] }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="ProductPhoto" @change="onFileSelected" accept="image/x-png,image/gif,image/jpeg">
                                                        <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
                                                        <label class="custom-file-label" for="ProductPhoto">Photo</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.image" alt="" style="height: 40px; width: 40px;">
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

            //Load Categories
            axios.get('/api/category')
                .then(( {data} ) => (this.categories = data))
                .catch(error => console.log(error.response.data.errors));

            //Load Suppliers
            axios.get('/api/supplier')
                .then(( {data} ) => (this.suppliers = data))
                .catch(error => console.log(error.response.data.errors));
        },

        data(){
            return{
                form: {
                    product_name: null,
                    product_code: null,
                    category_id: null,
                    supplier_id: null,
                    product_category: null,
                    product_supplier: null,
                    root: null,
                    buying_price: null,
                    selling_price: null,
                    buying_date: null,
                    product_quantity: null,
                    image: null,
                },
                errors: {},
                categories: {},
                suppliers: {},
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
                        this.form.image = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            },

            productInsert() {
                axios.post('/api/product', this.form)
                    .then(() => {
                        this.$router.push({ name: 'index-product' });
                        Notifications.success();
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },

        }
    }
</script>

<style type="text/css">

</style>
