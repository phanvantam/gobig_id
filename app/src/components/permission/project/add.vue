<template>
	<div class="modal modal_sc1" id="user-add">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <!-- Modal Header -->
	            <div class="modal-header">
	                <h4 class="modal-title">Thêm mới dự án</h4>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <!-- Modal body -->
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="">Tên:</label>
	                    <input type="text" v-model="data.name" class="form-control">
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
import PermissionRepository from '@/repositories/PermissionRepository'

export default {
    data: ()=> ({
        data: {
            name: null, 
        }
    }),
    methods: {
        submit() {
        	PermissionRepository.addProject(this.data)
            .then(response=> {
                switch(response.status) {
                    case 1: 
                        this.$emit('reload');
                        this.$notify({
                            text: 'Thêm mới thành công',
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