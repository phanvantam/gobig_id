<template>
	<div class="modal modal_sc1" id="user-add">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <!-- Modal Header -->
	            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Thêm mới người dùng</h4>
	            </div>
	            <!-- Modal body -->
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="">Họ và tên:</label>
	                    <input type="text" v-model="data.fullname" class="form-control">
	                </div>
                    <div class="form-group">
                        <label for="">Email:</label>
                        <input type="email" v-model="data.email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Mật khẩu:</label>
                        <span class="help-block">*Tối thiểu tám ký tự, ít nhất một chữ cái và một số</span>
                        <input type="password" v-model="data.password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Quản lý:</label>
                        <input type="text" placeholder="Nhập tên hoặc email để tìm kiếm" @keyup.enter="getData" v-model="component.search_master" class="form-control">
                        <select class="form-control" v-model="data.master_id">
                            <option value="0">-- Chọn người quản lý --</option>
                            <option v-for="item in component.master_users" :value="item.id">{{ item.fullname }} - {{ item.email }}</option>
                        </select>
                    </div>
	            </div>
	            <!-- Modal footer -->
	            <div class="modal-footer">
	                <button type="button" class="btn btn-danger close-modal pull-left" data-dismiss="modal">Close</button>
	                <button type="button" class="btn btn-connect pull-right" @click="submit()">Xác nhận</button>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
import UserRepository from '@/repositories/UserRepository';
import PermissionRepository from '@/repositories/PermissionRepository';

export default {
    data: ()=> ({
        data: {
            fullname: null, 
            email: null, 
            password: null,
            master_id: 0,	
        },
        component: {
            master_users: [],
            search_master: null
        }
    }),
    created() {
        this.getData();
    },
    methods: {
        async getData() {
            this.component.master_users = await UserRepository.search({query: this.component.search_master});
            this.data.master_id = 0;
        },
        submit() {
        	UserRepository.add(this.data)
            .then(response=> {
                switch(response.status) {
                    case 1: 
                        $(this.$el).find('.close-modal').click();
                        this.$emit('reload');
                        this.$notify({
                            text: 'Tạo mới người dùng thành công',
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