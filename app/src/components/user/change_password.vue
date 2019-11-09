<template>
	<div class="modal modal_sc1" id="user-change-password">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <!-- Modal Header -->
	            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Đổi mật khẩu</h4>
	            </div>
	            <!-- Modal body -->
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="">Mật khẩu hiện tại:</label>
	                    <input type="password" v-model="data.password_old" class="form-control">
	                </div>
                    <div class="form-group">
                        <label for="">Mật khấu mới:</label>
                        <input type="password" v-model="data.password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Xác nhận mật khẩu mới:</label>
                        <input type="password" v-model="data.password_confirm" class="form-control">
                    </div>
	            </div>
	            <!-- Modal footer -->
	            <div class="modal-footer">
	                <button type="button" class="btn btn-danger close-modal pull-left" data-dismiss="modal">Close</button>
	                <button type="button" class="btn btn-primary pull-right" @click="submit()">Xác nhận</button>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
import UserRepository from '@/repositories/UserRepository';

export default {
    data: ()=> ({
        data: {
            password_old: null, 
            password: null,
            password_confirm: null
        },
    }),
    methods: {
        submit() {
        	UserRepository.profileUpdatePassword(this.data)
              .then(response=> {
                switch(response.status) {
                    case 1: 
                        this.$notify({
                            text: 'Cập nhật mật khẩu thành công',
                            type: 'success'
                        });
                    break;
                    case 0:
                        response.messages.list.map(value=> {
                            this.$notify({
                                text: value,
                                type: 'error'
                            })
                        });
                    break;
                }
            })
        }
    }
}
</script>