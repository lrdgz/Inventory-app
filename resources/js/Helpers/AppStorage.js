class AppStorage{

    storeToken(token){
        localStorage.setItem('token', token);
    }

    storeTokenUser(user){
        localStorage.setItem('user', user);
    }

    storeExpiresInUser(expires_in){
        localStorage.setItem('expires_in', expires_in);
    }

    store(token, user, expires_in){
        this.storeToken(token);
        this.storeTokenUser(user);
        this.storeExpiresInUser(expires_in);
    }

    clear(){
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        localStorage.removeItem('expires_in');
    }

    getToken(){
        localStorage.getItem('token');
    }

    getUser(){
        localStorage.getItem('user');
    }

    getExpiresIn(){
        localStorage.getItem('expires_in');
    }

}

export default AppStorage = new AppStorage();
