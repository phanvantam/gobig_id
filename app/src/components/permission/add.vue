<template>
	<div class="modal modal_sc1" id="user-add">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <!-- Modal Header -->
	            <div class="modal-header">
	                <h4 class="modal-title">Thêm mới quyền</h4>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <!-- Modal body -->
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="">Tên:</label>
	                    <input type="text" v-model="data.fullname" class="form-control">
	                </div>
                    <div class="form-group">
                        <label for="">Dự án:</label>
                        <select class="form-control">
                            <option>Chatbot</option>
                            <option>Kho</option>
                        </select>
                    </div>
                    <div class="form-group list-module">
                        
                    </div>
	            </div>
	            <!-- Modal footer -->
	            <div class="modal-footer">
	                <button type="button" class="btn btn-connect pull-left" @click="submit()">Xác nhận</button>
	                <button type="button" class="btn btn-danger close-modal" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
import UserRepository from '@/repositories/UserRepository'

export default {
    data: ()=> ({
        data: {
            fullname: null, 
            email: null, 
            password: null,	
        }
    }),
    created() {
    },
    methods: {
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