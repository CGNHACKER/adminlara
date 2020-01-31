export default class Gate {

    constructor(user){
        this.user = user
    }

    isAdmin(){
        return  this.user.role_id === 1;
    }
    
    isApprover(){
        return  this.user.role_id === 2;
    }

    isUser(){
        return  this.user.role_id === 3;
    }

    isAdminOrApprover(){
        if(this.user.role_id === 1 || this.user.role_id === 2){
            return true;
        }
    }

    isApproverOrUser(){
        if(this.user.role_id === 2 || this.user.role_id === 3){
            return true;
        }
    }
}