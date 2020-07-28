<template>

</template>

<script type="application/javascript">
    export default {
        created() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            localStorage.removeItem('expires_in');

            Toast.fire({
                icon: 'success',
                title: 'Logout successfully'
            });

            this.$router.push({ name: '/' });
        }
    }
</script>

<style type="text/css">

</style>
