<template>
    <div class="login-box">
  <div class="login-logo">
    <a href="#"><b>ID</b> Gobig</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Đăng nhập để truy cập hệ thống</p>
    <div>
      <div class="form-group has-feedback">
        <input type="email" @keyup.enter="submit" v-model="data.email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" @keyup.enter="submit" v-model="data.password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row" style="text-align: center;">
          <button type="submit" class="btn btn-primary btn-flat" @click="submit">Đăng nhập</button>
      </div>
    </div>
  </div>
  <!-- /.login-box-body -->
</div>
</template>

<script>
import UserRepository from '@/repositories/UserRepository'

export default {
  metaInfo: {
    title: 'Đang nhập | ID Gobig',
  },
  data: () => ({
    data : {
    	email: null,
    	password: null,
    }
  }),
  methods: {
    submit() {
      UserRepository.login(this.data)
      .then(response=> {
        switch(response.status) {
            case 1: 
                this.$helper.user.saveAccessToken(response.data.access_token, response.data.exp);
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