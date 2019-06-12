<template>
	<div id="login">
        <img class="imgs-login" src="https://gobig.com.vn/wp-content/uploads/2018/10/slide-gobig-1.jpg">
        <div class="login-box">
            <div class="login-logo">
                <a href=""><img src="https://gobig.com.vn/wp-content/uploads/2018/09/logo-web-gobig-300x144.jpg" alt=""></a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg"><strong>Đăng nhập để bắt đầu hệ thống của bạn</strong></p>
                <form action="" method="post">
                    <input type="hidden" class="action" value="login">
                    <div class="form-group has-feedback">
                        <div class="form-login-registration">
                            <i class="fa fa-user"></i>
                            <input v-model="data.email" type="text" name="usename" id="usename" placeholder="Tên đăng nhập..." class="form-control input-form-login-registration">
                        </div>
                        
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="form-login-registration">
                             <i class="fa fa-lock"></i>
                            <input v-model="data.password" type="password" name="password" id="password" placeholder="Mật khẩu..." class="form-control input-form-login-registration">
                        </div>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="note-registration">
                        <span>Bạn chưa có tài khoản <a href="">Đăng ký</a></span>
                    </div>
                    <div class="row row-checkbox">
                        <div class="">
                            <div class="checkbox icheck">
                                <label for="">
                                    <input type="checkbox" style="vertical-align: middle">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                        </div>
                        <div class="">
                            <span class="btn btn-connect" @click="submit" >Đăng nhập</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="overlay"></div>
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
                    text: 'Đăng nhập thành thành công',
                    type: 'success'
                });
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