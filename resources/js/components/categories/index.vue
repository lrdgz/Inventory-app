<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <router-link to="/store-category" class="btn btn-primary">Add Category</router-link>
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
                                                <h6 class="m-0 font-weight-bold text-primary">Categories List</h6>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table align-items-center table-flush">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Code</th>
                                                            <th style="width: 200px;">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="category in filterSearch" :key="category.id">
                                                            <td>{{ category.category_name }}</td>
                                                            <td>{{ category.category_code }}</td>
                                                            <td>
                                                                <router-link :to="{ name: 'edit-category', params: { id: category.id } }" class="btn btn-sm btn-primary">Edit</router-link>
                                                                <a @click.prevent="deleteCategory(category.id)" href="#" class="btn btn-sm btn-danger">Delete</a>
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
            this.allCategories();
        },
        data(){
            return {
                categories: [],
                searchTerm: ''
            }
        },
        computed: {
            filterSearch(){
                return this.categories.filter(category => {
                    return category.category_name.match(this.searchTerm);
                });
            }
        },
        methods: {
            allCategories(){
                axios.get('/api/category/')
                    .then( ({data}) => (this.categories = data))
                    .catch()
            },
            deleteCategory(id){
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
                        axios.delete(`/api/category/${id}`)
                            .then( () => {
                                this.categories = this.categories.filter(category => {
                                    return category.id != id;
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
