<style>
    .widget-user-header {
        background-position :center center;
        background-size :cover;
    }
</style>

<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white" style="background-image: url('./img/204359.jpg');">
                    <h3 class="widget-user-username text-right">Prasit Heempong</h3>
                    <h5 class="widget-user-desc text-right">Software Developer</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" :src="GetProfileImage()" alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">3,200</h5>
                        <span class="description-text">SALES</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                        <h5 class="description-header">13,000</h5>
                        <span class="description-text">FOLLOWERS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.widget-user -->
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                        <div class="tab-pane" id="activity">
                            <!-- Post -->
                            <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="" alt="user image">
                                <span class="username">
                                <a href="#">Jonathan Burke Jr.</a>
                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                                <a href="#" class="link-black text-sm">
                                    <i class="far fa-comments mr-1"></i> Comments (5)
                                </a>
                                </span>
                            </p>

                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                            </div>
                            <!-- /.post -->

                            <!-- Post -->
                            <div class="post clearfix">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="" alt="User Image">
                                <span class="username">
                                <a href="#">Sarah Ross</a>
                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Sent you a message - 3 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <form class="form-horizontal">
                                <div class="input-group input-group-sm mb-0">
                                <input class="form-control form-control-sm" placeholder="Response">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-danger">Send</button>
                                </div>
                                </div>
                            </form>
                            </div>
                            <!-- /.post -->

                            <!-- Post -->
                            <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="" alt="User Image">
                                <span class="username">
                                <a href="#">Adam Jones</a>
                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                </span>
                                <span class="description">Posted 5 photos - 5 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                <img class="img-fluid" src="" alt="Photo">
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <img class="img-fluid mb-3" src="" alt="Photo">
                                    <img class="img-fluid" src="" alt="Photo">
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-6">
                                    <img class="img-fluid mb-3" src="" alt="Photo">
                                    <img class="img-fluid" src="" alt="Photo">
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                                <a href="#" class="link-black text-sm">
                                    <i class="far fa-comments mr-1"></i> Comments (5)
                                </a>
                                </span>
                            </p>

                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                            </div>
                            <!-- /.post -->
                        </div>

                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" v-model="form.name" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" v-model="form.email" :class="{'is-invalid' : form.errors.has('email')}">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName2" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="password" name="password" placeholder="password" v-model="form.password" :class="{'is-invalid' : form.errors.has('password')}">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Nickname</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nickname" name="nickname" v-model="form.nickname" :class="{'is-invalid' : form.errors.has('nickname')}">
                                    <has-error :form="form" field="nickname"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputSkills" class="col-sm-2 col-form-label">Department</label>
                                <div class="col-sm-10">
                                    <select name="department_id" id="department_id" v-model="form.department_id" class="form-control" :class="{ 'is_invalid' : form.errors.has('department_id')}">
                                        <option value="1">IT Revolution</option>
                                        <option value="2">Sales</option>
                                    </select>
                                    <has-error :form="form" field="department_id"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputSkills" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <select name="role_id" id="role_id" v-model="form.role_id" class="form-control" :class="{ 'is_invalid' : form.errors.has('role_id')}">
                                        <option value="1">Administrator</option>
                                        <option value="2">Approver</option>
                                        <option value="3">User</option>
                                    </select>
                                    <has-error :form="form" field="role_id"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputSkills" class="col-sm-2 col-form-label">Photo Profile</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="photo" id="photo" @change="UpdateProfileImage">
                                    <has-error :form="form" field="role_id"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                <button @click.prevent="UpdateProfile" type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form : new Form({
                    id : 0,
                    name : '',
                    email : '',
                    password : '',
                    nickname : '',
                    department_id : 0,
                    role_id : 0,
                    photo : ''
                })
            }
        },
        created(){
            
            axios.get('api/profile')
            .then(response => {
                this.form.fill(response.data)
            });

            // fire.$on('aftercreate',() => {
            //     axios.get('api/profile')
            //     .then(response => {
            //         this.form.fill(response.data)
            //     });
            // });
        },
        methods : {
            GetProfileImage(){
                let photo = this.form.photo.length > 200 ? this.form.photo : 'img/profile/'+this.form.photo
                return photo
                // let prefix = (this.form.photo.match(/\//) ? '' : '/img/profile/');
                // return prefix + this.form.photo;
            },
            UpdateProfile(){
                this.$Progress.start();
                this.form.put('api/profile')
                .then(() => {
                    fire.$emit('aftercreate')
                    this.$Progress.finished();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            UpdateProfileImage(event){
                let file = event.target.files[0];
                let reader = new FileReader()

                if(file['size'] <= 400000){
                    reader.onloadend = (file) => {
                        this.form.photo = reader.result
                    }
                    reader.readAsDataURL(file);
                }else{
                    swal.fire({
                        icon : 'error',
                        title : 'Maximum file not allow'
                    })
                }
            }
        }
    }
</script>
