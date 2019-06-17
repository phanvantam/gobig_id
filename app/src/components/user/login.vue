<template>
    <div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <div>
      <div class="form-group has-feedback">
        <input type="email" v-model="data.email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" v-model="data.password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"  @click="submit">Đăng nhập</button>
        </div>
        <!-- /.col -->
      </div>
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
</template>

<script>
import UserRepository from '@/repositories/UserRepository'
import HelperIndex from '@/helper/index';

export default {
  data: () => ({
    data : {
    	email: null,
    	password: null,
    }
  }),
  components: {},
  watch: {},
  created() {
  },
  methods: {
    submit() {
      UserRepository.login(this.data)
      .then(response=> {
        switch(response.status) {
            case 1: 
                HelperIndex.saveAccessToken(response.data.access_token, response.data.exp);
                this.$notify({
                    text: 'Đăng nhập thành công',
                    type: 'success'
                });
                this.$router.push({name: 'user'});
            break;
            case 0:
            	if(response.messages === null) {
            		this.$notify({
	                        text: 'Sai tài khoản hoặc mật khẩu',
	                        type: 'error'
	                    })
            	} else {
            		response.messages.list.map(value=> {
	                    this.$notify({
	                        text: value,
	                        type: 'error'
	                    })
	                })
            	}
            break;
        }
      });
    }
  }
}

</script>