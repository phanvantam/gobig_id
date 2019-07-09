<template>
	<div class="modal modal_sc1" id="project-add">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <!-- Modal Header -->
	            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
	                <h4 class="modal-title">Thêm mới chức vụ</h4>
	            </div>
	            <!-- Modal body -->
	            <div class="modal-body">
	                <div class="form-group">
	                    <label for="">Tên:</label>
	                    <input type="text" v-model="data.name" class="form-control">
	                </div>
                    <div class="form-group">
                        <label for="">Key:</label>
                        <input type="text" v-model="data.key" class="form-control">
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
            key: null, 
        }
    }),
    methods: {
        submit() {
        	PermissionRepository.positionAdd(this.data)
            .then(response=> {
                switch(response.status) {
                    case 1: 
                        $(this.$el).find('.close-modal').click();
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